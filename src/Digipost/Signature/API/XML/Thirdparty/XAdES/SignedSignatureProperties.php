<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class SignedSignatureProperties
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="SignedSignaturePropertiesType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="SigningTime" type="{http://www.w3.org/2001/XMLSchema}dateTime" minOccurs="0"/>
 *         <element name="SigningCertificate" type="{http://uri.etsi.org/01903/v1.3.2#}CertIDListType" minOccurs="0"/>
 *         <element name="SignaturePolicyIdentifier" type="{http://uri.etsi.org/01903/v1.3.2#}SignaturePolicyIdentifierType" minOccurs="0"/>
 *         <element name="SignatureProductionPlace" type="{http://uri.etsi.org/01903/v1.3.2#}SignatureProductionPlaceType" minOccurs="0"/>
 *         <element name="SignerRole" type="{http://uri.etsi.org/01903/v1.3.2#}SignerRoleType" minOccurs="0"/>
 *       </sequence>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="SignedSignatureProperties")
 * @Serializer\AccessorOrder("custom", custom={
 *   "signingTime",
 *   "signingCertificate",
 *   "signaturePolicyIdentifier",
 *   "signatureProductionPlace",
 *   "signerRole"
 * })
 */
class SignedSignatureProperties {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("DateTime")
   */
  protected $signingTime;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\SigningCertificate")
   */
  protected $signingCertificate;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\SignaturePolicyIdentifier")
   */
  protected $signaturePolicyIdentifier;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\SignatureProductionPlace")
   */
  protected $signatureProductionPlace;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\SignerRole")
   */
  protected $signerRole;

  /**
   * @Serializer\XmlAttribute()
   */
  protected $id;

  public function __construct(\DateTime $signingTime = NULL,
                              SigningCertificate $signingCertificate = NULL,
                              SignaturePolicyIdentifier $signaturePolicyIdentifier = NULL,
                              SignatureProductionPlace $signatureProductionPlace = NULL,
                              SignerRole $signerRole = NULL,
                              String $id = NULL) {

    $this->signingTime = $signingTime;
    $this->signingCertificate = $signingCertificate;
    $this->signaturePolicyIdentifier = $signaturePolicyIdentifier;
    $this->signatureProductionPlace = $signatureProductionPlace;
    $this->signerRole = $signerRole;
    $this->id = $id;
    return $this;
  }

  public function getSigningTime() {
    return $this->signingTime;
  }

  public function setSigningTime(\DateTime $value) {
    $this->signingTime = $value;
  }

  public function withSigningTime(\DateTime $value) {
    $this->setSigningTime($value);
    return $this;
  }

  public function getSigningCertificate() {
    return $this->signingCertificate;
  }

  public function setSigningCertificate(SigningCertificate $value) {
    $this->signingCertificate = $value;
  }

  public function withSigningCertificate(SigningCertificate $value) {
    $this->setSigningCertificate($value);
    return $this;
  }

  public function getSignaturePolicyIdentifier() {
    return $this->signaturePolicyIdentifier;
  }

  public function setSignaturePolicyIdentifier(SignaturePolicyIdentifier $value) {
    $this->signaturePolicyIdentifier = $value;
  }

  public function withSignaturePolicyIdentifier(SignaturePolicyIdentifier $value) {
    $this->setSignaturePolicyIdentifier($value);
    return $this;
  }

  public function getSignatureProductionPlace() {
    return $this->signatureProductionPlace;
  }

  public function setSignatureProductionPlace(SignatureProductionPlace $value) {
    $this->signatureProductionPlace = $value;
  }

  public function withSignatureProductionPlace(SignatureProductionPlace $value) {
    $this->setSignatureProductionPlace($value);
    return $this;
  }

  public function getSignerRole() {
    return $this->signerRole;
  }

  public function setSignerRole(SignerRole $value) {
    $this->signerRole = $value;
  }

  public function withSignerRole(SignerRole $value) {
    $this->setSignerRole($value);
    return $this;
  }

  public function getId() {
    return $this->id;
  }

  public function setId(String $value) {
    $this->id = $value;
  }

  public function withId(String $value) {
    $this->setId($value);
    return $this;
  }
}

