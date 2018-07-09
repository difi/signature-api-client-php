<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class SPKIData
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="SPKIDataType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence maxOccurs="unbounded">
 *         <element name="SPKISexp" type="{http://www.w3.org/2001/XMLSchema}base64Binary"/>
 *         <any processContents='lax' namespace='##other' minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\XmlRoot(name="SPKIData")
 */
class SPKIData {

  /**
   * @var array
   * @Serializer\XmlList(entry="SPKISexp", namespace="http://www.w3.org/2000/09/xmldsig#")
   * @Serializer\Type("array<any>")
   */
  protected $spkiSexpsAndAnies;

  public function __construct(array $spkiSexpsAndAnies = NULL) {
    $this->spkiSexpsAndAnies = $spkiSexpsAndAnies;
    return $this;
  }

  public function getSPKISexpsAndAnies() {
    if ($this->spkiSexpsAndAnies === NULL) {
      $this->spkiSexpsAndAnies = [];
    }
    return $this->spkiSexpsAndAnies;
  }
}

