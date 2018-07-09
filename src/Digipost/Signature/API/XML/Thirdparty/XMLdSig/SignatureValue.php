<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class SignatureValue
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="SignatureValueType">
 *   <simpleContent>
 *     <extension base="<http://www.w3.org/2001/XMLSchema>base64Binary">
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </extension>
 *   </simpleContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\XmlRoot(name="SignatureValue")
 */
class SignatureValue {

  /**
   * @Serializer\XmlValue(cdata=false)
   */
  protected $value;

  /**
   * @Serializer\XmlAttribute()
   */
  protected $id;

  public function __construct($value = NULL, $id = NULL) {
    $this->value = $value;
    $this->id = $id;
    return $this;
  }

  public function getValue() {
    return $this->value;
  }

  public function setValue($value) {
    $this->value = $value;
  }

  public function getId() {
    return $this->id;
  }

  public function setId($value) {
    $this->id = $value;
  }

  public function withValue($value) {
    $this->setValue($value);
    return $this;
  }

  public function withId($value) {
    $this->setId($value);
    return $this;
  }
}

