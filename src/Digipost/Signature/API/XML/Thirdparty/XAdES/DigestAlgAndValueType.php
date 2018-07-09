<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class DigestAlgAndValueType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="DigestAlgAndValueType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}DigestMethod"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}DigestValue"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 *
 * @Serializer\AccessorOrder("custom", custom={"digestMethod","digestValue"})
 */
class DigestAlgAndValueType {

  /**
   * @Serializer\XmlKeyValuePairs()
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod")
   */
  protected $digestMethod;

  /**
   * @Serializer\XmlValue()
   */
  protected $digestValue;

  public function __construct(DigestMethod $digestMethod = NULL,
                              string $digestValue = NULL) {
    $this->digestMethod = $digestMethod;
    $this->digestValue = $digestValue;
    return $this;
  }

  public function getDigestMethod() {
    return $this->digestMethod;
  }

  public function setDigestMethod($value) {
    $this->digestMethod = $value;
  }

  public function getDigestValue() {
    return $this->digestValue;
  }

  public function setDigestValue($value) // [byte[] value]
  {
    $this->digestValue = $value;
  }

  public function withDigestMethod($value) {
    $this->setDigestMethod($value);
    return $this;
  }

  public function withDigestValue($value) // [byte[] value]
  {
    $this->setDigestValue($value);
    return $this;
  }
}

