<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use Digipost\Signature\API\XML\Thirdparty\XMLdSig\X509IssuerSerialType;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class CertIDType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="CertIDType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="CertDigest" type="{http://uri.etsi.org/01903/v1.3.2#}DigestAlgAndValueType"/>
 *         <element name="IssuerSerial" type="{http://www.w3.org/2000/09/xmldsig#}X509IssuerSerialType"/>
 *       </sequence>
 *       <attribute name="URI" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class CertIDType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType")
   */
  protected $certDigest;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XMLdSig\X509IssuerSerialType")
   */
  protected $issuerSerial;

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("URI")
   */
  protected $uri;

  public function __construct(DigestAlgAndValueType $certDigest = NULL,
                              X509IssuerSerialType $issuerSerial = NULL,
                              String $uri = NULL) {

    $this->certDigest = $certDigest;
    $this->issuerSerial = $issuerSerial;
    $this->uri = $uri;
    return $this;
  }

  public function getCertDigest() {
    return $this->certDigest;
  }

  public function setCertDigest(DigestAlgAndValueType $value) {
    $this->certDigest = $value;
  }


  public function withCertDigest(DigestAlgAndValueType $value) {
    $this->setCertDigest($value);
    return $this;
  }

  public function getIssuerSerial() {
    return $this->issuerSerial;
  }

  public function setIssuerSerial(X509IssuerSerialType $value) {
    $this->issuerSerial = $value;
  }


  public function withIssuerSerial(X509IssuerSerialType $value) {
    $this->setIssuerSerial($value);
    return $this;
  }

  public function getURI() {
    return $this->uri;
  }

  public function setURI($value) {
    $this->uri = $value;
  }

  public function withURI(String $value) {
    $this->setURI($value);
    return $this;
  }
}

