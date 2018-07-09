<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLSignatures
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="signatures">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="signature" type="{http://signering.posten.no/schema/v1}signature" maxOccurs="10"/>
 *         <element name="pades-url" type="{http://signering.posten.no/schema/v1}url" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML
 */
class XMLSignatures {

  /**
   * @Serializer\Type("array<Digipost\Signature\API\XML\XMLSignature>")
   */
  protected $signatures;

  protected $padesUrl;

  function __construct($signatures = NULL, String $padesUrl = NULL) {
    $this->signatures = $signatures;
    $this->padesUrl = $padesUrl;
  }

  public function getSignatures() {
    if ($this->signatures === NULL) {
      $this->signatures = [];
    }
    return $this->signatures;
  }

  public function getPadesUrl() {
    return $this->padesUrl;
  }

  public function setPadesUrl($value) {
    $this->padesUrl = $value;
  }
}

