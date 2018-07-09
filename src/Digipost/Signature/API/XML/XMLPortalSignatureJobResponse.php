<?php

namespace Digipost\Signature\API\XML;

class XMLPortalSignatureJobResponse {

  protected $signatureJobId;  // long

  protected $cancellationUrl;  // String

  function __construct(int $signatureJobId = NULL,
                       String $cancellationUrl = NULL) {
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
}

