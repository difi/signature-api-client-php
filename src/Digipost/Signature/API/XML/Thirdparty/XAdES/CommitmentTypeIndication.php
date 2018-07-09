<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class CommitmentTypeIndication
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="CommitmentTypeIndicationType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="CommitmentTypeId" type="{http://uri.etsi.org/01903/v1.3.2#}ObjectIdentifierType"/>
 *         <choice>
 *           <element name="ObjectReference" type="{http://www.w3.org/2001/XMLSchema}anyURI" maxOccurs="unbounded"/>
 *           <element name="AllSignedDataObjects" type="{http://www.w3.org/2001/XMLSchema}anyType"/>
 *         </choice>
 *         <element name="CommitmentTypeQualifiers" type="{http://uri.etsi.org/01903/v1.3.2#}CommitmentTypeQualifiersListType" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\AccessorOrder("custom", custom={
 *   "commitmentTypeId",
 *   "allSignedDataObjects",
 *   "objectReferences",
 *   "commitmentTypeQualifiers"
 * })
 */
class CommitmentTypeIndication {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\ObjectIdentifier")
   */
  protected $commitmentTypeId;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("object")
   */
  protected $allSignedDataObjects;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type(array<String>)
   */
  protected $objectReferences;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\CommitmentTypeQualifiersListType")
   */
  protected $commitmentTypeQualifiers;

  public function __construct(ObjectIdentifier $commitmentTypeId = NULL,
                              $allSignedDataObjects = NULL,
                              array $objectReferences = NULL,
                              CommitmentTypeQualifiersListType $commitmentTypeQualifiers = NULL) {

    $this->commitmentTypeId = $commitmentTypeId;
    $this->allSignedDataObjects = $allSignedDataObjects;
    $this->objectReferences = $objectReferences;
    $this->commitmentTypeQualifiers = $commitmentTypeQualifiers;
    return $this;
  }

  public function getCommitmentTypeId() {
    return $this->commitmentTypeId;
  }

  public function setCommitmentTypeId(ObjectIdentifier $value) {
    $this->commitmentTypeId = $value;
  }

  public function withCommitmentTypeId(ObjectIdentifier $value) {
    $this->setCommitmentTypeId($value);
    return $this;
  }

  public function getAllSignedDataObjects() {
    return $this->allSignedDataObjects;
  }

  public function setAllSignedDataObjects($value) {
    $this->allSignedDataObjects = $value;
  }

  public function withAllSignedDataObjects($value) {
    $this->setAllSignedDataObjects($value);
    return $this;
  }

  public function &getObjectReferences() {
    if ($this->objectReferences === NULL) {
      $this->objectReferences = [];
    }
    return $this->objectReferences;
  }

  public function withObjectReferences($values) {
    $content =& $this->getObjectReferences();
    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }

  public function getCommitmentTypeQualifiers() {
    return $this->commitmentTypeQualifiers;
  }

  public function setCommitmentTypeQualifiers(CommitmentTypeQualifiersListType $value) {
    $this->commitmentTypeQualifiers = $value;
  }

  public function withCommitmentTypeQualifiers(CommitmentTypeQualifiersListType $value) {
    $this->setCommitmentTypeQualifiers($value);
    return $this;
  }
}

