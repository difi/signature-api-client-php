<?php

namespace Digipost\Signature\API\XML;

use Digipost\Signature\JAXB\XMLManifest;
use Digipost\Signature\JAXB\XMLDocument;

class XMLPortalSignatureJobManifest implements XMLManifest {

  /**
   * @var array
   */
  protected $signers;

  /**
   * @var XMLSender
   */
  protected $sender;

  /**
   * @var XMLPortalDocument
   */
  protected $document;

  /**
   * @var XMLAuthenticationLevel
   */
  protected $requiredAuthentication;

  /**
   * @var XMLAvailability
   */
  protected $availability;

  /**
   * @var XMLIdentifierInSignedDocuments
   */
  protected $identifierInSignedDocuments;

  function __construct(array $signers = NULL,
                       XMLSender $sender = NULL,
                       XMLPortalDocument $document = NULL,
                       XMLAuthenticationLevel $requiredAuthentication = NULL,
                       XMLAvailability $availability = NULL,
                       XMLIdentifierInSignedDocuments $identifierInSignedDocuments = NULL
  ) {
    $this->signers = $signers;
    $this->sender = $sender;
    $this->document = $document;
    $this->requiredAuthentication = $requiredAuthentication;
    $this->availability = $availability;
    $this->identifierInSignedDocuments = $identifierInSignedDocuments;
  }

  public function getSender() {
    return $this->sender;
  }

  public function setSender($value) {
    $this->sender = $value;
  }

  public function withSender($value) {
    $this->sender = $value;
    return $this;
  }

  public function getDocument(): XMLDocument {
    return $this->document;
  }

  public function setDocument($value) {
    $this->document = $value;
  }

  public function withDocument($value) {
    $this->document = $value;
    return $this;
  }

  public function getRequiredAuthentication() {
    return $this->requiredAuthentication;
  }

  public function setRequiredAuthentication($value) {
    $this->requiredAuthentication = $value;
  }

  public function withRequiredAuthentication($value) {
    $this->requiredAuthentication = $value;
    return $this;
  }

  public function getAvailability() {
    return $this->availability;
  }

  public function setAvailability($value) {
    $this->availability = $value;
  }

  public function withAvailability($value) {
    $this->availability = $value;
    return $this;
  }

  public function getIdentifierInSignedDocuments() {
    return $this->identifierInSignedDocuments;
  }

  public function setIdentifierInSignedDocuments($value) {
    $this->identifierInSignedDocuments = $value;
  }

  public function withIdentifierInSignedDocuments($value) {
    $this->identifierInSignedDocuments = $value;
    return $this;
  }

  public function getSigners() {
    if ($this->signers === NULL) {
      $this->signers = [];
    }
    return $this->signers;
  }

  public function setSigners($signers) {
    $this->signers = $signers;
  }

  public function withSigners($signers) {
    $this->signers = $signers;
    return $this;
  }
}

