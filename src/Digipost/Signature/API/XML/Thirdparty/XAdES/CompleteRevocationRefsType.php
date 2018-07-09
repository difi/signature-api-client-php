<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class CompleteRevocationRefsType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="CompleteRevocationRefsType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="CRLRefs" type="{http://uri.etsi.org/01903/v1.3.2#}CRLRefsType" minOccurs="0"/>
 *         <element name="OCSPRefs" type="{http://uri.etsi.org/01903/v1.3.2#}OCSPRefsType" minOccurs="0"/>
 *         <element name="OtherRefs" type="{http://uri.etsi.org/01903/v1.3.2#}OtherCertStatusRefsType" minOccurs="0"/>
 *       </sequence>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\AccessorOrder("custom", custom={
 *   "crlRefs",
 *   "ocspRefs",
 *   "otherRefs"
 * })
 */
class CompleteRevocationRefsType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\CRLRefsType")
   */
  protected $crlRefs;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\OCSPRefsType")
   */
  protected $ocspRefs;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\OtherCertStatusRefsType")
   */
  protected $otherRefs;

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("Id")
   */
  protected $id;

  public function __construct(CRLRefsType $crlRefs = NULL,
                              OCSPRefsType $ocspRefs = NULL,
                              OtherCertStatusRefsType $otherRefs = NULL,
                              String $id = NULL) {
    $this->crlRefs = $crlRefs;
    $this->ocspRefs = $ocspRefs;
    $this->otherRefs = $otherRefs;
    $this->id = $id;
  }

  public function getCRLRefs() {
    return $this->crlRefs;
  }

  public function setCRLRefs(CRLRefsType $value) {
    $this->crlRefs = $value;
  }

  public function withCRLRefs(CRLRefsType $value) {
    $this->setCRLRefs($value);
    return $this;
  }

  public function getOCSPRefs() {
    return $this->ocspRefs;
  }

  public function setOCSPRefs(OCSPRefsType $value) {
    $this->ocspRefs = $value;
  }

  public function withOCSPRefs(OCSPRefsType $value) {
    $this->setOCSPRefs($value);
    return $this;
  }

  public function getOtherRefs() {
    return $this->otherRefs;
  }

  public function setOtherRefs(OtherCertStatusRefsType $value) {
    $this->otherRefs = $value;
  }

  public function withOtherRefs(OtherCertStatusRefsType $value) {
    $this->setOtherRefs($value);
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

