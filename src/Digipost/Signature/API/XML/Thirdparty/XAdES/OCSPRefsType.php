<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class OCSPRefsType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="OCSPRefsType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="OCSPRef" type="{http://uri.etsi.org/01903/v1.3.2#}OCSPRefType" maxOccurs="unbounded"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class OCSPRefsType  {

  /** @var OCSPRefType[] $ocspReves */
  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XAdES\OCSPRefType>")
   * @Serializer\SerializedName("OCSPRef")
   */
  protected $ocspReves;

  public function __construct(array $ocspReves = NULL) {
    $this->ocspReves = $ocspReves;
    return $this;
  }

  public function &getOCSPReves() {
    if ($this->ocspReves === NULL) {
      $this->ocspReves = [];
    }
    return $this->ocspReves;
  }

  public function withOCSPReves(array $values) {
    $content =& $this->getOCSPReves();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }
}

