<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class SignatureProductionPlace
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="SignatureProductionPlaceType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="City" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
 *         <element name="StateOrProvince" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
 *         <element name="PostalCode" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
 *         <element name="CountryName" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\XmlRoot(name="SignatureProductionPlace")
 * @Serializer\AccessorOrder("custom", custom={
 *   "city",
 *   "stateOrProvince",
 *   "postalCode",
 *   "countryName"
 * })
 */
class SignatureProductionPlace {

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $city;

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $stateOrProvince;

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $postalCode;

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $countryName;

  public function __construct(String $city = NULL,
                              String $stateOrProvince = NULL,
                              String $postalCode = NULL,
                              String $countryName = NULL) {
    $this->city = $city;
    $this->stateOrProvince = $stateOrProvince;
    $this->postalCode = $postalCode;
    $this->countryName = $countryName;
    return $this;
  }

  public function getCity() {
    return $this->city;
  }

  public function setCity(String $value) {
    $this->city = $value;
  }

  public function withCity(String $value) {
    $this->setCity($value);
    return $this;
  }

  public function getStateOrProvince() {
    return $this->stateOrProvince;
  }

  public function setStateOrProvince(String $value) {
    $this->stateOrProvince = $value;
  }

  public function withStateOrProvince(String $value) {
    $this->setStateOrProvince($value);
    return $this;
  }

  public function getPostalCode() {
    return $this->postalCode;
  }

  public function setPostalCode(String $value) {
    $this->postalCode = $value;
  }

  public function withPostalCode(String $value) {
    $this->setPostalCode($value);
    return $this;
  }

  public function getCountryName() {
    return $this->countryName;
  }

  public function setCountryName(String $value) {
    $this->countryName = $value;
  }

  public function withCountryName(String $value) {
    $this->setCountryName($value);
    return $this;
  }
}

