<?php

namespace Digipost\Signature\API\XML\Thirdparty\ASiCe;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class SigReference
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="SigReferenceType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <attribute name="URI" use="required" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *       <attribute name="MimeType" type="{http://www.w3.org/2001/XMLSchema}string" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\ASiCe
 *
 * @Serializer\XmlRoot(namespace="SigReference")
 */
class SigReference {

  /**
   * @var String
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("URI")
   */
  protected $uri;

  /**
   * @var String
   * @Serializer\XmlAttribute()
   */
  protected $mimeType;

  public function __construct(String $uri = NULL, String $mimeType = NULL) {
    $this->uri = $uri;
    $this->mimeType = $mimeType;
  }

  public function getURI() {
    return $this->uri;
  }

  public function setURI($value) {
    $this->uri = $value;
  }

  public function getMimeType() {
    return $this->mimeType;
  }

  public function setMimeType($value) {
    $this->mimeType = $value;
  }

  public function withURI($value) {
    $this->setURI($value);
    return $this;
  }

  public function withMimeType($value) {
    $this->setMimeType($value);
    return $this;
  }
}

