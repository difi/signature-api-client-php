<?php
namespace Digipost\Signature\API\XML;

class ObjectFactory {

  public function createXMLError() {
    return new XMLError();
  }

  public function createXMLDirectSignatureJobRequest() {
    return new XMLDirectSignatureJobRequest();
  }

  public function createXMLExitUrls() {
    return new XMLExitUrls();
  }

  public function createXMLDirectSignatureJobManifest() {
    return new XMLDirectSignatureJobManifest();
  }

  public function createXMLDirectSigner() {
    return new XMLDirectSigner();
  }

  public function createXMLSender() {
    return new XMLSender();
  }

  public function createXMLDirectDocument() {
    return new XMLDirectDocument();
  }

  public function createXMLDirectSignatureJobResponse() {
    return new XMLDirectSignatureJobResponse();
  }

  public function createXMLSignerSpecificUrl() {
    return new XMLSignerSpecificUrl();
  }

  public function createXMLDirectSignatureJobStatusResponse() {
    return new XMLDirectSignatureJobStatusResponse();
  }

  public function createXMLSignerStatus() {
    return new XMLSignerStatus();
  }

  public function createXMLPortalSignatureJobRequest() {
    return new XMLPortalSignatureJobRequest();
  }

  public function createXMLPortalSignatureJobManifest() {
    return new XMLPortalSignatureJobManifest();
  }

  public function createXMLPortalDocument() {
    return new XMLPortalDocument();
  }

  public function createXMLAvailability() {
    return new XMLAvailability();
  }

  public function createXMLPortalSignatureJobResponse() {
    return new XMLPortalSignatureJobResponse();
  }

  public function createXMLPortalSignatureJobStatusChangeResponse() {
    return new XMLPortalSignatureJobStatusChangeResponse();
  }

  public function createXMLSignatures() {
    return new XMLSignatures();
  }

  public function createXMLEnabled() {
    return new XMLEnabled();
  }

  public function createXMLNotificationsUsingLookup() {
    return new XMLNotificationsUsingLookup();
  }

  public function createXMLEmail() {
    return new XMLEmail();
  }

  public function createXMLSms() {
    return new XMLSms();
  }

  public function createXMLNotifications() {
    return new XMLNotifications();
  }

  public function createXMLPortalSigner() {
    return new XMLPortalSigner();
  }

  public function createXMLSignature() {
    return new XMLSignature();
  }

  public function createXMLSignatureStatus() {
    return new XMLSignatureStatus();
  }
}


