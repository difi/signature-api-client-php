<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;


use JMS\Serializer\Annotation as Serializer;

/**
 * Class CertifiedRolesListType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="CertifiedRolesListType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="CertifiedRole" type="{http://uri.etsi.org/01903/v1.3.2#}EncapsulatedPKIDataType" maxOccurs="unbounded"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class CertifiedRolesListType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIData>")
   * @Serializer\SerializedName("CertifiedRole")
   */
  protected $certifiedRoles;

  public function __construct($certifiedRoles = NULL) {

    $this->certifiedRoles = $certifiedRoles;
    return $this;
  }

  public function &getCertifiedRoles() {
    if ($this->certifiedRoles === NULL) {
      $this->certifiedRoles = [];
    }
    return $this->certifiedRoles;
  }

  /**
   * @param EncapsulatedPKIData[] $values
   *
   * @return $this
   */
  public function withCertifiedRoles(array $values) {
    $content =& $this->getCertifiedRoles();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }
}

