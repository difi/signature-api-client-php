<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLExitUrls
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="exit-urls">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="completion-url" type="{http://signering.posten.no/schema/v1}url"/>
 *         <element name="rejection-url" type="{http://signering.posten.no/schema/v1}url"/>
 *         <element name="error-url" type="{http://signering.posten.no/schema/v1}url"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML
 *
 * @Serializer\AccessorOrder("custom", custom = {
 *   "completionUrl",
 *   "rejectionUrl",
 *   "errorUrl"
 * })
 */
class XMLExitUrls {

  /**
   * @Serializer\XmlElement()
   */
  protected $completionUrl;

  /**
   * @Serializer\XmlElement()
   */
  protected $rejectionUrl;

  /**
   * @Serializer\XmlElement()
   */
  protected $errorUrl;

  function __construct(String $completionUrl = NULL,
                       String $rejectionUrl = NULL,
                       String $errorUrl = NULL) {
    $this->completionUrl = $completionUrl;
    $this->rejectionUrl = $rejectionUrl;
    $this->errorUrl = $errorUrl;
  }

  public function getCompletionUrl() {
    return $this->completionUrl;
  }

  public function setCompletionUrl($value) {
    $this->completionUrl = $value;
  }

  public function getRejectionUrl() {
    return $this->rejectionUrl;
  }

  public function setRejectionUrl($value) {
    $this->rejectionUrl = $value;
  }

  public function getErrorUrl() {
    return $this->errorUrl;
  }

  public function setErrorUrl($value) {
    $this->errorUrl = $value;
  }

  public function withCompletionUrl($completionUrl) {
    $this->completionUrl = $completionUrl;
    return $this;
  }

  public function withRejectionUrl($rejectionUrl) {
    $this->rejectionUrl = $rejectionUrl;
    return $this;
  }

  public function withErrorUrl($errorUrl) {
    $this->errorUrl = $errorUrl;
    return $this;
  }
  //


}

