<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLSignature
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="signature">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="status" type="{http://signering.posten.no/schema/v1}signature-status"/>
 *         <choice>
 *           <element name="personal-identification-number" type="{http://signering.posten.no/schema/v1}personal-identification-number"/>
 *           <element name="identifier" type="{http://signering.posten.no/schema/v1}notifications"/>
 *         </choice>
 *         <element name="xades-url" type="{http://signering.posten.no/schema/v1}url" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML
 */
class XMLSignature {

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\XMLSignatureStatus")
   */
  protected $status;

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\XMLNotifications")
   */
  protected $identifier;

  protected $personalIdentificationNumber;

  protected $xadesUrl;

  function __construct(XMLSignatureStatus $status = NULL,
                       XMLNotifications $identifier = NULL,
                       String $personalIdentificationNumber = NULL,
                       String $xadesUrl = NULL) {
    $this->status = $status;
    $this->identifier = $identifier;
    $this->personalIdentificationNumber = $personalIdentificationNumber;
    $this->xadesUrl = $xadesUrl;
  }

  public function getStatus() {
    return $this->status;
  }

  public function setStatus($value) {
    $this->status = $value;
  }

  public function getIdentifier() {
    return $this->identifier;
  }

  public function setIdentifier($value) {
    $this->identifier = $value;
  }

  public function getPersonalIdentificationNumber() {
    return $this->personalIdentificationNumber;
  }

  public function setPersonalIdentificationNumber($value) {
    $this->personalIdentificationNumber = $value;
  }

  public function getXadesUrl() {
    return $this->xadesUrl;
  }

  public function setXadesUrl($value) {
    $this->xadesUrl = $value;
  }
}

