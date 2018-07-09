<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use Digipost\Signature\API\XML\Thirdparty\XMLdSig\CanonicalizationMethod;
use Ds\Map;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class GenericTimeStampType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * ```xml
 * <complexType name="GenericTimeStampType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <choice minOccurs="0">
 *           <element ref="{http://uri.etsi.org/01903/v1.3.2#}Include" maxOccurs="unbounded" minOccurs="0"/>
 *           <element ref="{http://uri.etsi.org/01903/v1.3.2#}ReferenceInfo" maxOccurs="unbounded"/>
 *         </choice>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}CanonicalizationMethod" minOccurs="0"/>
 *         <choice maxOccurs="unbounded">
 *           <element name="EncapsulatedTimeStamp" type="{http://uri.etsi.org/01903/v1.3.2#}EncapsulatedPKIDataType"/>
 *           <element name="XMLTimeStamp" type="{http://uri.etsi.org/01903/v1.3.2#}AnyType"/>
 *         </choice>
 *       </sequence>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * ```
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 * @see     XAdESTimeStampType
 * @see     OtherTimeStamp
 *
 * @Serializer\AccessorOrder("custom", custom={
 *   "referenceInfos",
 *   "includes",
 *   "canonicalizationMethod",
 *   "encapsulatedTimeStampsAndXMLTimeStamps"
 * })
 */
class GenericTimeStampType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XAdES\ReferenceInfo>")
   * @Serializer\SerializedName("ReferenceInfo")
   */
  protected $referenceInfos;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XAdES\IncludeType>")
   * @Serializer\SerializedName("Include")
   */
  protected $includes;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XMLdSig\CanonicalizationMethod")
   */
  protected $canonicalizationMethod;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<any>")
   */
  protected $encapsulatedTimeStampsAndXMLTimeStamps;

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("Id")
   */
  protected $id;

  public function __construct(array $referenceInfos = NULL,
                              array $includes = NULL,
                              CanonicalizationMethod $canonicalizationMethod = NULL,
                              array $encapsulatedTimeStampsAndXMLTimeStamps = NULL,
                              String $id = NULL) {
    $this->referenceInfos = $referenceInfos;
    $this->includes = $includes;
    $this->canonicalizationMethod = $canonicalizationMethod;
    $this->encapsulatedTimeStampsAndXMLTimeStamps = $encapsulatedTimeStampsAndXMLTimeStamps;
    $this->id = $id;
    return $this;
  }

  public function &getReferenceInfos() {
    if ($this->referenceInfos === NULL) {
      $this->referenceInfos = [];
    }
    return $this->referenceInfos;
  }

  public function withReferenceInfos(array $values) {
    $content =& $this->getReferenceInfos();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }

  public function &getIncludes() {
    if ($this->includes === NULL) {
      $this->includes = [];
    }
    return $this->includes;
  }

  public function withIncludes(array $values) {
    $content =& $this->getIncludes();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }

  public function getCanonicalizationMethod() {
    return $this->canonicalizationMethod;
  }

  public function setCanonicalizationMethod(CanonicalizationMethod $value) {
    $this->canonicalizationMethod = $value;
  }

  public function withCanonicalizationMethod(CanonicalizationMethod $value) {
    $this->setCanonicalizationMethod($value);
    return $this;
  }

  public function &getEncapsulatedTimeStampsAndXMLTimeStamps() {
    if ($this->encapsulatedTimeStampsAndXMLTimeStamps === NULL) {
      $this->encapsulatedTimeStampsAndXMLTimeStamps = [];
    }
    return $this->encapsulatedTimeStampsAndXMLTimeStamps;
  }

  public function withEncapsulatedTimeStampsAndXMLTimeStamps(array $values) {
    $content =& $this->getEncapsulatedTimeStampsAndXMLTimeStamps();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
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

