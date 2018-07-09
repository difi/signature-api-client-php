<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class DataObjectFormat
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="DataObjectFormatType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="Description" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
 *         <element name="ObjectIdentifier" type="{http://uri.etsi.org/01903/v1.3.2#}ObjectIdentifierType" minOccurs="0"/>
 *         <element name="MimeType" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
 *         <element name="Encoding" type="{http://www.w3.org/2001/XMLSchema}anyURI" minOccurs="0"/>
 *       </sequence>
 *       <attribute name="ObjectReference" use="required" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="DataObjectFormat")
 * @Serializer\AccessorOrder("custom", custom={
 *   "description",
 *   "objectIdentifier",
 *   "mimeType",
 *   "encoding"
 * })
 */
class DataObjectFormat {

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $description;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\ObjectIdentifier")
   */
  protected $objectIdentifier;

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $mimeType;

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $encoding;

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("ObjectReference")
   */
  protected $objectReference;

  public function __construct(String $description = NULL,
                              ObjectIdentifier $objectIdentifier = NULL,
                              String $mimeType = NULL,
                              String $encoding = NULL,
                              String $objectReference = NULL) {

    $this->description = $description;
    $this->objectIdentifier = $objectIdentifier;
    $this->mimeType = $mimeType;
    $this->encoding = $encoding;
    $this->objectReference = $objectReference;
    return $this;
  }

  public function getDescription() {
    return $this->description;
  }

  public function setDescription(String $value) {
    $this->description = $value;
  }

  public function getObjectIdentifier() {
    return $this->objectIdentifier;
  }

  public function setObjectIdentifier(ObjectIdentifier $value) {
    $this->objectIdentifier = $value;
  }

  public function getMimeType() {
    return $this->mimeType;
  }

  public function setMimeType(String $value) {
    $this->mimeType = $value;
  }

  public function getEncoding() {
    return $this->encoding;
  }

  public function setEncoding(String $value) {
    $this->encoding = $value;
  }

  public function getObjectReference() {
    return $this->objectReference;
  }

  public function setObjectReference(String $value) {
    $this->objectReference = $value;
  }

  public function withDescription(String $value) {
    $this->setDescription($value);
    return $this;
  }

  public function withObjectIdentifier(ObjectIdentifier $value) {
    $this->setObjectIdentifier($value);
    return $this;
  }

  public function withMimeType(String $value) {
    $this->setMimeType($value);
    return $this;
  }

  public function withEncoding(String $value) {
    $this->setEncoding($value);
    return $this;
  }

  public function withObjectReference(String $value) {
    $this->setObjectReference($value);
    return $this;
  }
}

