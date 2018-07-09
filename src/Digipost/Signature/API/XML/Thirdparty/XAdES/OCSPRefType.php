<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class OCSPRefType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="OCSPRefType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="OCSPIdentifier" type="{http://uri.etsi.org/01903/v1.3.2#}OCSPIdentifierType"/>
 *         <element name="DigestAlgAndValue" type="{http://uri.etsi.org/01903/v1.3.2#}DigestAlgAndValueType" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\AccessorOrder("custom", custom={
 *   "ocspIdentifier",
 *   "digestAlgAndValue"
 * })
 */
class OCSPRefType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\OCSPIdentifierType")
   */
  protected $ocspIdentifier;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType")
   *
   */
  protected $digestAlgAndValue;

  public function __construct(OCSPIdentifierType $ocspIdentifier = NULL,
                              DigestAlgAndValueType $digestAlgAndValue = NULL) {
    $this->ocspIdentifier = $ocspIdentifier;
    $this->digestAlgAndValue = $digestAlgAndValue;
    return $this;
  }

  public function getOCSPIdentifier() {
    return $this->ocspIdentifier;
  }

  public function setOCSPIdentifier(OCSPIdentifierType $value) {
    $this->ocspIdentifier = $value;
  }

  public function withOCSPIdentifier(OCSPIdentifierType $value) {
    $this->setOCSPIdentifier($value);
    return $this;
  }

  public function getDigestAlgAndValue() {
    return $this->digestAlgAndValue;
  }

  public function setDigestAlgAndValue(DigestAlgAndValueType $value) {
    $this->digestAlgAndValue = $value;
  }

  public function withDigestAlgAndValue(DigestAlgAndValueType $value) {
    $this->setDigestAlgAndValue($value);
    return $this;
  }
}

