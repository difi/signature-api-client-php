<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;


use JMS\Serializer\Annotation as Serializer;

/**
 * Class SignedProperties
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="SignedPropertiesType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="SignedSignatureProperties" type="{http://uri.etsi.org/01903/v1.3.2#}SignedSignaturePropertiesType" minOccurs="0"/>
 *         <element name="SignedDataObjectProperties" type="{http://uri.etsi.org/01903/v1.3.2#}SignedDataObjectPropertiesType" minOccurs="0"/>
 *       </sequence>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="SignedProperties", namespace="http://uri.etsi.org/01903/v1.3.2#")
 * @Serializer\AccessorOrder("custom", custom={
 *   "signedSignatureProperties",
 *   "signedDataObjectProperties"
 * })
 */
class SignedProperties {

  /**
   * @Serializer\XmlElement()
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\SignedSignatureProperties")
   */
  protected $signedSignatureProperties;

  /**
   * @Serializer\XmlElement()
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\SignedDataObjectProperties")
   */
  protected $signedDataObjectProperties;

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\Type("string")
   */
  protected $id;

  /**
   * SignedProperties constructor.
   *
   * @param SignedSignatureProperties  $signedSignatureProperties
   * @param SignedDataObjectProperties $signedDataObjectProperties
   * @param String                     $id
   */
  public function __construct(SignedSignatureProperties $signedSignatureProperties = NULL,
                              SignedDataObjectProperties $signedDataObjectProperties = NULL,
                              String $id = NULL) {
    $this->signedSignatureProperties = $signedSignatureProperties;
    $this->signedDataObjectProperties = $signedDataObjectProperties;
    $this->id = $id;
    return $this;
  }

  public function getSignedSignatureProperties() {
    return $this->signedSignatureProperties;
  }

  public function setSignedSignatureProperties(SignedSignatureProperties $value) {
    $this->signedSignatureProperties = $value;
  }

  public function withSignedSignatureProperties(SignedSignatureProperties $value) {
    $this->setSignedSignatureProperties($value);
    return $this;
  }

  public function getSignedDataObjectProperties() {
    return $this->signedDataObjectProperties;
  }

  public function setSignedDataObjectProperties(SignedDataObjectProperties $value) {
    $this->signedDataObjectProperties = $value;
  }

  public function withSignedDataObjectProperties(SignedDataObjectProperties $value) {
    $this->setSignedDataObjectProperties($value);
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

