<?php

namespace Digipost\Signature\API\XML;

class XMLPortalSignatureJobStatusChangeResponse {

  protected $signatureJobId;  // long

  protected $status;  // XMLPortalSignatureJobStatus

  protected $confirmationUrl;  // String

  protected $cancellationUrl;  // String

  protected $deleteDocumentsUrl;  // String

  protected $signatures;  // XMLSignatures

  function __construct(int $signatureJobId = NULL,
                       XMLPortalSignatureJobStatus $status = NULL,
                       String $confirmationUrl = NULL,
                       String $cancellationUrl = NULL,
                       String $deleteDocumentsUrl = NULL,
                       XMLSignatures $signatures = NULL) {
    $this->signatureJobId = $signatureJobId;
    $this->status = $status;
    $this->confirmationUrl = $confirmationUrl;
    $this->cancellationUrl = $cancellationUrl;
    $this->deleteDocumentsUrl = $deleteDocumentsUrl;
    $this->signatures = $signatures;
  }

  public function getSignatureJobId() {
    return $this->signatureJobId;
  }

  public function setSignatureJobId($value) {
    $this->signatureJobId = $value;
  }

  public function getStatus() {
    return $this->status;
  }

  public function setStatus($value) {
    $this->status = $value;
  }

  public function getConfirmationUrl() {
    return $this->confirmationUrl;
  }

  public function setConfirmationUrl($value) {
    $this->confirmationUrl = $value;
  }

  public function getCancellationUrl() {
    return $this->cancellationUrl;
  }

  public function setCancellationUrl($value) {
    $this->cancellationUrl = $value;
  }

  public function getDeleteDocumentsUrl() {
    return $this->deleteDocumentsUrl;
  }

  public function setDeleteDocumentsUrl($value) {
    $this->deleteDocumentsUrl = $value;
  }

  public function getSignatures() {
    return $this->signatures;
  }

  public function setSignatures($value) {
    $this->signatures = $value;
  }
}

