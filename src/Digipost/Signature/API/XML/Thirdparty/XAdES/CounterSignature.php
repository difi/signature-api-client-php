<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use Digipost\Signature\API\XML\Thirdparty\XMLdSig\Signature;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class CounterSignature
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="CounterSignatureType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}Signature"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="CounterSignature")
 */
class CounterSignature {

  /**
   * @Serializer\XmlElement(cdata=false, namespace="http://www.w3.org/2000/09/xmldsig#")
   */
  protected $signature;

  public function __construct(Signature $signature = NULL) {
    $this->signature = $signature;
  }

  public function getSignature() {
    return $this->signature;
  }

  public function setSignature(Signature $value) {
    $this->signature = $value;
  }

  public function withSignature(Signature $value) {
    $this->setSignature($value);
    return $this;
  }
}

