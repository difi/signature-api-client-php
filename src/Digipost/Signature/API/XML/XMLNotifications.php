<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLNotifications
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="notifications">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <choice>
 *         <sequence>
 *           <element name="email" type="{http://signering.posten.no/schema/v1}email"/>
 *           <element name="sms" type="{http://signering.posten.no/schema/v1}sms" minOccurs="0"/>
 *         </sequence>
 *         <element name="sms" type="{http://signering.posten.no/schema/v1}sms"/>
 *       </choice>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML
 *
 * @Serializer\AccessorOrder("custom", custom = {"email", "sms"})
 */
class XMLNotifications {

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\XMLEmail")
   */
  protected $email;

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\XMLSms")
   */
  protected $sms;

  function __construct(XMLEmail $email = NULL, XMLSms $sms = NULL) {
    $this->email = $email;
    $this->sms = $sms;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($value) {
    $this->email = $value;
  }

  public function getSms() {
    return $this->sms;
  }

  public function setSms($value) {
    $this->sms = $value;
  }
}

