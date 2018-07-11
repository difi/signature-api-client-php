<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use Digipost\Signature\Client\Core\Internal\XMLSignContext;
use Doctrine\Common\Annotations\Annotation\Enum;
use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class Signature
 *
 * <p>The following schema fragment specifies the expected content contained
 * within this class.
 *
 * <pre>
 * <complexType name="SignatureType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}SignedInfo"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}SignatureValue"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}KeyInfo" minOccurs="0"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}Object" maxOccurs="unbounded" minOccurs="0"/>
 *       </sequence>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID"/>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\XmlRoot(name="Signature")
 * @Serializer\AccessorOrder("custom", custom = {
 *   "signedInfo",
 *   "signatureValue",
 *   "keyInfo",
 *   "objects"
 * })
 */
class Signature {

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignedInfo")
   * @Serializer\XmlElement()
   * @Serializer\SerializedName("SignedInfo")
   */
  protected $signedInfo;

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureValue")
   * @Serializer\XmlElement()
   */
  protected $signatureValue;

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XMLdSig\KeyInfo")
   * @Serializer\XmlElement()
   */
  protected $keyInfo;

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XMLdSig\ObjectType")
   * @Serializer\XmlElement()
   * @Serializer\SerializedName("Object")
   */
  protected $objects;

  /**
   * @Serializer\Type("string")
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("ID")
   */
  protected $id;

  /**
   * Fully-initialising value constructor
   *
   * @param SignedInfo     $signedInfo
   * @param SignatureValue $signatureValue
   * @param KeyInfo        $keyInfo
   * @param array          $objects
   * @param String         $id
   */
  public function __construct(SignedInfo $signedInfo = NULL,
                              SignatureValue $signatureValue = NULL,
                              KeyInfo $keyInfo = NULL,
                              array $objects = NULL, String $id = NULL) {
    $this->signedInfo = $signedInfo;
    $this->signatureValue = $signatureValue;
    $this->keyInfo = $keyInfo;
    $this->objects = $objects;
    $this->id = $id;
  }

  /**
   * @return mixed
   */
  public function getSignedInfo() {
    return $this->signedInfo;
  }

  /**
   * @param mixed $signedInfo
   */
  public function setSignedInfo($signedInfo) {
    $this->signedInfo = $signedInfo;
  }

  /**
   * @return mixed
   */
  public function getSignatureValue() {
    return $this->signatureValue;
  }

  /**
   * @param mixed $signatureValue
   */
  public function setSignatureValue($signatureValue) {
    $this->signatureValue = $signatureValue;
  }

  /**
   * @return mixed
   */
  public function getKeyInfo() {
    return $this->keyInfo;
  }

  /**
   * @param mixed $keyInfo
   */
  public function setKeyInfo($keyInfo) {
    $this->keyInfo = $keyInfo;
  }

  /**
   * @return mixed
   */
  public function getObjects() {
    return $this->objects;
  }

  /**
   * @param mixed $objects
   */
  public function setObjects($objects) {
    $this->objects = $objects;
  }

  /**
   * @return mixed
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @param mixed $id
   */
  public function setId($id) {
    $this->id = $id;
  }

  public function withSignedInfo(SignedInfo $value) {
    $this->setSignedInfo($value);
    return $this;
  }

  public function withSignatureValue(SignatureValue $value) {
    $this->setSignatureValue($value);
    return $this;
  }

  public function withKeyInfo(KeyInfo $value) {
    $this->setKeyInfo($value);
    return $this;
  }

  public function withObjects($values) {
    if ($values !== NULL) {
      foreach ($values as $value) {
        $this->getObjects()->add($value);
      }
    }
    return $this;
  }

  public function withId(String $value) {
    $this->setId($value);
    return $this;
  }

  public function sign(XMLSignContext $context) {
    /** @var \DOMElement $var1 */
    $var1 = $context->getParent();
    $var2 = clone $var1;
    Marshalling::marshal($var1, $var2->nextSibling);
    //print $var2->saveXML();
    $signatureIdMap = [];
    $signatureIdMap[$this->id] = $this;
    $signatureIdMap[$this->signedInfo->getId()] = $this->signedInfo;
    //print_r($domResult->saveXML());
    $refs = $this->signedInfo->getReferences();
    foreach ($refs as $reference) {
      /** @var Reference $reference */
      $signatureIdMap[$reference->getId()] = $reference;
    }

    $objects = $this->getObjects();
    foreach ($objects as $object) {
      /** @var ObjectType $object */
      $signatureIdMap[$object->getId()] = $object;
      $content = $object->getContent();
      foreach ($content as $contentItem) {
        /**  */
        //$signatureIdMap[$contentItem->getId()] = $contentItem;
      }
    }
  }
}
