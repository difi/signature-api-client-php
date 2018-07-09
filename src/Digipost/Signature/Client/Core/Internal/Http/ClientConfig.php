<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

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