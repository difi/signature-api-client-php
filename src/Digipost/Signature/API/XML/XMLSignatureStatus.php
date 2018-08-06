<?php

namespace Digipost\Signature\API\XML;

/**
 * Class XMLSignatureStatus
 *
 * @package Digipost\Signature\API\XML
 */
class XMLSignatureStatus {

  /** @var String */
  protected $value;

  /** @var \DateTime */
  protected $since;

  function __construct(String $value = NULL, \DateTime $since = NULL) {
    $this->value = $value;
    $this->since = $since;
  }

  public function getValue() {
    return $this->value;
  }

  public function setValue($value) {
    $this->value = $value;
  }

  public function getSince() {
    return $this->since;
  }

  public function setSince($value) {
    $this->since = $value;
  }
}

