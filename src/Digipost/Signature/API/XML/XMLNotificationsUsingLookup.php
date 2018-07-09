<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLNotificationsUsingLookup
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="notifications-using-lookup">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="email" type="{http://signering.posten.no/schema/v1}enabled"/>
 *         <element name="sms" type="{http://signering.posten.no/schema/v1}enabled" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML
 *
 * @Serializer\AccessorOrder("custom", custom={"email", "sms"})
 */
class XMLNotificationsUsingLookup {

  protected $email;  // XMLEnabled

  protected $sms;  // XMLEnabled

  function __construct(XMLEnabled $email = NULL, XMLEnabled $sms = NULL) {
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

