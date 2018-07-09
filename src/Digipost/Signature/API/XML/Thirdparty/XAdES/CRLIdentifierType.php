<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class CRLIdentifierType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="CRLIdentifierType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="Issuer" type="{http://www.w3.org/2001/XMLSchema}string"/>
 *         <element name="IssueTime" type="{http://www.w3.org/2001/XMLSchema}dateTime"/>
 *         <element name="Number" type="{http://www.w3.org/2001/XMLSchema}integer" minOccurs="0"/>
 *       </sequence>
 *       <attribute name="URI" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\AccessorOrder("custom", custom={
 *   "issuer",
 *   "issueTime",
 *   "number"
 * })
 */
class CRLIdentifierType {

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $issuer;

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $issueTime;

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $number;

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("URI")
   */
  protected $uri;

  public function __construct(String $issuer = NULL,
                              \DateTime $issueTime = NULL,
                              int $number = NULL,
                              String $uri = NULL) {
    $this->issuer = $issuer;
    $this->issueTime = $issueTime;
    $this->number = $number;
    $this->uri = $uri;
  }

  public function getIssuer() {
    return $this->issuer;
  }

  public function setIssuer(String $value) {
    $this->issuer = $value;
  }

  public function withIssuer(String $value) {
    $this->setIssuer($value);
    return $this;
  }

  public function getIssueTime() {
    return $this->issueTime;
  }

  public function setIssueTime(\DateTime $value) {
    $this->issueTime = $value;
  }

  public function withIssueTime(\DateTime $value) {
    $this->setIssueTime($value);
    return $this;
  }

  public function getNumber() {
    return $this->number;
  }

  public function setNumber(int $value) {
    $this->number = $value;
  }

  public function withNumber(int $value) {
    $this->setNumber($value);
    return $this;
  }

  public function getURI() {
    return $this->uri;
  }

  public function setURI(String $value) {
    $this->uri = $value;
  }

  public function withURI(String $value) {
    $this->setURI($value);
    return $this;
  }
}

