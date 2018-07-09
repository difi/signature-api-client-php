<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class SignaturePolicyIdentifier
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="SignaturePolicyIdentifierType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <choice>
 *         <element name="SignaturePolicyId" type="{http://uri.etsi.org/01903/v1.3.2#}SignaturePolicyIdType"/>
 *         <element name="SignaturePolicyImplied" type="{http://www.w3.org/2001/XMLSchema}anyType"/>
 *       </choice>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="SignaturePolicyIdentifier")
 * @Serializer\AccessorOrder("custom", custom={
 *   "signaturePolicyImplied",
 *   "signaturePolicyId"
 * })
 */
class SignaturePolicyIdentifier {

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $signaturePolicyImplied;

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $signaturePolicyId;

  public function __construct($signaturePolicyImplied = NULL,
                              SignaturePolicyIdType $signaturePolicyId = NULL) {
    $this->signaturePolicyImplied = $signaturePolicyImplied;
    $this->signaturePolicyId = $signaturePolicyId;
    return $this;
  }

  public function getSignaturePolicyImplied() {
    return $this->signaturePolicyImplied;
  }

  public function setSignaturePolicyImplied($value) {
    $this->signaturePolicyImplied = $value;
  }

  public function withSignaturePolicyImplied($value) {
    $this->setSignaturePolicyImplied($value);
    return $this;
  }

  public function getSignaturePolicyId() {
    return $this->signaturePolicyId;
  }

  public function setSignaturePolicyId(SignaturePolicyIdType $value) {
    $this->signaturePolicyId = $value;
  }

  public function withSignaturePolicyId(SignaturePolicyIdType $value) {
    $this->setSignaturePolicyId($value);
    return $this;
  }
}

