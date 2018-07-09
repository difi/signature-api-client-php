<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class PGPData
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="PGPDataType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <choice>
 *         <sequence>
 *           <element name="PGPKeyID" type="{http://www.w3.org/2001/XMLSchema}base64Binary"/>
 *           <element name="PGPKeyPacket" type="{http://www.w3.org/2001/XMLSchema}base64Binary" minOccurs="0"/>
 *           <any processContents='lax' namespace='##other' maxOccurs="unbounded" minOccurs="0"/>
 *         </sequence>
 *         <sequence>
 *           <element name="PGPKeyPacket" type="{http://www.w3.org/2001/XMLSchema}base64Binary"/>
 *           <any processContents='lax' namespace='##other' maxOccurs="unbounded" minOccurs="0"/>
 *         </sequence>
 *       </choice>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *          
 * @Serializer\XmlRoot(name="PGPData")
 * @Serializer\AccessorOrder("custom", custom={
 *   "pgpKeyID",
 *   "pgpKeyPacket",
 *   "anies"
 * })
 */
class PGPData {

  /**
   * @var string
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\SerializedName("PGPKeyID")
   */
  protected $pgpKeyID;

  /**
   * @var string
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\SerializedName("PGPKeyPacket")
   */
  protected $pgpKeyPacket;

  /**
   * @var \DOMElement[] $anies
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("array<DOMElement>")
   */
  protected $anies;

  public function __construct($pgpKeyID = NULL, $pgpKeyPacket = NULL,
                              array $anies = NULL) {

    $this->pgpKeyID = $pgpKeyID;
    $this->pgpKeyPacket = $pgpKeyPacket;
    $this->anies = $anies;
    return $this;
  }

  public function getPGPKeyID() {
    return $this->pgpKeyID;
  }

  public function setPGPKeyID($value) {
    $this->pgpKeyID = $value;
  }

  public function getPGPKeyPacket() {
    return $this->pgpKeyPacket;
  }

  public function setPGPKeyPacket($value) {
    $this->pgpKeyPacket = $value;
  }

  public function getAnies() {
    if ($this->anies === NULL) {
      $this->anies = [];
    }
    return $this->anies;
  }
}

