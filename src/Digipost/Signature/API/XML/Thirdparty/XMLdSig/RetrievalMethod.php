<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class RetrievalMethod
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="RetrievalMethodType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}Transforms" minOccurs="0"/>
 *       </sequence>
 *       <attribute name="URI" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *       <attribute name="Type" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\AccessorOrder("custom",custom={"transforms"})
 * @Serializer\XmlRoot(name="RetrievalMethod")
 */
class RetrievalMethod {

  /**
   * @var Transforms
   * @Serializer\XmlElement()
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transforms")
   */
  protected $transforms;

  /**
   * @var String
   * @Serializer\XmlAttribute()
   * @Serializer\Type("string")
   * @Serializer\SerializedName("URI")
   */
  protected $uri;

  /**
   * @var String
   * @Serializer\XmlAttribute()
   * @Serializer\Type("string")
   */
  protected $type;

  public function __construct(Transforms $transforms = NULL, String $uri = NULL,
                              String $type = NULL) {
    $this->transforms = $transforms;
    $this->uri = $uri;
    $this->type = $type;
    return $this;
  }

  public function getTransforms() {
    return $this->transforms;
  }

  public function setTransforms($value) {
    $this->transforms = $value;
  }

  public function getURI() {
    return $this->uri;
  }

  public function setURI($value) {
    $this->uri = $value;
  }

  public function getType() {
    return $this->type;
  }

  public function setType($value) {
    $this->type = $value;
  }
}

