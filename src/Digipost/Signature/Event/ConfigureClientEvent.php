<?php

namespace Digipost\Signature\Event;

use Digipost\Signature\Client\ClientConfiguration;
use Symfony\Component\EventDispatcher\Event;

class ConfigureClientEvent extends Event {

  /**
   * @var ClientConfiguration
   */
  private $clientConfiguration;

  function __construct(ClientConfiguration $clientConfiguration) {
    $this->clientConfiguration = $clientConfiguration;
  }
  function getGuzzleConfiguration() {
    return $this->clientConfiguration->getGuzzle();
  }

  function getKeyStoreConfig() {
    return $this->clientConfiguration->getKeyStoreConfig();
  }
}