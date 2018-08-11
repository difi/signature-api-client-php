<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLSignatureStatus
 *
 * @package Digipost\Signature\API\XML
 */
class XMLSignatureStatus {

  /**
   * @var String
   * @Serializer\XmlValue()
   */
  protected $value;

  /**
   * @var \DateTime
   * @Serializer\XmlAttribute()
   */
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

