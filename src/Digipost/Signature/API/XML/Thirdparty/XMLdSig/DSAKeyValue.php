<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class DSAKeyValue
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="DSAKeyValueType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <sequence minOccurs="0">
 *           <element name="P" type="{http://www.w3.org/2000/09/xmldsig#}CryptoBinary"/>
 *           <element name="Q" type="{http://www.w3.org/2000/09/xmldsig#}CryptoBinary"/>
 *         </sequence>
 *         <element name="G" type="{http://www.w3.org/2000/09/xmldsig#}CryptoBinary" minOccurs="0"/>
 *         <element name="Y" type="{http://www.w3.org/2000/09/xmldsig#}CryptoBinary"/>
 *         <element name="J" type="{http://www.w3.org/2000/09/xmldsig#}CryptoBinary" minOccurs="0"/>
 *         <sequence minOccurs="0">
 *           <element name="Seed" type="{http://www.w3.org/2000/09/xmldsig#}CryptoBinary"/>
 *           <element name="PgenCounter" type="{http://www.w3.org/2000/09/xmldsig#}CryptoBinary"/>
 *         </sequence>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XMLdSig
 *
 * @Serializer\XmlRoot(name="DSAKeyValue")
 * @Serializer\AccessorOrder("custom", custom={
 *   "p",
 *   "q",
 *   "g",
 *   "y",
 *   "j",
 *   "seed",
 *   "pgenCounter"
 * })
 */
class DSAKeyValue extends KeyValueType {

  /**
   * @var String
   * @Serializer\XmlElement()
   */
  protected $p;

  /**
   * @var String
   * @Serializer\XmlElement()
   */
  protected $q;

  /**
   * @var String
   * @Serializer\XmlElement()
   */
  protected $g;

  /**
   * @var String
   * @Serializer\XmlElement()
   */
  protected $y;

  /**
   * @var String
   * @Serializer\XmlElement()
   */
  protected $j;

  /**
   * @var String
   * @Serializer\XmlElement()
   */
  protected $seed;

  /**
   * @var null String
   * @Serializer\XmlElement()
   */
  protected $pgenCounter;

  public function __construct($p = NULL, $q = NULL, $g = NULL, $y = NULL,
                              $j = NULL, $seed = NULL, $pgenCounter = NULL) {
    $this->p = $p;
    $this->q = $q;
    $this->g = $g;
    $this->y = $y;
    $this->j = $j;
    $this->seed = $seed;
    $this->pgenCounter = $pgenCounter;
  }

  public function getP() {
    return $this->p;
  }

  public function setP($value) {
    $this->p = $value;
  }

  public function getQ() {
    return $this->q;
  }

  public function setQ($value) {
    $this->q = $value;
  }

  public function getG() {
    return $this->g;
  }

  public function setG($value) {
    $this->g = $value;
  }

  public function getY() {
    return $this->y;
  }

  public function setY($value) {
    $this->y = $value;
  }

  public function getJ() {
    return $this->j;
  }

  public function setJ($value) {
    $this->j = $value;
  }

  public function getSeed() {
    return $this->seed;
  }

  public function setSeed($value) {
    $this->seed = $value;
  }

  public function getPgenCounter() {
    return $this->pgenCounter;
  }

  public function setPgenCounter($value) {
    $this->pgenCounter = $value;
  }
}

