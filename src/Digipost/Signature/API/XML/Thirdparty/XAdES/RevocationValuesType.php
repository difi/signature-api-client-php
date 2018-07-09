<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class RevocationValuesType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="RevocationValuesType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="CRLValues" type="{http://uri.etsi.org/01903/v1.3.2#}CRLValuesType" minOccurs="0"/>
 *         <element name="OCSPValues" type="{http://uri.etsi.org/01903/v1.3.2#}OCSPValuesType" minOccurs="0"/>
 *         <element name="OtherValues" type="{http://uri.etsi.org/01903/v1.3.2#}OtherCertStatusValuesType" minOccurs="0"/>
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
 *   "crlValues",
 *   "ocspValues",
 *   "otherValues"
 * })
 */
class RevocationValuesType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\CRLValuesType")
   */
  protected $crlValues;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\OCSPValuesType")
   */
  protected $ocspValues;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\OtherCertStatusValuesType")
   */
  protected $otherValues;

  /**
   * @Serializer\XmlAttribute()
   */
  protected $id;

  public function __construct(CRLValuesType $crlValues = NULL,
                              OCSPValuesType $ocspValues = NULL,
                              OtherCertStatusValuesType $otherValues = NULL,
                              String $id = NULL) {
    $this->crlValues = $crlValues;
    $this->ocspValues = $ocspValues;
    $this->otherValues = $otherValues;
    $this->id = $id;
    return $this;
  }

  public function getCRLValues() {
    return $this->crlValues;
  }

  public function setCRLValues(CRLValuesType $value) {
    $this->crlValues = $value;
  }

  public function withCRLValues(CRLValuesType $value) {
    $this->setCRLValues($value);
    return $this;
  }

  public function getOCSPValues() {
    return $this->ocspValues;
  }

  public function setOCSPValues(OCSPValuesType $value) {
    $this->ocspValues = $value;
  }

  public function withOCSPValues(OCSPValuesType $value) {
    $this->setOCSPValues($value);
    return $this;
  }

  public function getOtherValues() {
    return $this->otherValues;
  }

  public function setOtherValues(OtherCertStatusValuesType $value) {
    $this->otherValues = $value;
  }

  public function withOtherValues(OtherCertStatusValuesType $value) {
    $this->setOtherValues($value);
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

