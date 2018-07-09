<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class CRLRefsType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="CRLRefsType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="CRLRef" type="{http://uri.etsi.org/01903/v1.3.2#}CRLRefType" maxOccurs="unbounded"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class CRLRefsType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XAdES\CRLRefType>")
   */
  protected $crlReves;

  public function __construct(array $crlReves = NULL) {
    $this->crlReves = $crlReves;
    return $this;
  }

  public function &getCRLReves() {
    if ($this->crlReves === NULL) {
      $this->crlReves = [];
    }
    return $this->crlReves;
  }

  public function withCRLReves(array $values) {
    $content =& $this->getCRLReves();
    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }
}

