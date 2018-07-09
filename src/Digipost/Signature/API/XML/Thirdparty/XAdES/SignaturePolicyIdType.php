<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transforms;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class SignaturePolicyIdType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="SignaturePolicyIdType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="SigPolicyId" type="{http://uri.etsi.org/01903/v1.3.2#}ObjectIdentifierType"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}Transforms" minOccurs="0"/>
 *         <element name="SigPolicyHash" type="{http://uri.etsi.org/01903/v1.3.2#}DigestAlgAndValueType"/>
 *         <element name="SigPolicyQualifiers" type="{http://uri.etsi.org/01903/v1.3.2#}SigPolicyQualifiersListType" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\AccessorOrder("custom", custom={
 *   "sigPolicyId",
 *   "transforms",
 *   "sigPolicyHash",
 *   "sigPolicyQualifiers"
 * })
 */
class SignaturePolicyIdType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\ObjectIdentifier")
   */
  protected $sigPolicyId;

  /**
   * @Serializer\XmlElement(cdata=false, namespace="http://www.w3.org/2000/09/xmldsig#")
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transforms")
   */
  protected $transforms;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType")
   */
  protected $sigPolicyHash;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\SigPolicyQualifiersListType")
   */
  protected $sigPolicyQualifiers;

  public function __construct(ObjectIdentifier $sigPolicyId = NULL,
                              Transforms $transforms = NULL,
                              DigestAlgAndValueType $sigPolicyHash = NULL,
                              SigPolicyQualifiersListType $sigPolicyQualifiers = NULL) {
    $this->sigPolicyId = $sigPolicyId;
    $this->transforms = $transforms;
    $this->sigPolicyHash = $sigPolicyHash;
    $this->sigPolicyQualifiers = $sigPolicyQualifiers;
    return $this;
  }

  public function getSigPolicyId() {
    return $this->sigPolicyId;
  }

  public function setSigPolicyId(ObjectIdentifier $value) {
    $this->sigPolicyId = $value;
  }

  public function withSigPolicyId(ObjectIdentifier $value) {
    $this->setSigPolicyId($value);
    return $this;
  }

  public function getTransforms() {
    return $this->transforms;
  }

  public function setTransforms(Transforms $value) {
    $this->transforms = $value;
  }

  public function withTransforms(Transforms $value) {
    $this->setTransforms($value);
    return $this;
  }

  public function getSigPolicyHash() {
    return $this->sigPolicyHash;
  }

  public function setSigPolicyHash(DigestAlgAndValueType $value) {
    $this->sigPolicyHash = $value;
  }

  public function withSigPolicyHash(DigestAlgAndValueType $value) {
    $this->setSigPolicyHash($value);
    return $this;
  }

  public function getSigPolicyQualifiers() {
    return $this->sigPolicyQualifiers;
  }

  public function setSigPolicyQualifiers(SigPolicyQualifiersListType $value) {
    $this->sigPolicyQualifiers = $value;
  }

  public function withSigPolicyQualifiers(SigPolicyQualifiersListType $value) {
    $this->setSigPolicyQualifiers($value);
    return $this;
  }
}

