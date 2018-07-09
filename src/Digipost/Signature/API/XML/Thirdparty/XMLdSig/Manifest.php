<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use Ds\Map;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class Manifest
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="ManifestType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}Reference" maxOccurs="unbounded"/>
 *       </sequence>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\XmlRoot(name="Manifest")
 */
class Manifest {

  /**
   * @var Reference[]
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XMLdSig\Reference>")
   */
  protected $references;

  /**
   * @var String
   * @Serializer\XmlAttribute()
   */
  protected $id;

  public function __construct(array $references = NULL, String $id = NULL) {
    $this->references = $references;
    $this->id = $id;
    return $this;
  }

  public function &getReferences() {
    if ($this->references === NULL) {
      $this->references = [];
    }
    return $this->references;
  }

  public function withReferences(array $values) {
    $content =& $this->getReferences();
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

  public function setId($value) {
    $this->id = $value;
  }

  public function withId($value) {
    $this->setId($value);
    return $this;
  }
}

