<?php

namespace Digipost\Signature\Client\Direct;

use Digipost\Signature\API\XML\XMLDirectSignatureJobRequest;
use Digipost\Signature\API\XML\XMLDirectSignatureJobResponse;
use Digipost\Signature\API\XML\XMLDirectSignatureJobStatusResponse;
use Digipost\Signature\API\XML\XMLExitUrls;
use Digipost\Signature\API\XML\XMLSignerSpecificUrl;
use Digipost\Signature\API\XML\XMLSignerStatus;
use Digipost\Signature\Client\Core\ConfirmationReference;
use Digipost\Signature\Client\Core\DeleteDocumentsUrl;
use Digipost\Signature\Client\Core\Internal\ActualSender;
use Digipost\Signature\Client\Core\PAdESReference;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Core\XAdESReference;

class JaxbEntityMapping {

  static function toJaxb(DirectJob $signatureJob, Sender $globalSender) {
    $actualSender = ActualSender::getActualSender(
      $signatureJob->getSender(),
      $globalSender);

    $jobRequest = new XMLDirectSignatureJobRequest();
    $xmlExitUrls = new XMLExitUrls();

    $statusRetrievalMethod = $signatureJob->getStatusRetrievalMethod();
    if (isset($statusRetrievalMethod)) {
      $jobRequest->setStatusRetrievalMethod($statusRetrievalMethod->getXmlEnumValue());
    }

    return $jobRequest
      ->withReference($signatureJob->getReference())
      ->withExitUrls(
        $xmlExitUrls
          ->withCompletionUrl($signatureJob->getCompletionUrl())
          ->withRejectionUrl($signatureJob->getRejectionUrl())
          ->withErrorUrl($signatureJob->getErrorUrl())
      )
      ->withPollingQueue($actualSender->getPollingQueue()->value);
  }

  static function fromJaxb($xmlObject) {
    if (empty($xmlObject)) {
      throw new \InvalidArgumentException("The response object is empty");
    }

    switch (get_class($xmlObject)) {
      case XMLDirectSignatureJobResponse::class:
        return self::fromJaxb_XMLDirectSignatureJobResponse($xmlObject);
      case XMLDirectSignatureJobStatusResponse::class:
        return self::fromJaxb_XMLDirectSignatureJobStatusResponse($xmlObject);
      default:
        if ($xmlObject instanceof \Exception) {
          throw $xmlObject;
        }
        throw new \InvalidArgumentException(
          "No method to handle fromJaxb for " . get_class($xmlObject));
    }
  }

  static function fromJaxb_XMLDirectSignatureJobResponse(
    XMLDirectSignatureJobResponse $xmlSignatureJobResponse) {
    $redirectUrls =
      array_map([RedirectUrl::class, 'fromJaxb'], $xmlSignatureJobResponse->getRedirectUrl());

    return new DirectJobResponse(
      $xmlSignatureJobResponse->getSignatureJobId(),
      $xmlSignatureJobResponse->getReference(),
      $redirectUrls,
      $xmlSignatureJobResponse->getStatusUrl());
  }

  /**
   * @param XMLDirectSignatureJobStatusResponse $statusResponse
   * @param null                                $nextPermittedPollTime
   *
   * @return DirectJobStatusResponse
   */
  static function fromJaxb_XMLDirectSignatureJobStatusResponse(
    XMLDirectSignatureJobStatusResponse $statusResponse,
    $nextPermittedPollTime = NULL) {
    $signatures = [];
    foreach ($statusResponse->getStatuses() as $signerStatus) {
      /** @var XMLSignerSpecificUrl[] $xAdESUrls */
      /** @var XMLSignerStatus $signerStatus */
      $xAdESUrls = array_filter(
        $statusResponse->getXadesUrls(),
        function ($url) use ($signerStatus) {
          /** @var XMLSignerSpecificUrl $url */
          return $url->getSigner() === $signerStatus->getSigner();
        });
      $xAdESUrl = array_shift($xAdESUrls);
      $xAdESUrl = $xAdESUrl ? $xAdESUrl->getValue() : NULL;

      $signatures[] = new Signature(
        $signerStatus->getSigner(),
        SignerStatus::fromXmlType($signerStatus->getValue()),
        $signerStatus->getSince(),
        XAdESReference::of($xAdESUrl)
      );
    }

    return new DirectJobStatusResponse(
      $statusResponse->getSignatureJobId(),
      DirectJobStatus::fromXmlType($statusResponse->getSignatureJobStatus()),
      ConfirmationReference::of($statusResponse->getConfirmationUrl()),
      DeleteDocumentsUrl::of($statusResponse->getDeleteDocumentsUrl()),
      $signatures,
      PAdESReference::of($statusResponse->getPadesUrls()),
      $nextPermittedPollTime);
  }
}
