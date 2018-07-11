<?php

namespace Digipost\Signature\API\XML\Thirdparty\ASiCe;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class AnyType
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
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\ASiCe
 * @see \Digipost\Signature\API\XML\Thirdparty\ASiCe\Extension
 *
 * @Serializer\AccessorOrder("custom", custom={"content"})
 */
class AnyType {

  /**
   * @var Object[] $content
   * @Serializer\XmlElement(cdata=false)
   */
  protected $content;

  public function __construct(array $content = NULL) {
    $this->content = $content;
  }

  public function &getContent() {
    if ($this->content === NULL) {
      $this->content = [];
    }
    return $this->content;
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

