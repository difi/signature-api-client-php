<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class IdentifierType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="IdentifierType">
 *   <simpleContent>
 *     <extension base="<http://www.w3.org/2001/XMLSchema>anyURI">
 *       <attribute name="Qualifier" type="{http://uri.etsi.org/01903/v1.3.2#}QualifierType" />
 *     </extension>
 *   </simpleContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class IdentifierType {

  /**
   * @Serializer\XmlValue(cdata=false)
   */
  protected $value;

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\QualifierType")
   */
  protected $qualifier;

  public function __construct(String $value = NULL,
                              QualifierType $qualifier = NULL) {
    $this->value = $value;
    $this->qualifier = $qualifier;
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

  public function getQualifier() {
    return $this->qualifier;
  }

  public function setQualifier(QualifierType $value) {
    $this->qualifier = $value;
  }

  public function withQualifier(QualifierType $value) {
    $this->setQualifier($value);
    return $this;
  }
}

