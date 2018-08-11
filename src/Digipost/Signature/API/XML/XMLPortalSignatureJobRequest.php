<?php

namespace Digipost\Signature\API\XML;

/**
 * Class XMLPortalSignatureJobRequest
 *
 * @package Digipost\Signature\API\XML
 */
class XMLPortalSignatureJobRequest {

  /** @var String */
  protected $reference;

  /** @var String */
  protected $pollingQueue;

  function __construct(String $reference = NULL, String $pollingQueue = NULL) {
    $this->reference = $reference;
    $this->pollingQueue = $pollingQueue;
  }

  public function getReference() {
    return $this->reference;
  }

  public function setReference($value) {
    $this->reference = $value;
  }

  public function withReference($value) {
    $this->reference = $value;
    return $this;
  }

  public function getPollingQueue() {
    return $this->pollingQueue;
  }

  public function setPollingQueue($value) {
    $this->pollingQueue = $value;
  }

  public function withPollingQueue($value) {
    $this->pollingQueue = $value;
    return $this;
  }
}

