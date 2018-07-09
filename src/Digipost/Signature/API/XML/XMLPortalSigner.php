<?php

namespace Digipost\Signature\API\XML;

use Digipost\Signature\JAXB\XMLSigner;

class XMLPortalSigner implements XMLSigner {

  protected $identifiedByContactInformation;  // XMLEnabled

  protected $personalIdentificationNumber;  // String

  protected $signatureType;  // XMLSignatureType

  protected $notifications;  // XMLNotifications

  protected $notificationsUsingLookup;  // XMLNotificationsUsingLookup

  protected $onBehalfOf;  // XMLSigningOnBehalfOf

  protected $order;  // Integer

  function __construct(XMLEnabled $identifiedByContactInformation = NULL,
                       String $personalIdentificationNumber = NULL,
                       XMLSignatureType $signatureType = NULL,
                       XMLNotifications $notifications = NULL,
                       XMLNotificationsUsingLookup $notificationsUsingLookup = NULL,
                       XMLSigningOnBehalfOf $onBehalfOf = NULL,
                       int $order = NULL
  ) {
    $this->identifiedByContactInformation = $identifiedByContactInformation;
    $this->personalIdentificationNumber = $personalIdentificationNumber;
    $this->signatureType = $signatureType;
    $this->notifications = $notifications;
    $this->notificationsUsingLookup = $notificationsUsingLookup;
    $this->onBehalfOf = $onBehalfOf;
    $this->order = $order;
  }

  public function getIdentifiedByContactInformation() {
    return $this->identifiedByContactInformation;
  }

  public function setIdentifiedByContactInformation($value) {
    $this->identifiedByContactInformation = $value;
  }

  public function getPersonalIdentificationNumber() {
    return $this->personalIdentificationNumber;
  }

  public function setPersonalIdentificationNumber($value) {
    $this->personalIdentificationNumber = $value;
  }

  public function getSignatureType(): XMLSignatureType {
    return $this->signatureType;
  }

  public function setSignatureType($value) {
    $this->signatureType = $value;
  }

  public function withSignatureType($value) {
    $this->signatureType = $value;
    return $this;
  }

  public function getNotifications() {
    return $this->notifications;
  }

  public function setNotifications($value) {
    $this->notifications = $value;
  }

  public function getNotificationsUsingLookup() {
    return $this->notificationsUsingLookup;
  }

  public function setNotificationsUsingLookup($value) {
    $this->notificationsUsingLookup = $value;
  }
  public function withNotificationsUsingLookup($value) {
    $this->notificationsUsingLookup = $value;
    return $this;
  }

  public function getOnBehalfOf(): XMLSigningOnBehalfOf {
    return $this->onBehalfOf;
  }

  public function setOnBehalfOf($value) {
    $this->onBehalfOf = $value;
  }
  public function withOnBehalfOf($value) {
    $this->onBehalfOf = $value;
    return $this;
  }

  public function getOrder() {
    return $this->order;
  }

  public function setOrder($value) {
    $this->order = $value;
  }

  public function withOrder($value) {
    $this->order = $value;
    return $this;
  }
}

