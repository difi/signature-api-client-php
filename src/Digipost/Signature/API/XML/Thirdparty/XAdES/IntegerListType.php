<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class IntegerListType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="IntegerListType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="int" type="{http://www.w3.org/2001/XMLSchema}integer" maxOccurs="unbounded" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class IntegerListType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<int>")
   */
  protected $ints;

  public function __construct(array $ints = NULL) {
    $this->ints = $ints;
    return $this;
  }

  public function &getInts() {
    if ($this->ints === NULL) {
      $this->ints = [];
    }
    return $this->ints;
  }

  public function withInts(array $values) {
    $content =& $this->getInts();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }
}

