<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class EncapsulatedPKIData
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="EncapsulatedPKIDataType">
 *   <simpleContent>
 *     <extension base="<http://www.w3.org/2001/XMLSchema>base64Binary">
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *       <attribute name="Encoding" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *     </extension>
 *   </simpleContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="EncapsulatedPKIData")
 */
class EncapsulatedPKIData {

  /**
   * @Serializer\XmlValue(cdata=false)
   */
  protected $value;

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("Id")
   */
  protected $id;

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("Encoding")
   */
  protected $encoding;

  public function __construct(String $value = NULL, String $id = NULL,
                              String $encoding = NULL) {
    $this->value = $value;
    $this->id = $id;
    $this->encoding = $encoding;
    return $this;
  }

  public function getValue() {
    return $this->value;
  }

  public function setValue(String $value) {
    $this->value = $value;
  }

  public function withValue(String $value) {
    $this->setValue($value);
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

  public function getEncoding() {
    return $this->encoding;
  }

  public function setEncoding(String $value) {
    $this->encoding = $value;
  }

  public function withEncoding(String $value) {
    $this->setEncoding($value);
    return $this;
  }
}

