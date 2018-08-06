<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

use ASN1\Exception\DecodeException;
use Digipost\Signature\Event\ConfigureGuzzleEvent;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\TransferStats;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Sop\CryptoEncoding\PEM;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use X509\Certificate\CertificateBundle;
use X509\CertificationPath\Exception\PathBuildingException;
use X509\CertificationPath\Exception\PathValidationException;
use X509\CertificationPath\PathBuilding\CertificationPathBuilder;
use X509\CertificationPath\PathValidation\PathValidationConfig;

class ClientGuzzleConfig {

  protected $config;

  protected $handlerStack;

  /** @var ContainerInterface */
  private $container;

  /** @var EventDispatcherInterface */
  private $dispatcher;

  /**
   * ClientGuzzleConfig constructor.
   *
   * @param ContainerInterface       $container
   * @param EventDispatcherInterface $eventDispatcher
   * @param array|null               $config
   */
  public function __construct(
    ContainerInterface $container,
    EventDispatcherInterface $eventDispatcher,
    array $config = []
  ) {
    $this->container = $container;
    $this->dispatcher = $eventDispatcher;
    $this->config = $config;
    $this->handlerStack = new HandlerStack();
    $this->setHandler(new GuzzleCurlHandler());

    $this->config['handler'] = $this->handlerStack;

    $this->handlerStack->push(
      Middleware::mapResponse(
        function (ResponseInterface $response) {
          return XMLResponse::fromResponse($response);
        }
      )
    );

    $this->handlerStack->push(
      Middleware::mapRequest(
        function (RequestInterface $request) {
          return $request
            ->withoutHeader('Content-Disposition')
            ->withoutHeader('Content-Length');
        }
      )
    );

    //$trustStrategy = $this->container->get('digipost_signature.certificate_trust_strategy');
    $this->dispatcher->dispatch('guzzle.configure', new ConfigureGuzzleEvent($this));

    //$trustStrategy = new \Digipost\Signature\Client\Core\Internal\Http\PostenEnterpriseCertificateStrategy();


    //$dispatcher = $this->container->get('digipost_signature.event_dispatcher');
    $this->config['on_stats'] = function(TransferStats $stats) {
      //$event = new GuzzleOnStatsEvent($this, $stats);
      //$this->dispatcher->dispatch('client.guzzle.on_stats', $event);
    };

    $this->config['on_stats'] = function (TransferStats $stats) {
      try {
        $certInfo = $stats->getHandlerStat('certinfo');
        $pemStrings = array_map(
          function ($info) {
            return $info['Cert'];
          }, $certInfo
        );

        $cert = \X509\Certificate\Certificate::fromPEM(PEM::fromString($pemStrings[0]));
        $trusted = new CertificateBundle(
          \X509\Certificate\Certificate::fromDER(
            file_get_contents(
              '/home/difi/drupal7/profiles/samarbeid2lukket/signature-api-client-php/src/Digipost/Signature/Resources/certificates/test/Buypass_Class_3_Test4_Root_CA.cer'
            )
          )
        );
        $intermediates = new CertificateBundle(
          \X509\Certificate\Certificate::fromDER(
            file_get_contents(
              '/home/difi/drupal7/profiles/samarbeid2lukket/signature-api-client-php/src/Digipost/Signature/Resources/certificates/test/Buypass_Class_3_Test4_CA_3.cer'
            )
          )
        );
        $path_builder = new CertificationPathBuilder($trusted);
        $certification_path = $path_builder->shortestPathToTarget($cert, $intermediates);
        $certification_path->validate(PathValidationConfig::defaultConfig());

        //$subject = $cert->tbsCertificate()->subject();
        //$commonName = CommonNameValue::fromASN1($subject);
        //$name = Name::fromASN1($subject);

        //$privateKey = PEM::fromString();
        //$cn = $subject->firstValueOf('cn')->stringValue();
        //print $subject->all();
        //print $name->toString();

      } catch (PathValidationException $e) {
        throw $e;
      } catch (PathBuildingException $e) {
        throw $e;
      } catch (DecodeException $e) {
        throw $e;
      } catch (\Exception $e) {
        throw $e;
      }
    };
  }

  public function setHandler(callable $handler) {
    $this->handlerStack->setHandler($handler);
  }

  public function getConfiguration(): array {
    return $this->config;
  }

  /**
   * @param $key
   * @param $value
   */
  public function property($key, $value) {
    $this->config[$key] = $value;
  }

  /**
   * @param callable $handler
   */
  public function registerRequestHandler(callable $handler) {
    $this->handlerStack->push(Middleware::mapRequest($handler));
  }

  /**
   * @param callable $handler
   */
  public function registerResponseHandler(callable $handler) {
    $this->handlerStack->push(Middleware::mapResponse($handler));
  }

  /**
   * @param ClientRequestFilterInterface $filter  The filter
   * @param string                       $name    Name to register for this filter.
   */
  public function registerRequestFilter(ClientRequestFilterInterface $filter, $name = '') {
    $this->handlerStack->push(Middleware::mapRequest([$filter, 'filter']), $name);
  }

  /**
   * Adds a middleware to the requesthandler stack.
   *
   * @param callable $handler
   * @param string   $method
   * @param string   $name     [optional]
   * @param string   $findName [optional]
   *
   * @see \GuzzleHttp\HandlerStack::before()
   * @see \GuzzleHttp\HandlerStack::after()
   * @see \GuzzleHttp\HandlerStack::push()
   * @see \GuzzleHttp\HandlerStack::unshift()
   *
   * @throws \Exception
   */
  public function mapRequestHandler(
    callable $handler,
    string $method = 'push',
    string $name = NULL,
    string $findName = NULL
  ) {
    if (in_array($method, ['push', 'after']) && !isset($findName)) {
      throw new \Exception(
        sprintf(
          "Unable to use '%s' method with no beforeOrAfterName provided",
          $method
        )
      );
    }

    switch ($method) {
      case 'unshift':
      case 'push':
        $this->handlerStack->{$method}($handler, $name);
        break;
      case 'before':
      case 'after':
        $this->handlerStack->{$method}($findName, $handler, $name);
        break;
      default:
        throw new \Exception("Invalid method '$method'");
    }
  }

  /**
   * @return \GuzzleHttp\HandlerStack
   */
  public function getHandlerStack() {
    return $this->handlerStack;
  }

  public static function factory(
    ContainerInterface $container,
    EventDispatcherInterface $eventDispatcher,
    array $config = []
  ) {
    return new ClientGuzzleConfig($container, $eventDispatcher, $config);
  }
}