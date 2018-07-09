<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class CompleteCertificateRefsType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="CompleteCertificateRefsType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="CertRefs" type="{http://uri.etsi.org/01903/v1.3.2#}CertIDListType"/>
 *       </sequence>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class CompleteCertificateRefsType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\SigningCertificate")
   */
  protected $certRefs;

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("Id")
   */
  protected $id;

  public function __construct(SigningCertificate $certRefs = NULL,
                              String $id = NULL) {
    $this->certRefs = $certRefs;
    $this->id = $id;
  }

  public function getCertRefs() {
    return $this->certRefs;
  }

  public function setCertRefs(SigningCertificate $value) {
    $this->certRefs = $value;
  }

  public function withCertRefs(SigningCertificate $value) {
    $this->setCertRefs($value);
    return $this;
  }

  public function getId() {
    return $this->id;
  }

  public function setId(String $value) {
    $this->id = $value;
  }

  public function withId(String $value) {
    $this->setId($value);
    return $this;
  }
}

