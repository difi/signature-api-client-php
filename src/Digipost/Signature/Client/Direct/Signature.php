<?php

namespace Digipost\Signature\Client\Direct;

use Digipost\Signature\Client\Core\Internal\PersonalIdentificationNumbers;
use Digipost\Signature\Client\Core\XAdESReference;

class Signature {

  private $signer;

  private $status;

  private $statusDateTime;

  private $xAdESReference;

  public function __construct(String $signer, SignerStatus $status,
                              \DateTime $statusDateTime,
                              XAdESReference $xAdESReference) {
    $this->signer = $signer;
    $this->status = $status;
    $this->statusDateTime = $statusDateTime;
    $this->xAdESReference = $xAdESReference;
  }

  public function getSigner() {
    return $this->signer;
  }

  public function isFrom(String $personalIdentificationNumber) {
    return $this->signer === $personalIdentificationNumber;
  }

  public function is(SignerStatus $status) {
    return $this->status === $status;
  }

  public function getStatus() {
    return $this->status;
  }

  /**
   * @return \DateTime Point in time when the action (document was signed, signature job expired, etc.) leading to the
   * current {@link Signature::$status} happened
   */
  public function getStatusDateTime() {
    return $this->statusDateTime;
  }

  public function getxAdESUrl(): XAdESReference {
    return $this->xAdESReference;
  }

  public function __toString() {
    return "Signature from " . PersonalIdentificationNumbers::mask($this->signer) . " with status '" . $this->status . "' since " . $this->statusDateTime->format(\DateTime::RFC3339_EXTENDED) . "" .
      ($this->xAdESReference !== NULL ? ". XAdES available at " . $this->xAdESReference->getxAdESUrl() : "");
  }

  static function signatureFrom(Signature $signature, String $signer) {
    return $signature->isFrom($signer);
  }
}
