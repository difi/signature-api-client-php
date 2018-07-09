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
 * @Serializer\XmlRoot(name="error")
 */
class XMLError {

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $errorCode;

  /**
   * @Serializer\XmlElement(cdata=false)
   */
  protected $errorMessage;

  /**
   * @Serializer\XmlElement(cdata=false)
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