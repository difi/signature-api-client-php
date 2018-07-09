<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class SignatureProperty
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="SignaturePropertyType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <choice maxOccurs="unbounded">
 *         <any processContents='lax' namespace='##other'/>
 *       </choice>
 *       <attribute name="Target" use="required" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\XmlRoot(name="SignatureProperty")
 */
class SignatureProperty {

  /**
   * @var array
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<any>")
   */
  protected $content;

  /**
   * @var String
   * @Serializer\XmlAttribute()
   */
  protected $target;

  /**
   * @var String
   * @Serializer\XmlAttribute()
   */
  protected $id;

  public function __construct(array $content = NULL, String $target = NULL,
                              String $id = NULL) {
    $this->content = $content;
    $this->target = $target;
    $this->id = $id;
    return $this;
  }

  public function getContent() {
    if ($this->content === NULL) {
      $this->content = [];
    }
    return $this->content;
  }

  public function getTarget() {
    return $this->target;
  }

  public function setTarget($value) {
    $this->target = $value;
  }

  public function getId() {
    return $this->id;
  }

  public function setId($value) {
    $this->id = $value;
  }
}

