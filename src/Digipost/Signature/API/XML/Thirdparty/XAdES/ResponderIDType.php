<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class ResponderIDType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="ResponderIDType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <choice>
 *         <element name="ByName" type="{http://www.w3.org/2001/XMLSchema}string"/>
 *         <element name="ByKey" type="{http://www.w3.org/2001/XMLSchema}base64Binary"/>
 *       </choice>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\AccessorOrder("custom", custom={"byKey","byName"})
 */
class ResponderIDType {

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $byKey;

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $byName;

  public function __construct(String $byKey = NULL, String $byName = NULL) {
    $this->byKey = $byKey;
    $this->byName = $byName;
    return $this;
  }

  public function getByKey() {
    return $this->byKey;
  }

  public function setByKey(String $value) {
    $this->byKey = $value;
  }

  public function withByKey(String $value) {
    $this->setByKey($value);
    return $this;
  }

  public function getByName() {
    return $this->byName;
  }

  public function setByName(String $value) {
    $this->byName = $value;
  }

  public function withByName(String $value) {
    $this->setByName($value);
    return $this;
  }
}

