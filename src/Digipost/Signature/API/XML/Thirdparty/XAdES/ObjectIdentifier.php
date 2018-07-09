<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class ObjectIdentifier
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="ObjectIdentifierType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="Identifier" type="{http://uri.etsi.org/01903/v1.3.2#}IdentifierType"/>
 *         <element name="Description" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
 *         <element name="DocumentationReferences" type="{http://uri.etsi.org/01903/v1.3.2#}DocumentationReferencesType" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="ObjectIdentifier")
 * @Serializer\AccessorOrder("custom", custom={
 *   "identifier",
 *   "description",
 *   "documentationReferences"
 * })
 */
class ObjectIdentifier {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\IdentifierType")
   */
  protected $identifier;

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $description;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\DocumentationReferencesType")
   */
  protected $documentationReferences;  // DocumentationReferencesType

  public function __construct(IdentifierType $identifier = NULL,
                              String $description = NULL,
                              DocumentationReferencesType $documentationReferences = NULL) {
    $this->identifier = $identifier;
    $this->description = $description;
    $this->documentationReferences = $documentationReferences;
    return $this;
  }

  public function getIdentifier() {
    return $this->identifier;
  }

  public function setIdentifier($value) {
    $this->identifier = $value;
  }

  public function withIdentifier($value) {
    $this->setIdentifier($value);
    return $this;
  }

  public function getDescription() {
    return $this->description;
  }

  public function setDescription($value) {
    $this->description = $value;
  }

  public function withDescription($value) {
    $this->setDescription($value);
    return $this;
  }

  public function getDocumentationReferences() {
    return $this->documentationReferences;
  }

  public function setDocumentationReferences($value) {
    $this->documentationReferences = $value;
  }

  public function withDocumentationReferences($value) {
    $this->setDocumentationReferences($value);
    return $this;
  }
}

