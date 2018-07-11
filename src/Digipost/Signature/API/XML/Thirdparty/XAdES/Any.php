<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Any
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="AnyType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence maxOccurs="unbounded" minOccurs="0">
 *         <any processContents='lax'/>
 *       </sequence>
 *       <anyAttribute/>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class Any {

  /**
   * @Serializer\XmlElement()
   * @Serializer\Type("array<object>")
   */
  protected $content;

  /**
   * @Serializer\Type("array<QName, string>")
   * @Serializer\XmlAttributeMap()
   */
  protected $otherAttributes;  // array<QName, String>

  private function __init() { // default class members
    $this->otherAttributes = [];
  }

  public function __construct(array $content = NULL,
                              array $otherAttributes = NULL) {

    $this->__init();
    $this->content = $content;
    $this->otherAttributes = $otherAttributes;
    return $this;
  }

  public function &getContent() {
    if ($this->content === NULL) {
      $this->content = [];
    }
    return $this->content;
  }

  public function getOtherAttributes() {
    return $this->otherAttributes;
  }

  public function withContent(array $values) {
    $content =& $this->getContent();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }
}

