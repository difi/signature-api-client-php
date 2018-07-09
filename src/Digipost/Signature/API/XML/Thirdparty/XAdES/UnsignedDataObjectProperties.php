<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class UnsignedDataObjectProperties
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="UnsignedDataObjectPropertiesType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="UnsignedDataObjectProperty" type="{http://uri.etsi.org/01903/v1.3.2#}AnyType" maxOccurs="unbounded"/>
 *       </sequence>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="UnsignedDataObjectProperties")
 */
class UnsignedDataObjectProperties {

  /**
   * @var array
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<any>")
   * @Serializer\SerializedName("UnsignedDataObjectProperty")
   */
  protected $unsignedDataObjectProperties;

  /**
   * @var String
   * @Serializer\XmlAttribute()
   */
  protected $id;

  public function __construct(array $unsignedDataObjectProperties = NULL,
                              String $id = NULL) {
    $this->unsignedDataObjectProperties = $unsignedDataObjectProperties;
    $this->id = $id;
    return $this;
  }

  public function &getUnsignedDataObjectProperties() {
    if ($this->unsignedDataObjectProperties === NULL) {
      $this->unsignedDataObjectProperties = [];
    }
    return $this->unsignedDataObjectProperties;
  }

  public function withUnsignedDataObjectProperties(array $values) {
    $content =& $this->getUnsignedDataObjectProperties();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }

  public function getId() {
    return $this->id;
  }

  public function setId(String $value) {
    $this->id = $value;
  }

  public function withId(String $value) {
    $this->setId($value);
    return $this;
  }
}

