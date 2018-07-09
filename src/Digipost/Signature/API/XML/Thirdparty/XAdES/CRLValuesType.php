<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class CRLValuesType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="CRLValuesType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="EncapsulatedCRLValue" type="{http://uri.etsi.org/01903/v1.3.2#}EncapsulatedPKIDataType" maxOccurs="unbounded"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class CRLValuesType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIData>")
   * @Serializer\SerializedName("EncapsulatedCRLValue")
   * @var EncapsulatedPKIData[] $encapsulatedCRLValues
   */
  protected $encapsulatedCRLValues;

  public function __construct(array $encapsulatedCRLValues = NULL) {
    $this->encapsulatedCRLValues = $encapsulatedCRLValues;
    return $this;
  }

  public function &getEncapsulatedCRLValues() {
    if ($this->encapsulatedCRLValues === NULL) {
      $this->encapsulatedCRLValues = [];
    }
    return $this->encapsulatedCRLValues;
  }

  public function withEncapsulatedCRLValues(array $values) {
    $content =& $this->getEncapsulatedCRLValues();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }

}

