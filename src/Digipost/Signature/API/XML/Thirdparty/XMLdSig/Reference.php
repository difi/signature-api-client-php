<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Reference
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="ReferenceType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}Transforms" minOccurs="0"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}DigestMethod"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}DigestValue"/>
 *       </sequence>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *       <attribute name="URI" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *       <attribute name="Type" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\AccessorOrder("custom", custom = {
 *   "transforms",
 *   "digestMethod",
 *   "digestValue"
 * })
 */
class Reference {

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transforms")
   * @Serializer\SerializedName("Transforms")
   */
  protected $transforms;

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod")
   * @Serializer\SerializedName("DigestMethod")
   */
  protected $digestMethod;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\SerializedName("DigestValue")
   */
  protected $digestValue;  // byte[]

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("ID")
   */
  protected $id;  // String

  /**
   * @Serializer\XmlAttribute
   * @Serializer\SerializedName("URI")
   */
  protected $uri;  // String

  /**
   * @Serializer\XmlAttribute
   * @Serializer\SerializedName("Type")
   */
  protected $type;

  public function __construct(Transforms $transforms = NULL,
                              DigestMethod $digestMethod = NULL,
                              String $digestValue = NULL, String $id = NULL,
                              String $uri = NULL, String $type = NULL) {

    $this->transforms = $transforms;
    $this->digestMethod = $digestMethod;
    $this->digestValue = $digestValue;
    $this->id = $id;
    $this->uri = $uri;
    $this->type = $type;
    return $this;
  }

  public function getTransforms() {
    return $this->transforms;
  }

  public function setTransforms($value) {
    $this->transforms = $value;
  }

  public function getDigestMethod() {
    return $this->digestMethod;
  }

  public function setDigestMethod($value) {
    $this->digestMethod = $value;
  }

  public function getDigestValue() {
    return $this->digestValue;
  }

  public function setDigestValue($value) {
    $this->digestValue = $value;
  }

  public function getId() {
    return $this->id;
  }

  public function setId($value) {
    $this->id = $value;
  }

  public function getURI() {
    return $this->uri;
  }

  public function setURI($value) {
    $this->uri = $value;
  }

  public function getType() {
    return $this->type;
  }

  public function setType($value) {
    $this->type = $value;
  }

  public function withTransforms($value) {
    $this->setTransforms($value);
    return $this;
  }

  public function withDigestMethod($value) {
    $this->setDigestMethod($value);
    return $this;
  }

  public function withDigestValue($value) {
    $this->setDigestValue($value);
    return $this;
  }

  public function withId($value) {
    $this->setId($value);
    return $this;
  }

  public function withURI($value) {
    $this->setURI($value);
    return $this;
  }

  public function withType($value) {
    $this->setType($value);
    return $this;
  }
}

