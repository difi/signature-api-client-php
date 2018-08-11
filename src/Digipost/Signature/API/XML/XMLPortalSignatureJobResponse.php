<?php

namespace Digipost\Signature\API\XML;

class XMLPortalSignatureJobResponse {

  /** @var String */
  private $reference;

  /** @var int */
  protected $signatureJobId;

  /** @var String */
  protected $cancellationUrl;

  function __construct(String $reference = NULL,
                       int $signatureJobId = NULL,
                       String $cancellationUrl = NULL) {
    $this->reference = $reference;
    $this->signatureJobId = $signatureJobId;
    $this->cancellationUrl = $cancellationUrl;
  }

  public function getSignatureJobId() {
    return $this->signatureJobId;
  }

  public function setSignatureJobId($value) {
    $this->signatureJobId = $value;
  }

  public function getCancellationUrl() {
    return $this->cancellationUrl;
  }

  public function setCancellationUrl($value) {
    $this->cancellationUrl = $value;
  }

  public function getReference(): String {
    return $this->reference;
  }

  public function setReference(String $reference) {
    $this->reference = $reference;
  }
}

