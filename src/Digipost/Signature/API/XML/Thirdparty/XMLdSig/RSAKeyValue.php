<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class RSAKeyValue
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="RSAKeyValueType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="Modulus" type="{http://www.w3.org/2000/09/xmldsig#}CryptoBinary"/>
 *         <element name="Exponent" type="{http://www.w3.org/2000/09/xmldsig#}CryptoBinary"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\XmlRoot(name="RSAKeyValue")
 * @Serializer\AccessorOrder("custom", custom={"modulus","exponent"})
 */
class RSAKeyValue {

  /**
   * @var string
   * @Serializer\XmlElement(cdata=false)
   */
  protected $modulus;

  /**
   * @var string
   * @Serializer\XmlElement(cdata=false)
   */
  protected $exponent;

  public function __construct($modulus = NULL,
                              $exponent = NULL) {

    $this->modulus = $modulus;
    $this->exponent = $exponent;
    return $this;
  }

  public function getModulus() {
    return $this->modulus;
  }

  public function setModulus($value) {
    $this->modulus = $value;
  }

  public function getExponent() {
    return $this->exponent;
  }

  public function setExponent($value) {
    $this->exponent = $value;
  }
}

