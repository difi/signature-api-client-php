<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class OtherCertStatusRefsType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="OtherCertStatusRefsType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="OtherRef" type="{http://uri.etsi.org/01903/v1.3.2#}AnyType" maxOccurs="unbounded"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class OtherCertStatusRefsType  {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<any>")
   * @Serializer\SerializedName("OtherRef")
   */
  protected $otherReves;

  public function __construct(array $otherReves = NULL) {
    $this->otherReves = $otherReves;
    return $this;
  }

  public function &getOtherReves() {
    if ($this->otherReves === NULL) {
      $this->otherReves = [];
    }
    return $this->otherReves;
  }

  public function setOtherReves(array $values) {
    $content =& $this->getOtherReves();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }


}

