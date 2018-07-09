<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class CRLRefType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="CRLRefType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="DigestAlgAndValue" type="{http://uri.etsi.org/01903/v1.3.2#}DigestAlgAndValueType"/>
 *         <element name="CRLIdentifier" type="{http://uri.etsi.org/01903/v1.3.2#}CRLIdentifierType" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\AccessorOrder("custom", custom={
 *   "digestAlgAndValue",
 *   "crlIdentifier"
 * })
 */
class CRLRefType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType")
   * @Serializer\SerializedName("DigestAlgAndValue")
   */
  protected $digestAlgAndValue;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\CRLIdentifierType")
   * @Serializer\SerializedName("CRLIdentifier")
   */
  protected $crlIdentifier;

  public function __construct(DigestAlgAndValueType $digestAlgAndValue = NULL,
                              CRLIdentifierType $crlIdentifier = NULL) {
    $this->digestAlgAndValue = $digestAlgAndValue;
    $this->crlIdentifier = $crlIdentifier;
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

  public function getCRLIdentifier() {
    return $this->crlIdentifier;
  }

  public function setCRLIdentifier(CRLIdentifierType $value) {
    $this->crlIdentifier = $value;
  }

  public function withCRLIdentifier(CRLIdentifierType $value) {
    $this->setCRLIdentifier($value);
    return $this;
  }
}

