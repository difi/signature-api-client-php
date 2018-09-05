<?php

namespace Digipost\Signature\Client;

use Digipost\Signature\Client\ASiCe\ASiCEConfiguration;
use Digipost\Signature\Client\ASiCe\DocumentBundleProcessor;
use Digipost\Signature\Client\Core\Internal\Http\AddRequestHeaderFilter;
use Digipost\Signature\Client\Core\Internal\Http\ClientGuzzleConfig;
use Digipost\Signature\Client\Core\Internal\Http\HttpIntegrationConfiguration;
use Digipost\Signature\Client\Core\Internal\Http\PostenEnterpriseCertificateStrategy;
use Digipost\Signature\Client\Core\Internal\Security\ProvidesCertificateResourcePaths;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Security\KeyStoreConfig;
use Digipost\Signature\Event\ConfigureClientEvent;
use GuzzleHttp\Psr7\Uri as URI;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\TransferStats;
use Sop\CryptoEncoding\PEM;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use X509\Certificate\CertificateChain;

class ClientConfiguration implements ProvidesCertificateResourcePaths,
                                     HttpIntegrationConfiguration,
                                     ASiCEConfiguration {

  /**
   * The `User-Agent` header which will be included in all requests. You may include a custom part
   * using {@link ClientConfigurationBuilder::includeInUserAgent() ->includeInUserAgent(String)}.
   */
  static $MANDATORY_USER_AGENT;

  /**
   * `HTTP_REQUEST_RESPONSE_LOGGER_NAME` is the name of the logger which will log the HTTP requests
   * and responses, if enabled with
   * {@link ClientConfiguration::builder}.
   */
  static $HTTP_REQUEST_RESPONSE_LOGGER_NAME = "no.digipost.signature.client.http.requestresponse";

  /**
   * Socket timeout is used for both requests and, if any,
   * underlying layered sockets (typically for
   * secure sockets).
   */
  const DEFAULT_SOCKET_TIMEOUT_MS = 10000;

  /**
   * The default connect timeout for requests.
   */
  const DEFAULT_CONNECT_TIMEOUT_MS = 10000;

  /**
   * @var ClientGuzzleConfig
   */
  private $guzzleConfig;

  /**
   * @var KeyStoreConfig
   */
  private $keyStoreConfig;

  /**
   * @var EventDispatcherInterface
   */
  private $eventDispatcher;

  /**
   * @var String[]
   */
  private $certificatePaths;

  /**
   * @var Sender
   */
  private $sender;

  /**
   * @var URI
   */
  private $signatureServiceRoot;

  /**
   * @var DocumentBundleProcessor[]
   */
  private $documentBundleProcessors;

  /**
   * @var \DateTime
   */
  private $clock;

  /** @var ContainerInterface */
  private $container;

  public static function __staticInit() {
    self::$MANDATORY_USER_AGENT =
      "Posten signering PHP API Client/" . ClientMetadata::$VERSION . " (PHP " . PHP_VERSION . ")";
  }

  function __construct(
    KeyStoreConfig $keyStoreConfig,
    ClientGuzzleConfig $guzzleConfig,
    ContainerInterface $container,
    Sender $sender = NULL,
    URI $serviceRoot = NULL,
    $certificatePaths = NULL,
    $documentBundleProcessors = NULL,
    \DateTime $clock = NULL
  ) {
    $this->keyStoreConfig = $keyStoreConfig;
    $this->guzzleConfig = $guzzleConfig;
    $this->container = $container;
    $this->eventDispatcher = $container->get('digipost_signature.event_dispatcher');
    $this->sender = $sender;
    $this->signatureServiceRoot = $serviceRoot;
    $this->certificatePaths = $certificatePaths;
    $this->documentBundleProcessors = $documentBundleProcessors;
    $this->clock = $clock;

    $event = new ConfigureClientEvent($this);
    $this->eventDispatcher->dispatch('client.configure', $event);
  }

  public function getKeyStoreConfig(): KeyStoreConfig {
    return $this->keyStoreConfig;
  }

  public function getGlobalSender(): Sender {
    return $this->sender;
  }

  public function getDocumentBundleProcessors() {
    return $this->documentBundleProcessors;
  }

  public function getClock(): \DateTime {
    return $this->clock;
  }

  public function getServiceRoot(): URI {
    return $this->signatureServiceRoot;
  }

  public function getCertificatePaths() {
    return $this->certificatePaths;
  }

  public function getGuzzleConfiguration(): array {
    return $this->guzzleConfig->getConfiguration();
  }

  /**
   * @return ClientGuzzleConfig
   */
  public function getGuzzle(): ClientGuzzleConfig {
    return $this->guzzleConfig;
  }

  /**
   * @return ContainerInterface
   */
  public function getContainer(): ContainerInterface {
    return $this->container;
  }

  public function getSSLContext() {
    $context = stream_context_create(
      [
        'ssl' => [
        ],
      ]
    );

    return $context;
  }

  /**
   * Build a new {@link ClientConfiguration}.
   *
   * @param ContainerInterface $container
   * @param KeyStoreConfig     $keystoreConfig
   *
   * @return ClientConfigurationBuilder
   */
  public static function builder(
    ContainerInterface $container,
    KeyStoreConfig $keystoreConfig
  ) {
    return new ClientConfigurationBuilder($container, $keystoreConfig);
  }
}

