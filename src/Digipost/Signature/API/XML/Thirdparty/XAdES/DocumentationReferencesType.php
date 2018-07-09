<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class DocumentationReferencesType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="DocumentationReferencesType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence maxOccurs="unbounded">
 *         <element name="DocumentationReference" type="{http://www.w3.org/2001/XMLSchema}anyURI"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 */
class DocumentationReferencesType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<String>")
   * @Serializer\SerializedName("DocumentationReference")
   */
  protected $documentationReferences;

  public function __construct(array $documentationReferences = NULL) {
    $this->documentationReferences = $documentationReferences;
    return $this;
  }

  public function &getDocumentationReferences() {
    if ($this->documentationReferences === NULL) {
      $this->documentationReferences = [];
    }
    return $this->documentationReferences;
  }

  public function withDocumentationReferences(array $values) {
    $content =& $this->getDocumentationReferences();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }
}

