<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Transform
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="TransformType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <choice maxOccurs="unbounded" minOccurs="0">
 *         <any processContents='lax' namespace='##other'/>
 *         <element name="XPath" type="{http://www.w3.org/2001/XMLSchema}string"/>
 *       </choice>
 *       <attribute name="Algorithm" use="required" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\XmlRoot(name="Transform")
 */
class Transform {

  /**
   * @Serializer\XmlList(entry="XPath", namespace="http://www.w3.org/2000/09/xmldsig#")
   */
  protected $content;

  /**
   * @Serializer\XmlAttribute
   * @Serializer\SerializedName("Algorithm")
   */
  protected $algorithm;

  public function __construct(array $content = NULL, String $algorithm = NULL) {
    $this->content = $content;
    $this->algorithm = $algorithm;
    return $this;
  }

  public function getContent() {
    if ($this->content === NULL) {
      $this->content = [];
    }
    return $this->content;
  }

  public function getAlgorithm() {
    return $this->algorithm;
  }

  public function setAlgorithm($value) {
    $this->algorithm = $value;
  }
}

