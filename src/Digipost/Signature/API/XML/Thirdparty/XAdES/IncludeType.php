<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class IncludeType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="IncludeType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <attribute name="URI" use="required" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *       <attribute name="referencedData" type="{http://www.w3.org/2001/XMLSchema}boolean" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="Include")
 */
class IncludeType {

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("URI")
   */
  protected $uri;

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\Type("boolean")
   */
  protected $referencedData;

  public function __construct(String $uri = NULL, bool $referencedData = NULL) {
    $this->uri = $uri;
    $this->referencedData = $referencedData;
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

  public function isReferencedData() {
    return $this->referencedData;
  }

  public function setReferencedData(bool $value) {
    $this->referencedData = $value;
  }

  public function withReferencedData(bool $value) {
    $this->setReferencedData($value);
    return $this;
  }
}

