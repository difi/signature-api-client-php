<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class SigningCertificate
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="CertIDListType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="Cert" type="{http://uri.etsi.org/01903/v1.3.2#}CertIDType" maxOccurs="unbounded"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="SigningCertificate")
 */
class SigningCertificate {

  /**
   * @var CertIDType[] $certs
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType>")
   * @Serializer\XmlList(entry="Cert", inline=true)
   */
  protected $certs;

  public function __construct(array $certs = NULL) {
    $this->certs = $certs;
    return $this;
  }

  public function &getCerts() {
    if ($this->certs === NULL) {
      $this->certs = [];
    }
    return $this->certs;
  }

  public function withCerts(array $values) {
    $content =& $this->getCerts();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }
}

