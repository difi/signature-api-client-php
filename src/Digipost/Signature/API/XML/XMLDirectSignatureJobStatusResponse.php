<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLDirectSignatureJobStatusResponse
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType>
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="reference" type="{http://signering.posten.no/schema/v1}signature-job-reference" minOccurs="0" maxOccurs="1"/>
 *         <element name="signature-job-id" type="{http://signering.posten.no/schema/v1}signature-job-id"/>
 *         <element name="signature-job-status" type="{http://signering.posten.no/schema/v1}direct-signature-job-status"/>
 *         <element name="status" type="{http://signering.posten.no/schema/v1}signer-status" maxOccurs="10"/>
 *         <element name="confirmation-url" type="{http://signering.posten.no/schema/v1}url" minOccurs="0"/>
 *         <element name="delete-documents-url" type="{http://signering.posten.no/schema/v1}url" minOccurs="0"/>
 *         <element name="xades-url" type="{http://signering.posten.no/schema/v1}signer-specific-url" maxOccurs="10" minOccurs="0"/>
 *         <element name="pades-url" type="{http://signering.posten.no/schema/v1}url" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML
 *
 * @Serializer\XmlRoot(name="direct-signature-job-status-response")
 * @Serializer\AccessorOrder("custom", custom={
 *   "reference",
 *   "signatureJobId",
 *   "signatureJobStatus",
 *   "statuses",
 *   "confirmationUrl",
 *   "deleteDocumentsUrl",
 *   "xadesUrls",
 *   "padesUrl"
 * })
 */
class XMLDirectSignatureJobStatusResponse {

  protected $reference;

  /**
   * @Serializer\Type("string")
   */
  protected $signatureJobId;

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\XMLDirectSignatureJobStatus")
   */
  protected $signatureJobStatus;

  /**
   * @Serializer\XmlList(entry="status", inline=true)
   * @Serializer\Type("array<Digipost\Signature\API\XML\XMLSignerStatus>")
   */
  protected $statuses;

  /**
   * @Serializer\Type("string")
   */
  protected $confirmationUrl;

  /**
   * @Serializer\Type("string")
   */
  protected $deleteDocumentsUrl;

  /**
   * @Serializer\Type("array<Digipost\Signature\API\XML\XMLSignerSpecificUrl>")
   */
  protected $xadesUrls;

  /**
   * @Serializer\Type("string")
   */
  protected $padesUrls;

  function __construct(int $signatureJobId = NULL,
                       XMLDirectSignatureJobStatus $signatureJobStatus = NULL,
                       array $statuses = NULL,
                       String $confirmationUrl = NULL,
                       String $deleteDocumentsUrl = NULL,
                       array $xadesUrls = NULL,
                       String $padesUrl = NULL) {
    $this->signatureJobId = $signatureJobId;
    $this->signatureJobStatus = $signatureJobStatus;
    $this->statuses = $statuses;
    $this->confirmationUrl = $confirmationUrl;
    $this->deleteDocumentsUrl = $deleteDocumentsUrl;
    $this->xadesUrls = $xadesUrls;
    $this->padesUrl = $padesUrl;
  }

  public function getSignatureJobId() {
    return $this->signatureJobId;
  }

  public function setSignatureJobId($value) {
    $this->signatureJobId = $value;
  }

  public function getSignatureJobStatus() {
    return $this->signatureJobStatus;
  }

  public function setSignatureJobStatus($value) {
    $this->signatureJobStatus = $value;
  }

  /**
   * @return XMLSignerStatus[]|NULL
   */
  public function getStatuses() {
    if ($this->statuses === NULL) {
      $this->statuses = [];
    }
    return $this->statuses;
  }

  /**
   * @param XMLSignerStatus[] $statuses
   */
  public function setStatuses($statuses) {
    $this->statuses = $statuses;
  }

  public function getConfirmationUrl() {
    return $this->confirmationUrl;
  }

  public function setConfirmationUrl($value) {
    $this->confirmationUrl = $value;
  }

  public function getDeleteDocumentsUrl() {
    return $this->deleteDocumentsUrl;
  }

  public function setDeleteDocumentsUrl($value) {
    $this->deleteDocumentsUrl = $value;
  }

  public function getXadesUrls() {
    if ($this->xadesUrls === NULL) {
      $this->xadesUrls = [];
    }
    return $this->xadesUrls;
  }
  /**
   * @return mixed
   */
  public function getReference() {
    return $this->reference;
  }
  /**
   * @param mixed $reference
   */
  public function setReference($reference) {
    $this->reference = $reference;
  }
  /**
   * @param XMLSignerSpecificUrl[] $xadesUrls
   */
  public function setXadesUrls($xadesUrls) {
    $this->xadesUrls = $xadesUrls;
  }
  /**
   * @return mixed
   */
  public function getPadesUrls() {
    if ($this->padesUrls === NULL) {

    }
    return $this->padesUrls;
  }
  /**
   * @param mixed $padesUrls
   */
  public function setPadesUrls($padesUrls) {
    $this->padesUrls = $padesUrls;
  }
}

