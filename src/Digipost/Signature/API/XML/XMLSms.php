<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLSms
 *
 * <p>Java class for sms complex type.
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="sms">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <attribute name="number" use="required" type="{http://www.w3.org/2001/XMLSchema}string" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML
 */
class XMLSms {

  /**
   * @Serializer\XmlAttribute()
   */
  protected $number;

  function __construct(String $number = NULL) {
    $this->number = $number;
  }

  public function getNumber() {
    return $this->number;
  }

  public function setNumber($value) {
    $this->number = $value;
  }
}

