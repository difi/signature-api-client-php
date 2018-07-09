<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use Ds\Map;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class SignatureProperties
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="SignaturePropertiesType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}SignatureProperty" maxOccurs="unbounded"/>
 *       </sequence>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\XmlRoot(name="SignatureProperties")
 */
class SignatureProperties {

  /**
   * @var SignatureProperty[] $signatureProperties
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureProperty>")
   */
  protected $signatureProperties;

  /**
   * @var String
   * @Serializer\XmlAttribute()
   */
  protected $id;

  public function __construct(array $signatureProperties = NULL,
                              String $id = NULL) {
    $this->signatureProperties = $signatureProperties;
    $this->id = $id;
    return $this;
  }

  public function getSignatureProperties() {
    if ($this->signatureProperties === NULL) {
      $this->signatureProperties = [];
    }
    return $this->signatureProperties;
  }

  public function getId() {
    return $this->id;
  }

  public function setId($value) {
    $this->id = $value;
  }

  public function withId($value) {
    $this->setId($value);
    return $this;
  }
}