class ClientConfigurationBuilder {

  /** @var ContainerInterface */
  protected $container;

  /**
   * @var ClientGuzzleConfig
   */
  private $guzzleConfig;

  /**
   * @var EventDispatcherInterface
   */
  private $eventDispatcher;

  /**
   * @var KeyStoreConfig
   */
  private $keyStoreConfig;

  private $socketTimeoutMs = ClientConfiguration::DEFAULT_SOCKET_TIMEOUT_MS;

  private $connectTimeoutMs = ClientConfiguration::DEFAULT_CONNECT_TIMEOUT_MS;

  /**
   * @var String
   */
  private $customUserAgentPart = NULL;

  /**
   * @var URI
   */
  private $serviceRoot;

  /**
   * @var Sender
   */
  private $globalSender = NULL;

  /**
   * @var String[]
   */
  private $certificatePaths;

  /**
   * @var DocumentBundleProcessor[]
   */
  private $documentBundleProcessors = [];

  /**
   * @var \DateTime
   */
  private $clock;

  /**
   * ClientConfigurationBuilder constructor.
   *
   * @param ContainerInterface $container
   * @param KeyStoreConfig     $keyStoreConfig
   */
  function __construct(
    ContainerInterface $container,
    KeyStoreConfig $keyStoreConfig
  ) {
    $this->container = $container;
    $this->serviceRoot = ServiceUri::PRODUCTION()->uri();
    //$this->certificatePaths = Certificates::PRODUCTION()->certificatePaths();
    $this->trustStore(Certificates::PRODUCTION());
    $this->keyStoreConfig = $keyStoreConfig;
    $this->guzzleConfig = $container->get(
      'digipost_signature.client_guzzle_config'
    );
    $this->eventDispatcher = $container->get('digipost_signature.event_dispatcher');

    $this->clock = new \DateTime();
  }

  /**
   * Set the service URI to one of the predefined environments.
   *
   * @param ServiceUri $environment
   *
   * @return ClientConfigurationBuilder
   */
  public function serviceUri(ServiceUri $environment) {
    return $this->serviceRoot($environment->uri());
  }

  /**
   * Override the service endpoint URI to a custom environment.
   *
   * @param URI $uri
   *
   * @return ClientConfigurationBuilder
   */
  public function serviceRoot(URI $uri) {
    $this->serviceRoot = $uri;

    return $this;
  }

  /**
   * Override the
   * {@link ClientConfiguration::DEFAULT_CONNECT_TIMEOUT_MS default socket timeout value}.
   *
   * @param int $millis
   *
   * @return self
   */
  public function socketTimeoutMillis(int $millis) {
    $this->socketTimeoutMs = $millis;

    return $this;
  }

