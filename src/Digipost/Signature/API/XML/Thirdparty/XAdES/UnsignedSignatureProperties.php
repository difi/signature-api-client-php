<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class UnsignedSignatureProperties
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="UnsignedSignaturePropertiesType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <choice maxOccurs="unbounded">
 *         <element name="CounterSignature" type="{http://uri.etsi.org/01903/v1.3.2#}CounterSignatureType"/>
 *         <element name="SignatureTimeStamp" type="{http://uri.etsi.org/01903/v1.3.2#}XAdESTimeStampType"/>
 *         <element name="CompleteCertificateRefs" type="{http://uri.etsi.org/01903/v1.3.2#}CompleteCertificateRefsType"/>
 *         <element name="CompleteRevocationRefs" type="{http://uri.etsi.org/01903/v1.3.2#}CompleteRevocationRefsType"/>
 *         <element name="AttributeCertificateRefs" type="{http://uri.etsi.org/01903/v1.3.2#}CompleteCertificateRefsType"/>
 *         <element name="AttributeRevocationRefs" type="{http://uri.etsi.org/01903/v1.3.2#}CompleteRevocationRefsType"/>
 *         <element name="SigAndRefsTimeStamp" type="{http://uri.etsi.org/01903/v1.3.2#}XAdESTimeStampType"/>
 *         <element name="RefsOnlyTimeStamp" type="{http://uri.etsi.org/01903/v1.3.2#}XAdESTimeStampType"/>
 *         <element name="CertificateValues" type="{http://uri.etsi.org/01903/v1.3.2#}CertificateValuesType"/>
 *         <element name="RevocationValues" type="{http://uri.etsi.org/01903/v1.3.2#}RevocationValuesType"/>
 *         <element name="AttrAuthoritiesCertValues" type="{http://uri.etsi.org/01903/v1.3.2#}CertificateValuesType"/>
 *         <element name="AttributeRevocationValues" type="{http://uri.etsi.org/01903/v1.3.2#}RevocationValuesType"/>
 *         <element name="ArchiveTimeStamp" type="{http://uri.etsi.org/01903/v1.3.2#}XAdESTimeStampType"/>
 *         <any namespace='##other'/>
 *       </choice>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="UnsignedSignatureProperties")
 */
class UnsignedSignatureProperties {

  /** @var Object[] $counterSignaturesAndSignatureTimeStampsAndCompleteCertificateRefs */
  protected $counterSignaturesAndSignatureTimeStampsAndCompleteCertificateRefs;

  protected $id;

  public function __construct(array $counterSignaturesAndSignatureTimeStampsAndCompleteCertificateRefs = NULL,
                              String $id = NULL) {
    $this->counterSignaturesAndSignatureTimeStampsAndCompleteCertificateRefs = $counterSignaturesAndSignatureTimeStampsAndCompleteCertificateRefs;
    $this->id = $id;
    return $this;
  }

  public function &getCounterSignaturesAndSignatureTimeStampsAndCompleteCertificateRefs() {
    if ($this->counterSignaturesAndSignatureTimeStampsAndCompleteCertificateRefs === NULL) {
      $this->counterSignaturesAndSignatureTimeStampsAndCompleteCertificateRefs = [];
    }
    return $this->counterSignaturesAndSignatureTimeStampsAndCompleteCertificateRefs;
  }

  public function setCounterSignaturesAndSignatureTimeStampsAndCompleteCertificateRefs(array $values) {
    $content =& $this->getCounterSignaturesAndSignatureTimeStampsAndCompleteCertificateRefs();

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

