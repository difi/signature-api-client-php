<?php

namespace Digipost\Signature\API\XML;

/**
 * Class XMLDirectSignatureJobResponse
 *
 * <p>The following schema fragment specifies the expected content contained
 * within this class.
 *
 * ```
 * <complexType>
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="signature-job-id" type="{http://signering.posten.no/schema/v1}signature-job-id"/>
 *         <element name="redirect-url" type="{http://signering.posten.no/schema/v1}signer-specific-url" maxOccurs="10"/>
 *         <element name="status-url" type="{http://signering.posten.no/schema/v1}url" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * ```
 *
 * @package Digipost\Signature\API\XML
 *
 */
class XMLDirectSignatureJobResponse {

  /** @var int */
  protected $signatureJobId;

  /** @var String */
  private $reference;

  /** @var XMLSignerSpecificUrl[] */
  protected $redirectUrl;

  /** @var String */
  protected $statusUrl;

  function __construct(int $signatureJobId = NULL,
                       String $reference = NULL,
                       array $redirectUrl = NULL,
                       String $statusUrl = NULL) {
    $this->signatureJobId = $signatureJobId;
    $this->reference = $reference;
    $this->redirectUrl = $redirectUrl;
    $this->statusUrl = $statusUrl;
  }

  public function getSignatureJobId() {
    return $this->signatureJobId;
  }

  public function setSignatureJobId($value) {
    $this->signatureJobId = $value;
  }

  /**
   * @return XMLSignerSpecificUrl[]|null
   */
  public function getRedirectUrl() {
    if (($this->redirectUrl === NULL)) {
      $this->redirectUrl = [];
    }
    return $this->redirectUrl;
  }

  public function setRedirectUrl(array $redirectUrl) {
    $this->redirectUrl = $redirectUrl;
  }

  public function getStatusUrl() {
    return $this->statusUrl;
  }

  public function setStatusUrl($value) {
    $this->statusUrl = $value;
  }

  public function getReference() {
    return $this->reference;
  }

  public function setReference(String $reference) {
    $this->reference = $reference;
  }

}

