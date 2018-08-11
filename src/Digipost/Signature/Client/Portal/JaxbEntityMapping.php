<?php

namespace Digipost\Signature\Client\Portal;

use Digipost\Signature\API\XML\XMLPortalSignatureJobRequest;
use Digipost\Signature\API\XML\XMLPortalSignatureJobResponse;
use Digipost\Signature\API\XML\XMLPortalSignatureJobStatusChangeResponse;
use Digipost\Signature\Client\Core\ConfirmationReference;
use Digipost\Signature\Client\Core\DeleteDocumentsUrl;
use Digipost\Signature\Client\Core\Internal\ActualSender;
use Digipost\Signature\Client\Core\Internal\JobStatusResponse;
use Digipost\Signature\Client\Core\PAdESReference;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Core\XAdESReference;

class JaxbEntityMapping {

  /**
   * @param PortalJob $job
   * @param Sender|NULL $globalSender
   *
   * @return XMLPortalSignatureJobRequest
   */
  static function toJaxb(PortalJob $job, Sender $globalSender = NULL) {
    $actualSender = ActualSender::getActualSender($job->getSender(), $globalSender);

    return new XMLPortalSignatureJobRequest(
      $job->getReference(),
      $actualSender->getPollingQueue()->value
    );
  }

  /**
   * @param JobStatusResponse|XMLPortalSignatureJobResponse $xmlObject
   *
   * @return PortalJobStatusChanged
   */
  static function fromJaxb($xmlObject) {
    if (empty($xmlObject)) {
      throw new \InvalidArgumentException("The response object is empty");
    }
    if ($xmlObject instanceof XMLPortalSignatureJobResponse) {
      $portalJobResponse = self::fromJaxb_XMLPortalSignatureJobResponse($xmlObject);

      return $portalJobResponse;
    }
    if ($xmlObject instanceof XMLPortalSignatureJobStatusChangeResponse) {
      /** @var XMLPortalSignatureJobStatusChangeResponse $statusChange */
      $statusChange = $xmlObject->getStatusResponse();
      $signatures = [];
      foreach ($statusChange->getSignatures() as $xmlSignature) {
        /** @var \Digipost\Signature\API\XML\XMLSignature $xmlSignature */
        array_push(
          $signatures, new Signature(
          $xmlSignature->getPersonalIdentificationNumber(),
          $xmlSignature->getIdentifier(),
          SignatureStatus::fromXmlType($xmlSignature->getStatus()),
          new \DateTime($xmlSignature->getStatus()->getSince()->getTimestamp()),
          XAdESReference::of($xmlSignature->getXadesUrl())
        ));
      }

      return new PortalJobStatusChanged(
        $statusChange->getSignatureJobId(),
        PortalJobStatus::fromXmlType($statusChange->getStatus()),
        ConfirmationReference::of($statusChange->getConfirmationUrl()),
        CancellationUrl::of($statusChange->getCancellationUrl()),
        DeleteDocumentsUrl::of($statusChange->getDeleteDocumentsUrl()),
        PAdESReference::of($statusChange->getSignatures()->getPadesUrl()),
        $signatures,
        $xmlObject->getNextPermittedPollTime());
    }

    /*
    switch (get_class($xmlObject)) {
      case XMLPortalSignatureJobResponse::class:
        return self::fromJaxb_XMLPortalSignatureJobResponse($xmlObject);
      case XMLPortalSignatureJobStatusChangeResponse::class:
        return self::fromJaxb_XMLPortalSignatureJobStatusChangeResponse($xmlObject);
      default:
        if ($xmlObject instanceof \Exception) {
          throw $xmlObject;
        }
        throw new \InvalidArgumentException(
          "No method to handle fromJaxb for " . get_class($xmlObject));

    }
    */
    //    $statusChangeResponse = $xmlObject;

    /** @var JobStatusResponse $statusChangeResponse */
    /** @var XMLPortalSignatureJobStatusChangeResponse $statusChange */
    //

    //
  }

  /**
   * @param XMLPortalSignatureJobResponse $xmlPortalSignatureJobResponse
   *
   * @return PortalJobResponse
   */
  private static function fromJaxb_XMLPortalSignatureJobResponse(
    XMLPortalSignatureJobResponse $xmlPortalSignatureJobResponse) {
    return new PortalJobResponse(
      $xmlPortalSignatureJobResponse->getSignatureJobId(),
      $xmlPortalSignatureJobResponse->getReference(),
      CancellationUrl::of($xmlPortalSignatureJobResponse->getCancellationUrl())
    );
  }
  private static function fromJaxb_XMLPortalSignatureJobStatusChangeResponse(
    XMLPortalSignatureJobStatusChangeResponse $statusChange) {

  }
}
