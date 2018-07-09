<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class SignerRole
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="SignerRoleType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="ClaimedRoles" type="{http://uri.etsi.org/01903/v1.3.2#}ClaimedRolesListType" minOccurs="0"/>
 *         <element name="CertifiedRoles" type="{http://uri.etsi.org/01903/v1.3.2#}CertifiedRolesListType" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="SignerRole")
 * @Serializer\AccessorOrder("custom", custom={
 *   "claimedRoles",
 *   "certifiedRoles"
 * })
 */
class SignerRole {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\ClaimedRolesListType")
   */
  protected $claimedRoles;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\CertifiedRolesListType")
   */
  protected $certifiedRoles;

  public function __construct(ClaimedRolesListType $claimedRoles = NULL,
                              CertifiedRolesListType $certifiedRoles = NULL) {

    $this->claimedRoles = $claimedRoles;
    $this->certifiedRoles = $certifiedRoles;
    return $this;
  }

  public function getClaimedRoles() {
    return $this->claimedRoles;
  }

  public function setClaimedRoles(ClaimedRolesListType $value) {
    $this->claimedRoles = $value;
  }

  public function withClaimedRoles(ClaimedRolesListType $value) {
    $this->setClaimedRoles($value);
    return $this;
  }

  public function getCertifiedRoles() {
    return $this->certifiedRoles;
  }

  public function setCertifiedRoles(CertifiedRolesListType $value) {
    $this->certifiedRoles = $value;
  }

  public function withCertifiedRoles(CertifiedRolesListType $value) {
    $this->setCertifiedRoles($value);
    return $this;
  }
}

