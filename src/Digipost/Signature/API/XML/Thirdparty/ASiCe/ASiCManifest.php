<?php

namespace Digipost\Signature\API\XML\Thirdparty\ASiCe;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class ASiCManifest
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="ASiCManifestType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element ref="{http://uri.etsi.org/2918/v1.2.1#}SigReference"/>
 *         <element ref="{http://uri.etsi.org/2918/v1.2.1#}DataObjectReference" maxOccurs="unbounded"/>
 *         <element name="ASiCManifestExtensions" type="{http://uri.etsi.org/2918/v1.2.1#}ExtensionsListType" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\ASiCe
 *
 * @Serializer\XmlRoot(name="ASiCManifest")
 * @Serializer\AccessorOrder("custom", custom={
 *   "sigReference",
 *   "dataObjectReferences",
 *   "aSiCManifestExtensions"
 * })
 */
class ASiCManifest {

  /**
   * @var SigReference
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\ASiCe\SigReference")
   */
  protected $sigReference;

  /**
   * @var DataObjectReference[]
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\ASiCe\DataObjectReference>")
   */
  protected $dataObjectReferences;

  /**
   * @var ExtensionsListType
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\ASiCe\ExtensionsListType")
   * @Serializer\SerializedName("ASiCManifestExtensions")
   */
  protected $aSiCManifestExtensions;

  public function __construct(SigReference $sigReference = NULL,
                              array $dataObjectReferences = NULL,
                              ExtensionsListType $aSiCManifestExtensions = NULL) {
    $this->sigReference = $sigReference;
    $this->dataObjectReferences = $dataObjectReferences;
    $this->aSiCManifestExtensions = $aSiCManifestExtensions;
  }

  public function getSigReference() {
    return $this->sigReference;
  }

  public function setSigReference($value) {
    $this->sigReference = $value;
  }

  public function getDataObjectReferences() {
    if ($this->dataObjectReferences === NULL) {
      $this->dataObjectReferences = [];
    }
    return $this->dataObjectReferences;
  }

  public function getASiCManifestExtensions() {
    return $this->aSiCManifestExtensions;
  }

  public function setASiCManifestExtensions($value) {
    $this->aSiCManifestExtensions = $value;
  }
}

