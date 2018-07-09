<?php

namespace Digipost\Signature\API\XML;

class XMLSignerStatus {

  protected $value;  // String

  protected $signer;  // String

  protected $since;  // ZonedDateTime

  function __construct(String $value = NULL, String $signer = NULL,
                       \DateTime $since = NULL) {
    $this->value = $value;
    $this->signer = $signer;
    $this->since = $since;
  }

  public function getValue() {
    return $this->value;
  }

  public function setValue($value) {
    $this->value = $value;
  }

  public function getSigner() {
    return $this->signer;
  }

  public function setSigner($value) {
    $this->signer = $value;
  }

  public function getSince() {
    return $this->since;
  }

  public function setSince($value) {
    $this->since = $value;
  }
}

