<?php

namespace Digipost\Signature\Client\Core;

class Sender {

  /**
   * @var String
   */
  protected $organizationNumber;

  /**
   * @var PollingQueue
   */
  protected $pollingQueue;

  public function __construct(
    String $organizationNumber,
    PollingQueue $pollingQueue = NULL
  ) {
    if (isset($pollingQueue)) {
      $this->pollingQueue = $pollingQueue;
    }
    else {
      $this->pollingQueue = PollingQueue::$DEFAULT;
    }
    $this->organizationNumber = $organizationNumber;
  }

  public function getOrganizationNumber() {
    return $this->organizationNumber;
  }

  public function getPollingQueue(): PollingQueue {
    return $this->pollingQueue;
  }
}

