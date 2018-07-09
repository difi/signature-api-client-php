<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class OtherCertStatusValuesType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="OtherCertStatusValuesType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="OtherValue" type="{http://uri.etsi.org/01903/v1.3.2#}AnyType" maxOccurs="unbounded"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class OtherCertStatusValuesType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<any>")
   * @Serializer\SerializedName("OtherValue")
   */
  protected $otherValues;

  public function __construct(array $otherValues = NULL) {
    $this->otherValues = $otherValues;
    return $this;
  }

  public function &getOtherValues() {
    if ($this->otherValues === NULL) {
      $this->otherValues = [];
    }
    return $this->otherValues;
  }

  public function withOtherValues(array $values) {
    $content =& $this->getOtherValues();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }
}

