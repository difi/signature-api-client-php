<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;


use JMS\Serializer\Annotation as Serializer;

/**
 * Class SignedDataObjectProperties
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="SignedDataObjectPropertiesType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="DataObjectFormat" type="{http://uri.etsi.org/01903/v1.3.2#}DataObjectFormatType" maxOccurs="unbounded" minOccurs="0"/>
 *         <element name="CommitmentTypeIndication" type="{http://uri.etsi.org/01903/v1.3.2#}CommitmentTypeIndicationType" maxOccurs="unbounded" minOccurs="0"/>
 *         <element name="AllDataObjectsTimeStamp" type="{http://uri.etsi.org/01903/v1.3.2#}XAdESTimeStampType" maxOccurs="unbounded" minOccurs="0"/>
 *         <element name="IndividualDataObjectsTimeStamp" type="{http://uri.etsi.org/01903/v1.3.2#}XAdESTimeStampType" maxOccurs="unbounded" minOccurs="0"/>
 *       </sequence>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="SignedDataObjectProperties")
 * @Serializer\AccessorOrder("custom", custom={
 *   "dataObjectFormats",
 *   "commitmentTypeIndications",
 *   "allDataObjectsTimeStamps",
 *   "individualDataObjectsTimeStamps"
 * })
 */
class SignedDataObjectProperties {

  /**
   * @var DataObjectFormat[] $dataObjectFormats
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XAdES\DataObjectFormat>")
   * @Serializer\XmlList(entry="DataObjectFormat", inline=true)
   */
  protected $dataObjectFormats;

  /**
   * @var CommitmentTypeIndication[] $commitmentTypeIndications
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XAdES\CommitmentTypeIndication>")
   */
  protected $commitmentTypeIndications;

  /**
   * @var XAdESTimeStampType[] $allDataObjectsTimeStamps
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType>")
   */
  protected $allDataObjectsTimeStamps;

  /**
   * @var XAdESTimeStampType[] $individualDataObjectsTimeStamps
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType>")
   */
  protected $individualDataObjectsTimeStamps;

  protected $id;

  public function __construct(array $dataObjectFormats = NULL,
                              array $commitmentTypeIndications = NULL,
                              array $allDataObjectsTimeStamps = NULL,
                              array $individualDataObjectsTimeStamps = NULL,
                              String $id = NULL) {
    $this->dataObjectFormats = $dataObjectFormats;
    $this->commitmentTypeIndications = $commitmentTypeIndications;
    $this->allDataObjectsTimeStamps = $allDataObjectsTimeStamps;
    $this->individualDataObjectsTimeStamps = $individualDataObjectsTimeStamps;
    $this->id = $id;
    return $this;
  }

  public function &getDataObjectFormats() {
    if ($this->dataObjectFormats === NULL) {
      $this->dataObjectFormats = [];
    }
    return $this->dataObjectFormats;
  }

  public function withDataObjectFormats(array $values) {
    $content =& $this->getDataObjectFormats();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }

  public function &getCommitmentTypeIndications() {
    if ($this->commitmentTypeIndications === NULL) {
      $this->commitmentTypeIndications = [];
    }
    return $this->commitmentTypeIndications;
  }

  public function withCommitmentTypeIndications(array $values) {
    $content =& $this->getCommitmentTypeIndications();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }

  public function &getAllDataObjectsTimeStamps() {
    if ($this->allDataObjectsTimeStamps === NULL) {
      $this->allDataObjectsTimeStamps = [];
    }
    return $this->allDataObjectsTimeStamps;
  }

  public function withAllDataObjectsTimeStamps(array $values) {
    $content =& $this->getAllDataObjectsTimeStamps();

    if ($values !== NULL) {
      foreach ($values as $value) {
        $content[] = $value;
      }
    }
    return $this;
  }

  public function &getIndividualDataObjectsTimeStamps() {
    if ($this->individualDataObjectsTimeStamps === NULL) {
      $this->individualDataObjectsTimeStamps = [];
    }
    return $this->individualDataObjectsTimeStamps;
  }

  public function withIndividualDataObjectsTimeStamps(array $values) {
    $content =& $this->getIndividualDataObjectsTimeStamps();

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

