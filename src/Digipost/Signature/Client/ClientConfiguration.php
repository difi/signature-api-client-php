<?php

namespace Digipost\Signature\Client;

use Digipost\Signature\Client\ASiCe\ASiCEConfiguration;
use Digipost\Signature\Client\ASiCe\DocumentBundleProcessor;
use Digipost\Signature\Client\ASiCe\DumpDocumentBundleToDisk;
use Digipost\Signature\Client\Core\Internal\Http\ClientConfig;
use Digipost\Signature\Client\Core\Internal\Http\AddRequestHeaderFilter;
use Digipost\Signature\Client\Core\Internal\Http\HttpIntegrationConfiguration;
use Digipost\Signature\Client\Core\Internal\Security\ProvidesCertificateResourcePaths;
use Digipost\Signature\Client\Core\Internal\XML\JaxbMessageReaderWriterProvider;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Security\KeyStoreConfig;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Psr7\Uri as URI;
use Psr\Http\Message\ResponseInterface;

class ClientConfiguration implements ProvidesCertificateResourcePaths,
                                     HttpIntegrationConfiguration,
                                     ASiCEConfiguration {

  //private static final Logger LOG = LoggerFactory::getLogger(ClientConfiguration::class);

  /**
   * The {@link HttpHeaders#USER_AGENT User-Agent} header which will be
   * included in all requests. You may include a custom part using
   * {@link ClientConfigurationBuilder}.
   */
  static $MANDATORY_USER_AGENT;

  /**
   * {@value #HTTP_REQUEST_RESPONSE_LOGGER_NAME} is the name of the logger
   * which will log the HTTP requests and responses, if enabled with
   * {@link ClientConfiguration#builder}.
   */
  static $HTTP_REQUEST_RESPONSE_LOGGER_NAME = "no.digipost.signature.client.http.requestresponse";

  /**
   * Socket timeout is used for both requests and, if any,
   * underlying layered sockets (typically for
   * secure sockets). The default value is {@value DEFAULT_SOCKET_TIMEOUT_MS}
   * ms.
   */
  const DEFAULT_SOCKET_TIMEOUT_MS = 10000;

  /**
   * The default connect timeout for requests:
   * {@value #DEFAULT_CONNECT_TIMEOUT_MS} ms.
   */
  const DEFAULT_CONNECT_TIMEOUT_MS = 10000;

  /**
   * @var ClientConfig
   */
  private $guzzleConfig;

  /**
   * @var KeyStoreConfig
   */
  private $keyStoreConfig;

  /**
   * @var array<String>
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
   * @var array<DocumentBundleProcessor>
   */
  private $documentBundleProcessors;

  /**
   * @var \DateTime
   */
  private $clock;

  function __staticInit() {
    self::$MANDATORY_USER_AGENT = "Posten signering PHP API Client/" . ClientMetadata::$VERSION . " (PHP " . PHP_VERSION . ")";

  }

  function __construct(
    KeyStoreConfig $keyStoreConfig,
    ClientConfig $guzzleConfig,
    Sender $sender,
    URI $serviceRoot,
    $certificatePaths,
    $documentBundleProcessors,
    \DateTime $clock) {

    $this->keyStoreConfig = $keyStoreConfig;
    $this->guzzleConfig = $guzzleConfig;
    $this->sender = $sender;
    $this->signatureServiceRoot = $serviceRoot;
    $this->certificatePaths = $certificatePaths;
    $this->documentBundleProcessors = $documentBundleProcessors;
    $this->clock = $clock;
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

  public function getSSLContext() {
    $context = stream_context_create([
                                       'ssl' => [
                                         //'local_cert' => $this->keyStoreConfig->getCertificate(),
                                         //'local_pk' => $this->keyStoreConfig->getPrivateKey(),
                                         //'passphrase' => $this->keyStoreConfig->privatekeyPassword,
                                         //'peer_name' => '',
                                         //'peer_fingerprint' => '',
                                         //'verify_peer' => '',
                                         //'verify_peer_name' => TRUE,
                                         //'allow_self_signed' => FALSE,
                                         //'verify_depth' => 0,
                                         'capath' => '/home/bendik/test',
                                       ],
                                     ]);
    return $context;
    //try {
    //        return SSLContexts.custom()
    //                .loadKeyMaterial(keyStoreConfig.keyStore,
    //                                 keyStoreConfig.privatekeyPassword.toCharArray(),
    //                                 new PrivateKeyStrategy() {
    //                    @Override
    //                    public String chooseAlias(Map<String, PrivateKeyDetails> aliases, Socket socket) {
    //                        return keyStoreConfig.alias;
    //                    }
    //                })
    //                .loadTrustMaterial(TrustStoreLoader.build(this), new PostenEnterpriseCertificateStrategy())
    //                .build();
    //        } catch (NoSuchAlgorithmException | KeyManagementException | KeyStoreException | UnrecoverableKeyException e) {
    //            if (e instanceof UnrecoverableKeyException && "Given final block not properly padded".equals(e.getMessage())) {
    //                throw new KeyException(
    //                        "Unable to load key from keystore, because " + e.getClass().getSimpleName() + ": '" + e.getMessage() + "'. Possible causes:\n" +
    //                        "* Wrong password for private key (the password for the keystore and the private key may not be the same)\n" +
    //                        "* Multiple private keys in the keystore with different passwords (private keys in the same key store must have the same password)", e);
    //            } else {
    //                throw new KeyException("Unable to create the SSLContext, because " + e.getClass().getSimpleName() + ": '" + e.getMessage() + "'", e);
    //            }
    //        }
    //}
  }


  /**
   * Build a new {@link ClientConfiguration}.
   *
   * @param KeyStoreConfig $keystoreConfig
   *
   * @return ClientConfigurationBuilder
   */
  public static function builder(KeyStoreConfig $keystoreConfig) {

    return new ClientConfigurationBuilder($keystoreConfig);
  }
}

class ClientConfigurationBuilder {

  /**
   * @var ClientConfig
   */
  private $guzzleConfig;

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
   * @var array<String>
   */
  private $certificatePaths;

  /**
   * @var null
   */
  private $loggingFeature = NULL;

  /**
   * @var array<DocumentBundleProcessor>
   */
  private $documentBundleProcessors = [];

  private $clock;

  /**
   * ClientConfigurationBuilder constructor.
   *
   * @param KeyStoreConfig $keyStoreConfig
   */
  function __construct(KeyStoreConfig $keyStoreConfig) {
    $this->serviceRoot = ServiceUri::DIFI_TEST()->uri();
    $this->certificatePaths = Certificates::TEST()->certificatePaths();
    $this->keyStoreConfig = $keyStoreConfig;
    $this->guzzleConfig = new ClientConfig();

    $this->clock = new \DateTime();
  }

  /**
   * Set the service URI to one of the predefined environments.
   */
  //public function serviceUri(ServiceUri $environment) {
  //  return serviceUri($environment . $this->uri);
  //}

  /**
   * Override the service endpoint URI to a custom environment.
   */
  public function serviceUri(URI $uri) {
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

  public function trustStore($certificates) {
    if ($certificates instanceof Certificates) {
      if ($certificates === Certificates::TEST()) {
        trigger_error('Using test certificates in trust store. This should never be done for production environments.',
                      E_USER_WARNING);
      }
      return $this->setCertificatePaths($certificates->certificatePaths());
    }

    return $this->setCertificatePaths($certificates);
  }

  private function setCertificatePaths(array $certificatePaths) {
    $this->certificatePaths = $certificatePaths;
    return $this;
  }

  /**
   * Set the sender used globally for every signature job.
   * <p>
   * Use
   * {@link no.digipost.signature.client.portal.PortalJob.Builder#withSender(Sender)} or {@link no.digipost.signature.client.direct.DirectJob.Builder#withSender(Sender)} if you need to specify different senders per signature job (typically when acting as a broker on behalf of multiple other organizations)
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
   * Customize the {@link HttpHeaders#USER_AGENT User-Agent} header value
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
   * {@link ClientConfiguration#HTTP_REQUEST_RESPONSE_LOGGER_NAME}.
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
   * <pre>{@code timestamp-[reference_from_job-]asice.zip}</pre>
   * The <em>timestamp</em> part may use a clock of your choosing, make
   * sure to override the system clock with
   * {@link #usingClock(Clock)} before calling this method if that is
   * desired.
   * <p>
   * The <em>reference_from_job</em> part is only included if the job is
   * given such a reference using
   * {@link no.digipost.signature.client.direct.DirectJob.Builder#withReference(UUID) DirectJob.Builder.withReference(..)} or {@link no.digipost.signature.client.portal.PortalJob.Builder#withReference(UUID) PortalJob.Builder.withReference(..)}.
   *
   * @param String $directory The directory to dump to. This directory must
   *                          already exist, or creating new signature jobs will fail.
   *                          Miserably.
   *
   * @return ClientConfigurationBuilder
   */
  public function enableDocumentBundleDiskDump(String $directory) {
    return $this->addDocumentBundleProcessor(new DumpDocumentBundleToDisk($directory,
                                                                          $this->clock));
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
   * @param DocumentBundleProcessor $processor the {@link DocumentBundleProcessor} which will be
   *        passed the generated zipped document bundle together with the
   *        {@link SignatureJob job} it was created for.
   *
   * @return ClientConfigurationBuilder
   */
  public function addDocumentBundleProcessor(DocumentBundleProcessor $processor) {
    $this->documentBundleProcessors[] = $processor;
    return $this;
  }

  /**
   * This methods allows for custom configuration of JAX-RS (i.e. Jersey)
   * if anything is needed that is not already supported by the
   * {@link ClientConfiguration#Builder}. This method should not be used
   * to configure anything that is already directly supported by the
   * {@code ClientConfiguration#Builder} API.
   * <p>
   * If you still need to use this method, consider requesting
   * first-class support for your requirement on the library's [web
   * site on GitHub](https://github.com/digipost/signature-api-client-java/issues)
   *
   * @param Consumer $customizer
   *        The operations to do on the JAX-RS {@link Configurable}, e.g.
   *        {@link Configurable#register registering components}.
   *
   * @return ClientConfigurationBuilder
   */
  public function customizeJaxRs(Consumer $customizer) {
    $customizer->accept($this->guzzleConfig);
    return $this;
  }

  /**
   * Allows for overriding which {@link Clock} is used to convert between
   * Java and XML, may be useful for e.g. automated tests.
   * <p>
   * Uses {@link Clock#systemDefaultZone() the best available system
   * clock} if not specified.
   *
   * @param \DateTime $clock
   *
   * @return ClientConfigurationBuilder
   */
  public function usingClock(\DateTime $clock) {
    $this->clock = $clock;
    return $this;
  }

  public function build(): ClientConfiguration {
    $this->guzzleConfig->property(RequestOptions::READ_TIMEOUT,
                                  $this->socketTimeoutMs);
    $this->guzzleConfig->property(RequestOptions::CONNECT_TIMEOUT,
                                  $this->connectTimeoutMs);

    //$this->guzzleConfig->register(MultiPartFeature::class);
    //$this->guzzleConfig->property(RequestOptions::MULTIPART, []);
    //$this->guzzleConfig->register(JaxbMessageReaderWriterProvider::class);
    //$this->guzzleConfig->property(RequestOptions::CERT, '/etc/ssl/certs/ca-certificates.crt');
    //$this->guzzleConfig->property(RequestOptions::SSL_KEY, ['/home/bendik/test/smt_test.pem', 'bvWsmJm8hbNxNj9L']);
    $this->guzzleConfig->property(RequestOptions::CERT, [ realpath(__DIR__ . '/../../../../') . '/server.pem', 'bvWsmJm8hbNxNj9L']);
    //$this->guzzleConfig->property(RequestOptions::VERIFY, '/home/bendik/test/65B87D623677DF62A77E9604A4719610A1063455.pem');
    $this->guzzleConfig->property(RequestOptions::VERIFY, false);
    $this->guzzleConfig->registerResponseHandler(function (ResponseInterface $response) {
      return $response->withHeader('User-Agent',
                                   $this->createUserAgentString());
    });


    //$this->loggingFeature->ifPresent($this->guzzleConfig::register);
    return new ClientConfiguration($this->keyStoreConfig,
                                   $this->guzzleConfig,
                                   $this->globalSender,
                                   $this->serviceRoot,
                                   $this->certificatePaths,
                                   $this->documentBundleProcessors,
                                   $this->clock);
  }

  function createUserAgentString() {
    return ClientConfiguration::$MANDATORY_USER_AGENT . $this->customUserAgentPart ? sprintf(" (%s)",
                                                                                            $this->customUserAgentPart) : '';
  }
}
