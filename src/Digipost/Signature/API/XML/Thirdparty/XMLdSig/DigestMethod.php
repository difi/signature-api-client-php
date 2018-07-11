<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class DigestMethod
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="DigestMethodType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <any processContents='lax' namespace='##other' maxOccurs="unbounded" minOccurs="0"/>
 *       </sequence>
 *       <attribute name="Algorithm" use="required" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\XmlRoot(name="DigestMethod")
 */
class DigestMethod {

  /**
   * @Serializer\Type("array<any>")
   * @Serializer\XmlList(entry="DigestMethod", inline=true)
   */
  protected $content;

  /**
   * @Serializer\XmlAttribute(namespace="{http://www.w3.org/2001/XMLSchema}anyURI")
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

  public function withAlgorithm($value) {
    $this->algorithm = $value;
    return $this;
  }

}

