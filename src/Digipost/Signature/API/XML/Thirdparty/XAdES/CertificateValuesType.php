<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class CertificateValuesType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="CertificateValuesType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <choice maxOccurs="unbounded" minOccurs="0">
 *         <element name="EncapsulatedX509Certificate" type="{http://uri.etsi.org/01903/v1.3.2#}EncapsulatedPKIDataType"/>
 *         <element name="OtherCertificate" type="{http://uri.etsi.org/01903/v1.3.2#}AnyType"/>
 *       </choice>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class CertificateValuesType {

  /**
   * @Serializer\XmlList(entry="EncapsulatedX509Certificate", inline=true)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIData>")
   *
   */
  protected $encapsulatedX509CertificatesAndOtherCertificates;

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("ID")
   */
  protected $id;

  public function __construct(array $encapsulatedX509CertificatesAndOtherCertificates = NULL,
                              String $id = NULL) {

    $this->encapsulatedX509CertificatesAndOtherCertificates = $encapsulatedX509CertificatesAndOtherCertificates;
    $this->id = $id;
    return $this;
  }

  public function &getEncapsulatedX509CertificatesAndOtherCertificates() {
    if (($this->encapsulatedX509CertificatesAndOtherCertificates === NULL)) {
      $this->encapsulatedX509CertificatesAndOtherCertificates = [];
    }
    return $this->encapsulatedX509CertificatesAndOtherCertificates;
  }


  public function withEncapsulatedX509CertificatesAndOtherCertificates(array $values) {
    $content =& $this->getEncapsulatedX509CertificatesAndOtherCertificates();
    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
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

