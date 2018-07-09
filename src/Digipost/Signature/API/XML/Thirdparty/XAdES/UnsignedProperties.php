<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class UnsignedProperties
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="UnsignedPropertiesType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="UnsignedSignatureProperties" type="{http://uri.etsi.org/01903/v1.3.2#}UnsignedSignaturePropertiesType" minOccurs="0"/>
 *         <element name="UnsignedDataObjectProperties" type="{http://uri.etsi.org/01903/v1.3.2#}UnsignedDataObjectPropertiesType" minOccurs="0"/>
 *       </sequence>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="UnsignedProperties", namespace="http://uri.etsi.org/01903/v1.3.2#")
 * @Serializer\AccessorOrder("custom", custom={
 *   "unsignedSignatureProperties",
 *   "unsignedDataObjectProperties"
 * })
 */
class UnsignedProperties {

  /**
   * @var UnsignedSignatureProperties
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\UnsignedSignatureProperties")
   */
  protected $unsignedSignatureProperties;

  /**
   * @var UnsignedDataObjectProperties
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\UnsignedDataObjectProperties")
   */
  protected $unsignedDataObjectProperties;

  /**
   * @var String
   * @Serializer\XmlAttribute()
   */
  protected $id;

  public function __construct(UnsignedSignatureProperties $unsignedSignatureProperties = NULL,
                              UnsignedDataObjectProperties $unsignedDataObjectProperties = NULL,
                              String $id = NULL) {
    $this->unsignedSignatureProperties = $unsignedSignatureProperties;
    $this->unsignedDataObjectProperties = $unsignedDataObjectProperties;
    $this->id = $id;
    return $this;
  }

  public function getUnsignedSignatureProperties() {
    return $this->unsignedSignatureProperties;
  }

  public function setUnsignedSignatureProperties(UnsignedSignatureProperties $value) {
    $this->unsignedSignatureProperties = $value;
  }

  public function withUnsignedSignatureProperties(UnsignedSignatureProperties $value) {
    $this->setUnsignedSignatureProperties($value);
    return $this;
  }

  public function getUnsignedDataObjectProperties() {
    return $this->unsignedDataObjectProperties;
  }

  public function setUnsignedDataObjectProperties(UnsignedDataObjectProperties $value) {
    $this->unsignedDataObjectProperties = $value;
  }

  public function withUnsignedDataObjectProperties(UnsignedDataObjectProperties $value) {
    $this->setUnsignedDataObjectProperties($value);
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

