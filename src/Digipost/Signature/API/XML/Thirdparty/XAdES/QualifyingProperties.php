<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class QualifyingProperties
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="QualifyingPropertiesType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="SignedProperties" type="{http://uri.etsi.org/01903/v1.3.2#}SignedPropertiesType" minOccurs="0"/>
 *         <element name="UnsignedProperties" type="{http://uri.etsi.org/01903/v1.3.2#}UnsignedPropertiesType" minOccurs="0"/>
 *       </sequence>
 *       <attribute name="Target" use="required" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="QualifyingProperties")
 * @Serializer\AccessorOrder("custom", custom={
 *   "signedProperties",
 *   "unsignedProperties"
 * })
 */
class QualifyingProperties {

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\SignedProperties")
   */
  protected $signedProperties;

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\UnsignedProperties")
   */
  protected $unsignedProperties;

  /**
   * @Serializer\XmlAttribute()
   */
  protected $target;

  /**
   * @Serializer\XmlAttribute()
   */
  protected $id;

  /**
   * QualifyingProperties constructor.
   *
   * @param SignedProperties   $signedProperties
   * @param UnsignedProperties $unsignedProperties
   * @param String             $target
   * @param String             $id
   */
  public function __construct(SignedProperties $signedProperties = NULL,
                              UnsignedProperties $unsignedProperties = NULL,
                              String $target = NULL,
                              String $id = NULL) {
    $this->signedProperties = $signedProperties;
    $this->unsignedProperties = $unsignedProperties;
    $this->target = $target;
    $this->id = $id;
    return $this;
  }

  public function getSignedProperties() {
    return $this->signedProperties;
  }

  public function setSignedProperties(SignedProperties $value) {
    $this->signedProperties = $value;
  }

  public function withSignedProperties(SignedProperties $value) {
    $this->setSignedProperties($value);
    return $this;
  }

  public function getUnsignedProperties() {
    return $this->unsignedProperties;
  }

  public function setUnsignedProperties(UnsignedProperties $value) {
    $this->unsignedProperties = $value;
  }

  public function withUnsignedProperties(UnsignedProperties $value) {
    $this->setUnsignedProperties($value);
    return $this;
  }

  public function getTarget() {
    return $this->target;
  }

  public function setTarget(String $value) {
    $this->target = $value;
  }

  public function withTarget(String $value) {
    $this->setTarget($value);
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

