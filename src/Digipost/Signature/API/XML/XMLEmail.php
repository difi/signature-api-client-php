<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLEmail
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="email">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <attribute name="address" use="required" type="{http://www.w3.org/2001/XMLSchema}string" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML
 */
class XMLEmail {

  /**
   * @Serializer\XmlAttribute()
   */
  protected $address;

  function __construct(String $address = NULL) {
    $this->address = $address;
  }

  public function getAddress() {
    return $this->address;
  }

  public function setAddress($value) {
    $this->address = $value;
  }
}

