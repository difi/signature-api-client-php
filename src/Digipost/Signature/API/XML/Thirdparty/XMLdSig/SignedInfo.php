<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class SignedInfo
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="SignedInfoType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}CanonicalizationMethod"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}SignatureMethod"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}Reference" maxOccurs="unbounded"/>
 *       </sequence>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\XmlRoot(name="SignedInfo")
 * @Serializer\AccessorOrder("custom", custom = {
 *   "canonicalizationMethod",
 *   "signatureMethod",
 *   "references"
 * })
 */
class SignedInfo {

  /**
   * @var CanonicalizationMethod
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XMLdSig\CanonicalizationMethod")
   */
  protected $canonicalizationMethod;

  /**
   * @var SignatureMethod
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureMethod")
   */
  protected $signatureMethod;

  /**
   * @var Reference[]
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XMLdSig\Reference>")
   */
  protected $references;

  /**
   * @var string
   * @Serializer\XmlAttribute()
   * @Serializer\SkipWhenEmpty()
   */
  protected $id;

  public function __construct(CanonicalizationMethod $canonicalizationMethod = NULL,
                              SignatureMethod $signatureMethod = NULL,
                              array $references = NULL, String $id = NULL) {

    $this->canonicalizationMethod = $canonicalizationMethod;
    $this->signatureMethod = $signatureMethod;
    $this->references = $references;
    $this->id = $id;
    return $this;
  }

  public function getCanonicalizationMethod() {
    return $this->canonicalizationMethod;
  }

  public function setCanonicalizationMethod($value) {
    $this->canonicalizationMethod = $value;
  }

  public function getSignatureMethod() {
    return $this->signatureMethod;
  }

  public function setSignatureMethod($value) {
    $this->signatureMethod = $value;
  }

  public function getReferences() {
    if ($this->references === NULL) {
      $this->references = [];
    }
    return $this->references;
  }

  public function getId() {
    return $this->id;
  }

  public function setId($value) {
    $this->id = $value;
  }
}

