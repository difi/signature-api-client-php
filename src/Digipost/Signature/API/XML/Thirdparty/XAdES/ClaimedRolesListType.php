<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class ClaimedRolesListType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="ClaimedRolesListType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="ClaimedRole" type="{http://uri.etsi.org/01903/v1.3.2#}AnyType" maxOccurs="unbounded"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class ClaimedRolesListType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<any>")
   * @Serializer\SerializedName("ClaimedRole")
   */
  protected $claimedRoles;

  public function __construct(array $claimedRoles = NULL) {

    $this->claimedRoles = $claimedRoles;
    return $this;
  }

  public function &getClaimedRoles() {
    if ($this->claimedRoles === NULL) {
      $this->claimedRoles = [];
    }
    return $this->claimedRoles;
  }

  public function withClaimedRoles(array $values) {
    $content =& $this->getClaimedRoles();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }
}