  /**
   * Override the
   * {@link ClientConfiguration::DEFAULT_CONNECT_TIMEOUT_MS default connect timeout value}.
   *
   * @param int $millis
   *
   * @return ClientConfigurationBuilder
   */
  public function connectTimeoutMillis(int $millis) {
    $this->connectTimeoutMs = $millis;

    return $this;
  }

  /**
   * Override the trust store configuration to load DER-encoded certificates from the given
   * folder(s).
   *
   * @param Certificates|string[] $certificates
   *
   * @return ClientConfigurationBuilder
   */
  public function trustStore($certificates) {
    if ($certificates instanceof Certificates) {
      if ($certificates === Certificates::TEST()) {
        trigger_error(
          'Using test certificates in trust store. This should never be done for production environments.',
          E_USER_WARNING
        );
      }

      return $this->setCertificatePaths($certificates->certificatePaths());
    }

    return $this->setCertificatePaths($certificates);
  }

  private function getCertificatePaths(): array {
    return $this->certificatePaths;
  }

  private function setCertificatePaths(array $certificatePaths) {
    $this->certificatePaths = $certificatePaths;

    return $this;
  }

  /**
   * Set the sender used globally for every signature job.
   * <p>
   * Use
   * {@link PortalJobBuilder::withSender() PortalJobBuilder->withSender(Sender)} or
   * {@link DirectJobBuilder::withSender() DirectJobBuilder->withSender(Sender)} if you need
   * to specify different senders per signature job (typically when acting as a broker on behalf of
   * multiple other organizations)
   *
   * @param Sender $sender
   *
   * @return ClientConfigurationBuilder
   */
  public function globalSender(Sender $sender) {
    $this->globalSender = $sender;

    return $this;
  }

  /**
   * Customize the `User-Agent` header value
   * to include the given string.
   *
   * @param String $userAgentCustomPart
   *
   * @return ClientConfigurationBuilder
   */
  public function includeInUserAgent(String $userAgentCustomPart) {
    $this->customUserAgentPart = $userAgentCustomPart;

    return $this;
  }

  /**
   * Makes the client log the sent requests and received responses to the
   * logger named
   * {@link ClientConfiguration::HTTP_REQUEST_RESPONSE_LOGGER_NAME}.
   */
  public function enableRequestAndResponseLogging() {
    //loggingFeature = Optional . of(new LoggingFeature(java . util . logging . Logger . getLogger(HTTP_REQUEST_RESPONSE_LOGGER_NAME), 16 * 1024));
    return $this;
  }

  /**
   * Have the library dump the generated document bundle zip files to
   * disk before they are sent to the service to create signature jobs.
   * <p>
   * The files will be given names on the format
   * `timestamp-[reference_from_job-]asice.zip}`
   * The <em>timestamp</em> part may use a clock of your choosing, make
   * sure to override the system clock with
   * {@link ClientConfigurationBuilder::usingClock() #usingClock()} before calling this method if that is
   * desired.
   * <p>
   * The <em>reference_from_job</em> part is only included if the job is
   * given such a reference using
   * {@link DirectJobBuilder::withReference() DirectJobBuilder#withReference} or
   * {@link PortalJobBuilder::withReference() PortalJobBuilder#withReference}.
   *
   * @param String $directory The directory to dump to. This directory must
   *                          already exist, or creating new signature jobs
   *                          will fail. Miserably.
   *
   * @return ClientConfigurationBuilder
   */
  public function enableDocumentBundleDiskDump(String $directory) {
    $documentDumper = $this->container->get(
      'digipost_signature.asice.document_bundle_dumper'
    )->setup($directory, $this->clock);

    return $this->addDocumentBundleProcessor($documentDumper);
  }

