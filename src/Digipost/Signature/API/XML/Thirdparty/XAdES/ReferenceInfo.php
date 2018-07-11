<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class ReferenceInfo
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="ReferenceInfoType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}DigestMethod"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}DigestValue"/>
 *       </sequence>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *       <attribute name="URI" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="ReferenceInfo")
 * @Serializer\AccessorOrder("custom", custom={"digestMethod","digestValue"})
 */
class ReferenceInfo {

  /**
   * @Serializer\XmlElement(namespace="http://www.w3.org/2000/09/xmldsig#")
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod")
   */
  protected $digestMethod;

  /**
   * @Serializer\XmlElement(namespace="http://www.w3.org/2000/09/xmldsig#")
   * @Serializer\Type("string")
   */
  protected $digestValue;

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\Type("string")
   */
  protected $id;

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\Type("string")
   * @Serializer\SerializedName("URI")
   */
  protected $uri;

  public function __construct(DigestMethod $digestMethod = NULL,
                              String $digestValue = NULL,
                              String $id = NULL, String $uri = NULL) {
    $this->digestMethod = $digestMethod;
    $this->digestValue = $digestValue;
    $this->id = $id;
    $this->uri = $uri;
    return $this;
  }

  public function getDigestMethod() {
    return $this->digestMethod;
  }

  public function setDigestMethod(DigestMethod $value) {
    $this->digestMethod = $value;
  }

  public function withDigestMethod(DigestMethod $value) {
    $this->setDigestMethod($value);
    return $this;
  }

  public function getDigestValue() {
    return $this->digestValue;
  }

  public function setDigestValue(String $value) {
    $this->digestValue = $value;
  }

  public function withDigestValue(String $value) {
    $this->setDigestValue($value);
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

  public function getURI() {
    return $this->uri;
  }

  public function setURI(String $value) {
    $this->uri = $value;
  }

  public function withURI(String $value) {
    $this->setURI($value);
    return $this;
  }
}

