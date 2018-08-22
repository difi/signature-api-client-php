<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLSender
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="sender">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="organization-number">
 *           <simpleType>
 *             <restriction base="{http://www.w3.org/2001/XMLSchema}string">
 *               <pattern value="[0-9]{9}"/>
 *             </restriction>
 *           </simpleType>
 *         </element>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML
 *
 * @Serializer\XmlNamespace("http://signering.posten.no/schema/v1")
 * @Serializer\AccessorOrder("custom", custom={"organizationNumber"})
 */
class XMLSender {

  /**
   * @Serializer\Type("string")
   * @Serializer\SerializedName("organization-number")
   * @Serializer\XmlElement(namespace="http://signering.posten.no/schema/v1")
   */
  protected $organizationNumber;

  function __construct(String $organizationNumber = NULL) {
    $this->organizationNumber = $organizationNumber;
  }

  public function getOrganizationNumber() {
    return $this->organizationNumber;
  }

  public function setOrganizationNumber($value) {
    $this->organizationNumber = $value;
  }

  public function withOrganizationNumber($value) {
    $this->organizationNumber = $value;
    return $this;
  }
}

