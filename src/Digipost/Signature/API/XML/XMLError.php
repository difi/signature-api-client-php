<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLError
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType>
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="error-code" type="{http://www.w3.org/2001/XMLSchema}string"/>
 *         <element name="error-message" type="{http://www.w3.org/2001/XMLSchema}string"/>
 *         <element name="error-type" type="{http://www.w3.org/2001/XMLSchema}string"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML
 *
 * @Serializer\AccessorOrder("custom", custom={
 *   "errorCode",
 *   "errorMessage",
 *   "errorType"
 * })
 * @Serializer\XmlRoot(name="ns4:error")
 * @Serializer\XmlNamespace(uri="http://uri.etsi.org/01903/v1.3.2#")
 * @Serializer\XmlNamespace(uri="http://signering.posten.no/schema/v1", prefix="ns4")
 * @Serializer\XmlNamespace(uri="http://uri.etsi.org/2918/v1.2.1#", prefix="ns3")
 * @Serializer\XmlNamespace(uri="http://www.w3.org/2000/09/xmldsig#", prefix="ns2")
 */
class XMLError {

  /**
   * @Serializer\XmlElement(namespace="http://signering.posten.no/schema/v1")
   * @Serializer\Type("string")
   * @Serializer\SerializedName("error-code")
   */
  protected $errorCode;

  /**
   * @Serializer\XmlElement(namespace="http://signering.posten.no/schema/v1")
   * @Serializer\Type("string")
   * @Serializer\SerializedName("error-message")
   */
  protected $errorMessage;

  /**
   * @Serializer\XmlElement(namespace="http://signering.posten.no/schema/v1")
   * @Serializer\Type("string")
   * @Serializer\SerializedName("error-type")
   */
  protected $errorType;

  public function __construct(String $errorCode = NULL,
                              String $errorMessage = NULL,
                              String $errorType = NULL) {
    $this->errorCode = $errorCode;
    $this->errorMessage = $errorMessage;
    $this->errorType = $errorType;
    return $this;
  }

  public function getErrorCode() {
    return $this->errorCode;
  }

  public function setErrorCode($value) {
    $this->errorCode = $value;
  }

  public function getErrorMessage() {
    return $this->errorMessage;
  }

  public function setErrorMessage($value) {
    $this->errorMessage = $value;
  }

  public function getErrorType() {
    return $this->errorType;
  }

  public function setErrorType($value) {
    $this->errorType = $value;
  }
}