<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use Doctrine\Common\Annotations\Annotation\Required;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class QualifyingPropertiesReference
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="QualifyingPropertiesReferenceType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <attribute name="URI" use="required" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *          
 * @Serializer\XmlRoot(name="QualifyingPropertiesReference")
 */
class QualifyingPropertiesReference {

  /**
   * @Serializer\Type("string")
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("URI")
   * @Required()
   */
  protected $uri;

  /**
   * @Serializer\Type("string")
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("Id")
   */
  protected $id;

  public function __construct(String $uri = NULL, String $id = NULL) {
    $this->uri = $uri;
    $this->id = $id;
    return $this;
  }

  public function getURI() {
    return $this->uri;
  }

  public function setURI(String $value) {
    $this->uri = $value;
  }

  public function withURI(String $value) {
    $this->setURI($value);
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

