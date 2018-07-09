<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class OCSPIdentifierType
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="OCSPIdentifierType">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="ResponderID" type="{http://uri.etsi.org/01903/v1.3.2#}ResponderIDType"/>
 *         <element name="ProducedAt" type="{http://www.w3.org/2001/XMLSchema}dateTime"/>
 *       </sequence>
 *       <attribute name="URI" type="{http://www.w3.org/2001/XMLSchema}anyURI" />
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML\Thirdparty\XAdES
 *
 * @Serializer\AccessorOrder("custom", custom={"responderID","producedAt"})
 */
class OCSPIdentifierType {

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("Digipost\Signature\API\XML\Thirdparty\XAdES\ResponderIDType")
   */
  protected $responderID;

  /**
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("DateTime")
   */
  protected $producedAt;

  /**
   * @Serializer\XmlAttribute()
   * @Serializer\SerializedName("URI")
   */
  protected $uri;

  public function __construct(ResponderIDType $responderID = NULL,
                              \DateTime $producedAt = NULL,
                              String $uri = NULL) {
    $this->responderID = $responderID;
    $this->producedAt = $producedAt;
    $this->uri = $uri;
    return $this;
  }

  public function getResponderID() {
    return $this->responderID;
  }

  public function setResponderID(ResponderIDType $value) {
    $this->responderID = $value;
  }

  public function withResponderID(ResponderIDType $value) {
    $this->setProducedAt($value);
    return $this;
  }

  public function getProducedAt() {
    return $this->producedAt;
  }

  public function setProducedAt(\DateTime $value) {
    $this->producedAt = $value;
  }

  public function withProducedAt(\DateTime $value) {
    $this->setProducedAt($value);
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

