<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class X509IssuerSerialType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="X509IssuerSerialType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="X509IssuerName" type="{http://www.w3.org/2001/XMLSchema}string"/>
 *         <element name="X509SerialNumber" type="{http://www.w3.org/2001/XMLSchema}integer"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *          
 * @Serializer\AccessorOrder("custom", custom={
 *   "x509IssuerName",
 *   "x509SerialNumber"
 * })
 */
class X509IssuerSerialType {

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $x509IssuerName;

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $x509SerialNumber;

  public function __construct(String $x509IssuerName = NULL,
                              int $x509SerialNumber = NULL) {
    $this->x509IssuerName = $x509IssuerName;
    $this->x509SerialNumber = $x509SerialNumber;
    return $this;
  }

  public function getX509IssuerName() {
    return $this->x509IssuerName;
  }

  public function setX509IssuerName($value) {
    $this->x509IssuerName = $value;
  }

  public function getX509SerialNumber() {
    return $this->x509SerialNumber;
  }

  public function setX509SerialNumber($value) {
    $this->x509SerialNumber = $value;
  }
}

