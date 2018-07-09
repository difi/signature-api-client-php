<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Object
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="ObjectType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence maxOccurs="unbounded" minOccurs="0">
 *         <any processContents='lax'/>
 *       </sequence>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *       <attribute name="MimeType" type="{http://www.w3.org/2001/XMLSchema}string" />
 *       <attribute name="Encoding" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *          
 * @Serializer\XmlRoot(name="Object")
 */
class XMLObject {

  /**
   * @Serializer\XmlList(inline=true)
   * @Serializer\Type("array<any>")
   */
  protected $content;

  /**
   * @Serializer\XmlAttribute()
   */
  protected $id;

  /**
   * @Serializer\XmlAttribute()
   */
  protected $mimeType;

  /**
   * @Serializer\XmlAttribute()
   */
  protected $encoding;

  public function __construct(array $content = NULL, String $id = NULL,
                              String $mimeType = NULL,
                              String $encoding = NULL) {
    $this->content = $content;
    $this->id = $id;
    $this->mimeType = $mimeType;
    $this->encoding = $encoding;
    return $this;
  }

  public function getContent() {
    if ($this->content === NULL) {
      $this->content = [];
    }
    return $this->content;
  }

  public function getId() {
    return $this->id;
  }

  public function setId($value) {
    $this->id = $value;
  }

  public function getMimeType() {
    return $this->mimeType;
  }

  public function setMimeType($value) {
    $this->mimeType = $value;
  }

  public function getEncoding() {
    return $this->encoding;
  }

  public function setEncoding($value) {
    $this->encoding = $value;
  }
}

