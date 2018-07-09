<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class SigPolicyQualifiersListType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="SigPolicyQualifiersListType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="SigPolicyQualifier" type="{http://uri.etsi.org/01903/v1.3.2#}AnyType" maxOccurs="unbounded"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class SigPolicyQualifiersListType {

  /**
   * @var array
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<any>")
   * @Serializer\SerializedName("SigPolicyQualifier")
   */
  protected $sigPolicyQualifiers;

  public function __construct(array $sigPolicyQualifiers = NULL) {
    $this->sigPolicyQualifiers = $sigPolicyQualifiers;
    return $this;
  }

  public function &getSigPolicyQualifiers() {
    if ($this->sigPolicyQualifiers === NULL) {
      $this->sigPolicyQualifiers = [];
    }
    return $this->sigPolicyQualifiers;
  }

  public function withSigPolicyQualifiers(array $values) {
    $content =& $this->getSigPolicyQualifiers();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }
}

