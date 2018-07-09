<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class OCSPValuesType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="OCSPValuesType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="EncapsulatedOCSPValue" type="{http://uri.etsi.org/01903/v1.3.2#}EncapsulatedPKIDataType" maxOccurs="unbounded"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class OCSPValuesType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIData>")
   * @Serializer\SerializedName("EncapsulatedOCSPValue")
   */
  protected $encapsulatedOCSPValues;

  public function __construct(array $encapsulatedOCSPValues = NULL) {
    $this->encapsulatedOCSPValues = $encapsulatedOCSPValues;
    return $this;
  }

  public function &getEncapsulatedOCSPValues() {
    if ($this->encapsulatedOCSPValues === NULL) {
      $this->encapsulatedOCSPValues = [];
    }
    return $this->encapsulatedOCSPValues;
  }

  public function withEncapsulatedOCSPValues(array $values) {
    $content =& $this->getEncapsulatedOCSPValues();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }


}

