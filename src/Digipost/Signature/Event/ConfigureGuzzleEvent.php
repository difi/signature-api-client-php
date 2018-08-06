<?php

namespace Digipost\Signature\Event;

use Digipost\Signature\Client\ClientConfiguration;
use Digipost\Signature\Client\Core\Internal\Http\ClientGuzzleConfig;
use GuzzleHttp\Client;
use Symfony\Component\EventDispatcher\Event;

class ConfigureGuzzleEvent extends Event {

  /**
   * @var ClientGuzzleConfig
   */
  private $guzzleConfig;

  function __construct(ClientGuzzleConfig $clientGuzzleConfig, Client $guzzleClient = NULL) {
    $this->guzzleConfig = $clientGuzzleConfig;

  }
}