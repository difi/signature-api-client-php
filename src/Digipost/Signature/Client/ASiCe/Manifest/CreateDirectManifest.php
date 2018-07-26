<?php

namespace Digipost\Signature\Client\ASiCe\Manifest;

use Digipost\Signature\API\XML\XMLDirectDocument;
use Digipost\Signature\API\XML\XMLDirectSignatureJobManifest;
use Digipost\Signature\API\XML\XMLDirectSigner;
use Digipost\Signature\API\XML\XMLSender;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Direct\DirectJob;

/**
 * Class CreateDirectManifest
 *
 * @package Digipost\Signature\Client\ASiCe\Manifest
 */
class CreateDirectManifest extends ManifestCreator {

  /**
   * @param DirectJob $job
   * @param Sender    $sender
   *
   * @return string
   */
  function buildXmlManifest($job, Sender $sender) {
    $document = $job->getDocument();

    $signers = [];
    foreach ($job->getSigners() as $signer) {
      $xmlSigner = new XMLDirectSigner();
      $signType = $signer->getSignatureType();
      if ($signType) {
        $xmlSigner->withSignatureType($signType->getXmlEnumValue());
      }
      $onBehalfOf = $signer->getOnBehalfOf();
      if ($onBehalfOf) {
        $xmlSigner->withOnBehalfOf($onBehalfOf->getXmlEnumValue());
      }
      if ($signer->isIdentifiedByPersonalIdentificationNumber()) {
        $xmlSigner->setPersonalIdentificationNumber(
          $signer->getPersonalIdentificationNumber()
        );
      }
      else {
        $xmlSigner->setSignerIdentifier($signer->getCustomIdentifier());
      }
      $signers[] = $xmlSigner;
    }

    $xmlSignatureJobManifest = new XMLDirectSignatureJobManifest();
    $xmlSender = new XMLSender();
    $xmlDirectDocument = new XMLDirectDocument();

    $requiredAuthentication = $job->getRequiredAuthentication();
    if ($requiredAuthentication) {
      $xmlSignatureJobManifest->withRequiredAuthentication(
        $requiredAuthentication->getXmlEnumValue()
      );
    }
    $identifierInSignedDocuments = $job->getIdentifierInSignedDocuments();
    if ($identifierInSignedDocuments) {
      $xmlSignatureJobManifest->withIdentifierInSignedDocuments(
        $identifierInSignedDocuments->getXmlEnumValue()
      );
    }

    return $xmlSignatureJobManifest
      ->withSigners($signers)
      ->withSender(
        $xmlSender->withOrganizationNumber($sender->getOrganizationNumber())
      )
      ->withDocument(
        $xmlDirectDocument
          ->withTitle($document->getTitle())
          ->withDescription($document->getMessage())
          ->withHref($document->getFileName())
          ->withMime($document->getMimeType())
      );
  }
}
