<?php

namespace Digipost\Signature\API\XML;

use Digipost\Signature\JAXB\XMLSigner;
use JMS\Serializer\Annotation as Serializer;


/**
 * Class XMLDirectSigner
 *
 * <p>The following schema fragment specifies the expected content contained
 * within this class.
 *
 * <pre>
 * <complexType name="direct-signer">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <choice>
 *           <element name="personal-identification-number" type="{http://signering.posten.no/schema/v1}personal-identification-number"/>
 *           <element name="signer-identifier" type="{http://signering.posten.no/schema/v1}signer-identifier"/>
 *         </choice>
 *         <element name="signature-type" type="{http://signering.posten.no/schema/v1}signature-type" minOccurs="0"/>
 *         <element name="on-behalf-of" type="{http://signering.posten.no/schema/v1}signing-on-behalf-of" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML
 *
 * @Serializer\AccessorOrder("custom", custom = {
 *   "signerIdentifier",
 *   "personalIdentificationNumber",
 *   "signatureType",
 *   "onBehalfOf"
 * })
 */
class XMLDirectSigner implements XMLSigner {

  /**
   * Refer to a signer using a custom identifier string. This string can be any
   * ID recognized by the sender, and must uniquely identify the signer within
   * a job.
   *
   * @Serializer\XmlElement()
   */
  protected $signerIdentifier;

  /**
   * Refer to a signer by a personal identification number.
   * <p>[See also](https://www.skatteetaten.no/en/International-pages/Felles-innhold-benyttes-i-flere-malgrupper/Articles/Norwegian-national-ID-numbers/)
   *
   * @Serializer\XmlElement()
   */
  protected $personalIdentificationNumber;

  /**
   * @Serializer\Type("string")
   * @Serializer\XmlElement()
   */
  protected $signatureType;

  /**
   * @Serializer\Type("string")
   * @Serializer\XmlElement()
   */
  protected $onBehalfOf;

  /**
   * XMLDirectSigner constructor.
   *
   * @param String               $signerIdentifier
   * @param String               $personalIdentificationNumber
   * @param XMLSignatureType     $signatureType
   * @param XMLSigningOnBehalfOf $onBehalfOf
   */
  public function __construct(String $signerIdentifier = NULL,
                              String $personalIdentificationNumber = NULL,
                              XMLSignatureType $signatureType = NULL,
                              XMLSigningOnBehalfOf $onBehalfOf = NULL) {
    $this->signerIdentifier = $signerIdentifier;
    $this->personalIdentificationNumber = $personalIdentificationNumber;
    $this->signatureType = $signatureType;
    $this->onBehalfOf = $onBehalfOf;
  }

  /**
   * @return mixed
   */
  public function getSignerIdentifier() {
    return $this->signerIdentifier;
  }

  /**
   * @param mixed $signerIdentifier
   */
  public function setSignerIdentifier($signerIdentifier) {
    $this->signerIdentifier = $signerIdentifier;
  }

  /**
   * @return mixed
   */
  public function getPersonalIdentificationNumber() {
    return $this->personalIdentificationNumber;
  }

  /**
   * @param mixed $personalIdentificationNumber
   */
  public function setPersonalIdentificationNumber($personalIdentificationNumber) {
    $this->personalIdentificationNumber = $personalIdentificationNumber;
  }

  /**
   * @return XMLSignatureType
   */
  public function getSignatureType(): XMLSignatureType {
    return $this->signatureType;
  }

  /**
   * @param XMLSignatureType $signatureType
   */
  public function setSignatureType(XMLSignatureType $signatureType) {
    $this->signatureType = $signatureType;
  }

  /**
   * @return XMLSigningOnBehalfOf
   */
  public function getOnBehalfOf(): XMLSigningOnBehalfOf {
    return $this->onBehalfOf;
  }

  /**
   * @param XMLSigningOnBehalfOf $onBehalfOf
   */
  public function setOnBehalfOf(XMLSigningOnBehalfOf $onBehalfOf) {
    $this->onBehalfOf = $onBehalfOf;
  }

  public function withSignatureType(XMLSignatureType $signatureType) {
    $this->signatureType = $signatureType;
    return $this;
  }

  public function withSignerIdentifier($signerIdentifier) {
    $this->setSignerIdentifier($signerIdentifier);
    return $this;
  }

  public function withOnBehalfOf(XMLSigningOnBehalfOf $onBehalfOf) {
    $this->onBehalfOf = $onBehalfOf;
    return $this;
  }
}
