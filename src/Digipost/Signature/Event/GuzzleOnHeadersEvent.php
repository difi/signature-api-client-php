<?php

namespace Digipost\Signature\Event;

use Digipost\Signature\Client\Core\Internal\Http\ClientGuzzleConfig;
use Digipost\Signature\Client\Core\Internal\Http\SignatureHttpClient;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\EventDispatcher\Event;

class GuzzleOnHeadersEvent extends Event {

  /**
   * @var ResponseInterface
   */
  private $response;

  /**
   * @var SignatureHttpClient
   */
  private $httpClient;
  /**
   * @var ClientGuzzleConfig
   */
  private $clientGuzzleConfig;

  function __construct(ClientGuzzleConfig $clientGuzzleConfig, ResponseInterface $response) {
    $this->response = $response;
    $this->clientGuzzleConfig = $clientGuzzleConfig;
  }
  /**
   * @return ResponseInterface
   */
  public function getResponse(): ResponseInterface {
    return $this->response;
  }
  /**
   * @return SignatureHttpClient
   */
  public function getHttpClient(): SignatureHttpClient {
    return $this->httpClient;
  }
  /**
   * @return ClientGuzzleConfig
   */
  public function getClientGuzzleConfig(): ClientGuzzleConfig {
    return $this->clientGuzzleConfig;
  }
}