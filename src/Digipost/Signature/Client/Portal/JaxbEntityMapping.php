<?php

namespace Digipost\Signature\Client\Portal;

use Digipost\Signature\API\XML\XMLPortalSignatureJobRequest;
use Digipost\Signature\Client\Core\Internal\ActualSender;
use Digipost\Signature\Client\Core\Internal\JobStatusResponse;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Core\XAdESReference;

/**
 * Class JaxbEntityMapping
 *
 * @package Digipost\Signature\Client\Portal
 */
final class JaxbEntityMapping {

  static function toJaxb(PortalJob $job, Sender $globalSender = NULL) {
    $actualSender = ActualSender::getActualSender($job->getSender(), $globalSender);

    $xmlPortalJobRequest = new XMLPortalSignatureJobRequest();
    return $xmlPortalJobRequest
      ->withReference($job->getReference())
      ->withPollingQueue($actualSender->getPollingQueue()->value);
  }

  //static function fromJaxb(XMLPortalSignatureJobResponse $xmlPortalSignatureJobResponse) {
  //  return new PortalJobResponse($xmlPortalSignatureJobResponse->getSignatureJobId(), CancellationUrl::of($xmlPortalSignatureJobResponse->getCancellationUrl()));
  //}

  static function fromJaxb(JobStatusResponse $statusChangeResponse) {
    $statusChange = $statusChangeResponse->getStatusResponse();
    $signatures = [];
    foreach ($statusChange->getSignatures()->getSignatures() as $xmlSignature) {
      /** @var \Digipost\Signature\API\XML\XMLSignature $xmlSignature */
      array_push($signatures, new Signature(
        $xmlSignature->getPersonalIdentificationNumber(),
        $xmlSignature->getIdentifier(),
        SignatureStatus::fromXmlType($xmlSignature->getStatus()),
        $xmlSignature->getStatus()->getSince()->toInstant(),
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
      $statusChangeResponse->getNextPermittedPollTime());
  }
}
