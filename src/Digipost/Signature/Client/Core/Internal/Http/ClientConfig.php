<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use function GuzzleHttp\Psr7\stream_for;
use Psr\Http\Message\ResponseInterface;

class ClientConfig {

  protected $config;

  protected $handlerStack;

  /**
   * ClientConfig constructor.
   *
   * @param array|null $config
   */
  public function __construct(array $config = []) {
    $this->config = $config;
    $this->handlerStack = new HandlerStack();
    $this->setHandler(new CurlHandler());

    $this->handlerStack->push(Middleware::mapResponse(function (ResponseInterface $response) {
      //$response->withBody()
      //$stream = stream_for()
      $body = $response->getBody()->getContents();
      $mappedResponse = stream_for("Dette er en test!");
      return $response->withBody($mappedResponse);
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
}