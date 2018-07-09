<?php

namespace Digipost\Signature\Client\ASiCe\Manifest;

use Digipost\Signature\API\XML\XMLAvailability;
use Digipost\Signature\API\XML\XMLEmail;
use Digipost\Signature\API\XML\XMLEnabled;
use Digipost\Signature\API\XML\XMLNotifications;
use Digipost\Signature\API\XML\XMLNotificationsUsingLookup;
use Digipost\Signature\API\XML\XMLPortalDocument;
use Digipost\Signature\API\XML\XMLPortalSignatureJobManifest;
use Digipost\Signature\API\XML\XMLPortalSigner;
use Digipost\Signature\API\XML\XMLSender;
use Digipost\Signature\API\XML\XMLSms;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Portal\Notifications;
use Digipost\Signature\Client\Portal\NotificationsUsingLookup;
use Digipost\Signature\Client\Portal\PortalJob;
use Digipost\Signature\Client\Portal\PortalSigner;

/**
 * Class CreatePortalManifest
 *
 * @package Digipost\Signature\Client\ASiCe\Manifest
 */
class CreatePortalManifest extends ManifestCreator {

  private $clock;

  public function __construct(\DateTime $clock) {
    $this->clock = $clock;
  }

  /**
   * @param PortalJob $job
   * @param Sender    $sender
   *
   * @return XMLPortalSignatureJobManifest
   */
  function buildXmlManifest($job, Sender $sender) {
    $xmlSigners = [];
    foreach ($job->getSigners() as $signer) {
      /** @var PortalSigner $signer */
      $xmlPortalSigner = $this->generateSigner($signer);

      if ($signer->getNotifications() !== NULL) {
        $xmlPortalSigner->setNotifications($this->generateNotifications($signer->getNotifications()));
      }
      else {
        if ($signer->getNotificationsUsingLookup() !== NULL) {
          $xmlPortalSigner->setNotificationsUsingLookup($this->generateNotificationsUsingLookup($signer->getNotificationsUsingLookup()));
        }
      }
      array_push($xmlSigners, $xmlPortalSigner);
    }

    $document = $job->getDocument();

    //$activationTime = $job->getActivationTime().map($activation -> $activation.atZone(clock.getZone())).orElse(null);
    $activationTime = NULL; // TODO

    $xmlPortalSignerJobManifest = new XMLPortalSignatureJobManifest();
    $sender = new XMLSender();
    $xmlPortalDocument = new XMLPortalDocument();
    $xmlAvailability = new XMLAvailability();
    return $xmlPortalSignerJobManifest
      ->withSigners($xmlSigners)
      ->withRequiredAuthentication($job->getRequiredAuthentication()
                                     ->getXmlEnumValue() || NULL)
      ->withSender($sender->withOrganizationNumber($sender->getOrganizationNumber())
      )
      ->withDocument($xmlPortalDocument
                       ->withTitle($document->getTitle())
                       ->withNonsensitiveTitle($document->getNonsensitiveTitle())
                       ->withDescription($document->getMessage())
                       ->withHref($document->getFileName())
                       ->withMime($document->getMimeType())
      )
      ->withAvailability($xmlAvailability
                           ->withActivationTime($activationTime)
                           ->withAvailableSeconds($job->getAvailableSeconds())
      )
      ->withIdentifierInSignedDocuments($job->getIdentifierInSignedDocuments()
                                          ->getXmlEnumValue() || NULL);
  }

  private function generateSigner(PortalSigner $signer) {

    $xmlSigner = new XMLPortalSigner();
    $xmlSigner
      ->withOrder($signer->getOrder())
      ->withSignatureType($signer->getSignatureType()
                            ->getXmlEnumValue() || NULL)
      ->withOnBehalfOf($signer->getOnBehalfOf()->getXmlEnumValue() || NULL);

    if ($signer->isIdentifiedByPersonalIdentificationNumber()) {

      $xmlSigner->setPersonalIdentificationNumber($signer->getIdentifier() /* TODO .orElseThrow(SIGNER_NOT_SPECIFIED) */);
    }

    else {
      $xmlSigner->setIdentifiedByContactInformation(new XMLEnabled());
    }
    return $xmlSigner;
  }

  private function generateNotificationsUsingLookup(NotificationsUsingLookup $notificationsUsingLookup) {
    $xmlNotificationsUsingLookup = new XMLNotificationsUsingLookup();
    if ($notificationsUsingLookup->shouldSendEmail) {
      $xmlNotificationsUsingLookup->setEmail(new XMLEnabled());
    }
    if ($notificationsUsingLookup->shouldSendSms) {
      $xmlNotificationsUsingLookup->setSms(new XMLEnabled());
    }
    return $xmlNotificationsUsingLookup;
  }

  private function generateNotifications(Notifications $notifications) {
    $xmlNotifications = new XMLNotifications();
    if ($notifications->shouldSendEmail()) {
      $xmlNotifications->setEmail(new XMLEmail($notifications->getEmailAddress()));
    }
    if ($notifications->shouldSendSms()) {
      $xmlNotifications->setSms(new XMLSms($notifications->getMobileNumber()));
    }
    return $xmlNotifications;
  }
}
