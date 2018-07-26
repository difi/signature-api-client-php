<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

use Digipost\Signature\API\XML\XMLError;
use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\AppendStream;
use function GuzzleHttp\Psr7\stream_for;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ClientConfig {

  protected $config;

  protected $handlerStack;

  /** @var ContainerInterface  */
  private $container;

  /**
   * ClientConfig constructor.
   *
   * @param ContainerInterface $container
   * @param array|null $config
   */
  public function __construct(ContainerInterface $container, array $config = []) {
    $this->container = $container;
    $this->config = $config;
    $this->handlerStack = new HandlerStack();
    $this->setHandler(new CurlHandler());

    $this->config['handler'] = $this->handlerStack;

    $this->handlerStack->push(Middleware::mapResponse(function (ResponseInterface $response) {
      //$stream = stream_for()
      $body = $response->getBody();
      $xmlData = $body->getContents();

      $dom = new \DOMDocument();
      $dom->loadXML($xmlData);
      if ($dom->localName === 'error') {
        $errorObj = Marshalling::unmarshal($xmlData, XMLError::class, ['snake-case' => TRUE]);
        print_r($errorObj);
      }
      return $response;
    }));

    $this->handlerStack->push(Middleware::mapRequest(function (RequestInterface $request) {
      $body = $request->getBody();

      return $request
        ->withoutHeader('Content-Disposition')
        ->withoutHeader('Content-Length');
    }));
  }

  public function setHandler(callable $handler) {
    $this->handlerStack->setHandler($handler);
  }

  public function getConfiguration() {
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

  public static function factory(ContainerInterface $container, array $config = []) {
    return new ClientConfig($container, $config);
  }
}