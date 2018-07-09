<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class CommitmentTypeQualifiersListType
 *
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="CommitmentTypeQualifiersListType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="CommitmentTypeQualifier" type="{http://uri.etsi.org/01903/v1.3.2#}AnyType" maxOccurs="unbounded" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class CommitmentTypeQualifiersListType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<any>")
   * @Serializer\SerializedName("CommitmentTypeQualifier")
   */
  protected $commitmentTypeQualifiers;

  public function __construct(array $commitmentTypeQualifiers = NULL) {

    $this->commitmentTypeQualifiers = $commitmentTypeQualifiers;
    return $this;
  }

  public function &getCommitmentTypeQualifiers() {
    if ($this->commitmentTypeQualifiers === NULL) {
      $this->commitmentTypeQualifiers = [];
    }
    return $this->commitmentTypeQualifiers;
  }

  public function withCommitmentTypeQualifiers($values) {
    $content =& $this->getCommitmentTypeQualifiers();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }

}

