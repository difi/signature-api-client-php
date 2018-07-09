<?php

namespace Digipost\Signature\API\XML\Thirdparty\ASiCe;

use Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class DataObjectReference
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="DataObjectReferenceType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}DigestMethod"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}DigestValue"/>
 *         <element name="DataObjectReferenceExtensions" type="{http://uri.etsi.org/2918/v1.2.1#}ExtensionsListType" minOccurs="0"/>
 *       </sequence>
 *       <attribute name="URI" use="required" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *       <attribute name="MimeType" type="{http://www.w3.org/2001/XMLSchema}string" />
 *       <attribute name="Rootfile" type="{http://www.w3.org/2001/XMLSchema}boolean" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\ASiCe
 *
 * @Serializer\XmlRoot(name="DataObjectReference")
 * @Serializer\AccessorOrder("custom", custom={
 *   "digestMethod",
 *   "digestValue",
 *   "dataObjectReferenceExtensions"
 * })
 */
class DataObjectReference {

  /**
   * @var DigestMethod
   * @Serializer\XmlElement(cdata=false, namespace="http://www.w3.org/2000/09/xmldsig#")
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod")
   */
  protected $digestMethod;

  /**
   * @var string
   * @Serializer\XmlElement(cdata=false, namespace="http://www.w3.org/2000/09/xmldsig#")
   */
  protected $digestValue;

  /**
   * @var ExtensionsListType
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\ASiCe\ExtensionsListType")
   */
  protected $dataObjectReferenceExtensions;

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

  /**
   * @var bool
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("Rootfile")
   */
  protected $rootFile;

  public function __construct(DigestMethod $digestMethod = NULL,
                              string $digestValue = NULL,
                              ExtensionsListType $dataObjectReferenceExtensions = NULL,
                              String $uri = NULL,
                              String $mimeType = NULL,
                              bool $rootFile = NULL) {

    $this->digestMethod = $digestMethod;
    $this->digestValue = $digestValue;
    $this->dataObjectReferenceExtensions = $dataObjectReferenceExtensions;
    $this->uri = $uri;
    $this->mimeType = $mimeType;
    $this->rootFile = $rootFile;
  }

  public function getDigestMethod() {
    return $this->digestMethod;
  }

  public function setDigestMethod($value) {
    $this->digestMethod = $value;
  }

  public function getDigestValue() {
    return $this->digestValue;
  }

  public function setDigestValue($value) // [byte[] value]
  {
    $this->digestValue = $value;
  }

  public function getDataObjectReferenceExtensions() {
    return $this->dataObjectReferenceExtensions;
  }

  public function setDataObjectReferenceExtensions($value) {
    $this->dataObjectReferenceExtensions = $value;
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

  public function isRootFile() {
    return $this->rootFile;
  }

  public function setRootFile($value) {
    $this->rootFile = $value;
  }

  public function withDigestMethod($value) {
    $this->setDigestMethod($value);
    return $this;
  }

  public function withDigestValue($value) // [byte[] value]
  {
    $this->setDigestValue($value);
    return $this;
  }

  public function withDataObjectReferenceExtensions($value) {
    $this->setDataObjectReferenceExtensions($value);
    return $this;
  }

  public function withURI($value) {
    $this->setURI($value);
    return $this;
  }

  public function withMimeType($value) {
    $this->setMimeType($value);
    return $this;
  }

  public function withRootFile($value) {
    $this->setRootFile($value);
    return $this;
  }
}