  /**
   * Add a {@link DocumentBundleProcessor} which will be passed the
   * generated zipped document bundle together with the
   * {@link SignatureJob job} it was created for. The processor is not
   * responsible for closing the stream, as this is handled by the
   * library itself.
   *
   * ## A note on performance
   * The processor is free to do what it want with the passed stream, but
   * bear in mind that the time used by a processor adds to the
   * processing time to create signature jobs.
   *
   * @param DocumentBundleProcessor $processor the
   *                                           {@link DocumentBundleProcessor}
   *                                           which will be passed the
   *                                           generated zipped document bundle
   *                                           together with the
   *                                           {@link SignatureJob job} it was
   *                                           created for.
   *
   * @return ClientConfigurationBuilder
   */
  public function addDocumentBundleProcessor(DocumentBundleProcessor $processor
  ) {
    $this->documentBundleProcessors[] = $processor;

    return $this;
  }

  /**
   * Allows for overriding which {@link \DateTime Clock} is used to convert between
   * Java and XML, may be useful for e.g. automated tests.
   * <p>
   * Uses {@link \date_default_timezone_get() the best available system clock} if not specified.
   *
   * @param \DateTime $clock
   *
   * @return ClientConfigurationBuilder
   */
  public function usingClock(\DateTime $clock) {
    $this->clock = $clock;

    return $this;
  }

  /**
   * Set a {@link RequestOptions::ON_STATS ON_STATS} callback to Guzzle Client which is used to verify
   * the server certificate.
   */
  private function setTrustStrategy() {
    $trustStrategy = new PostenEnterpriseCertificateStrategy(
      $this->keyStoreConfig->keyStore, $this->eventDispatcher
    );
    $this->guzzleConfig->property(
      RequestOptions::ON_STATS,
      function (TransferStats $stats) use ($trustStrategy) {
        $certInfo = $stats->getHandlerStat('certinfo');
        $pems = array_map(
          function ($info) {
            return PEM::fromString($info['Cert']);
          }, $certInfo
        );
        $chain = CertificateChain::fromPEMs(...$pems);

        return $trustStrategy->isTrusted($chain);
      });
  }

  /**
   * @return ClientConfiguration
   */
  public function build(): ClientConfiguration {
    $this->guzzleConfig->property(
      RequestOptions::READ_TIMEOUT,
      $this->socketTimeoutMs
    );
    $this->guzzleConfig->property(
      RequestOptions::CONNECT_TIMEOUT,
      $this->connectTimeoutMs
    );

    $client_cert = $this->container->getParameter(
      'digipost_signature.keystore.client_cert'
    );
    $client_key = $this->container->getParameter(
      'digipost_signature.keystore.client_key'
    );
    $cert_passphrase = $this->container->getParameter(
      'digipost_signature.keystore.password'
    );
    $key_passphrase = $this->container->getParameter(
      'digipost_signature.keystore.key.password'
    );
    $ca_bundle_path = $this->container->getParameter(
      'digipost_signature.ca_bundle.path'
    );

    // Initialization
    Certificates::build($this->container, $ca_bundle_path);

    $this->guzzleConfig->property(
      RequestOptions::CERT, [$client_cert, $cert_passphrase]
    );
    $this->guzzleConfig->property(
      RequestOptions::SSL_KEY, [$client_key, $key_passphrase]
    );

    // TODO: The CA-bundle has a self-signed root certificate, so we need to verify manually
    $this->guzzleConfig->property(
      RequestOptions::VERIFY, Certificates::PRODUCTION()->getCABundle()
    );

    $this->guzzleConfig->registerRequestFilter(
      new AddRequestHeaderFilter('User-Agent', $this->createUserAgentString())
    );

    $this->setTrustStrategy();

    return new ClientConfiguration(
      $this->keyStoreConfig,
      $this->guzzleConfig,
      $this->container,
      $this->globalSender,
      $this->serviceRoot,
      $this->certificatePaths,
      $this->documentBundleProcessors,
      $this->clock
    );
  }

  public function createUserAgentString() {
    return ClientConfiguration::$MANDATORY_USER_AGENT . ($this->customUserAgentPart ? sprintf(
      " (%s)",
      $this->customUserAgentPart
    ) : '');
  }
}

ClientConfiguration::__staticInit();