<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class KeyInfo
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="KeyInfoType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <choice maxOccurs="unbounded">
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}KeyName"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}KeyValue"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}RetrievalMethod"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}X509Data"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}PGPData"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}SPKIData"/>
 *         <element ref="{http://www.w3.org/2000/09/xmldsig#}MgmtData"/>
 *         <any processContents='lax' namespace='##other'/>
 *       </choice>
 *       <attribute name="Id" type="{http://www.w3.org/2001/XMLSchema}ID" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\XmlRoot(name="KeyInfo")
 * @Serializer\AccessorOrder("custom", custom={"content"})
 */
class KeyInfo {

  /**
   * @Serializer\XmlMap()
   */
  protected $content;

  /**
   * @Serializer\XmlAttribute()
   */
  protected $id;

  public function __construct(array $content = NULL, String $id = NULL) {
    $this->content = $content;
    $this->id = $id;
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
}

