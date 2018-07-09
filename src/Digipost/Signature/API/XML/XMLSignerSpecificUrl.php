<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLSignerSpecificUrl
 *
 * <p>Java class for signer-specific-url complex type.
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="signer-specific-url">
 *   <simpleContent>
 *     <extension base="<http://signering.posten.no/schema/v1>url">
 *       <attribute name="signer" type="{http://www.w3.org/2001/XMLSchema}string" />
 *     </extension>
 *   </simpleContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML
 */
class XMLSignerSpecificUrl {

  /**
   * @Serializer\XmlValue(cdata=false)
   */
  protected $value;

  /**
   * @Serializer\XmlAttribute()
   */
  protected $signer;

  function __construct(String $value = NULL, String $signer = NULL) {
    $this->value = $value;
    $this->signer = $signer;
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
}

