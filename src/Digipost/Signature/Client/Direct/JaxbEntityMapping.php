<?php

namespace Digipost\Signature\Client\Direct;

//import no.digipost.signature.api.xml.XMLDirectSignatureJobRequest;
//import no.digipost.signature.api.xml.XMLDirectSignatureJobResponse;
//import no.digipost.signature.api.xml.XMLDirectSignatureJobStatusResponse;
//import no.digipost.signature.api.xml.XMLExitUrls;
//import no.digipost.signature.api.xml.XMLSignerSpecificUrl;
//import no.digipost.signature.api.xml.XMLSignerStatus;
//import no.digipost.signature.client.core.ConfirmationReference;
//import no.digipost.signature.client.core.PAdESReference;
//import no.digipost.signature.client.core.Sender;
//import no.digipost.signature.client.core.XAdESReference;
//import no.digipost.signature.client.direct.RedirectUrls.RedirectUrl;
//import no.digipost.signature.client.core.DeleteDocumentsUrl;
//
//import java.time.Instant;
//import java.util.ArrayList;
//import java.util.List;
//import java.util.Optional;
//import java.util.function.Predicate;
//
//import static java.util.stream.Collectors.toList;
//import static no.digipost.signature.client.core.internal.ActualSender.getActualSender;
use Digipost\Signature\API\XML\XMLDirectSignatureJobRequest;
use Digipost\Signature\API\XML\XMLDirectSignatureJobResponse;
use Digipost\Signature\API\XML\XMLExitUrls;
use Digipost\Signature\API\XML\XMLSignerSpecificUrl;
use Digipost\Signature\Client\Core\Internal\ActualSender;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Direct\StatusRetrievalMethod;

class JaxbEntityMapping {

  static function toJaxb(DirectJob $signatureJob, Sender $globalSender) {
    $actualSender = ActualSender::getActualSender($signatureJob->getSender(),
                                                  $globalSender);

    $jobRequest = new XMLDirectSignatureJobRequest();
    $xmlExitUrls = new XMLExitUrls();

    return $jobRequest
      ->withReference($signatureJob->getReference())
      ->withExitUrls(
        $xmlExitUrls
          ->withCompletionUrl($signatureJob->getCompletionUrl())
          ->withRejectionUrl($signatureJob->getRejectionUrl())
          ->withErrorUrl($signatureJob->getErrorUrl())
      )
      ->withStatusRetrievalMethod($signatureJob->getStatusRetrievalMethod() || NULL)
      ->withPollingQueue($actualSender->getPollingQueue()->value);
  }

  static function fromJaxb(XMLDirectSignatureJobResponse $xmlSignatureJobResponse) {
    $redirectUrls = $xmlSignatureJobResponse->getRedirectUrls();
    //  ->map(RedirectUrl::fromJaxb)
    //  ->collect(toList());

    return new DirectJobResponse($xmlSignatureJobResponse->getSignatureJobId(),
                                 $redirectUrls,
                                 $xmlSignatureJobResponse->getStatusUrl());
  }

  /*
  static function fromJaxb(XMLDirectSignatureJobStatusResponse statusResponse, Instant nextPermittedPollTime) {
      List<Signature> signatures = new ArrayList<>();
      for (XMLSignerStatus signerStatus : statusResponse.getStatuses()) {
          String xAdESUrl = statusResponse.getXadesUrls().stream()
                  .filter(forSigner(signerStatus.getSigner()))
                  .findFirst()
                  .map(XMLSignerSpecificUrl::getValue)
                  .orElse(null);

          signatures.add(new Signature(
                  signerStatus.getSigner(),
                  SignerStatus.fromXmlType(signerStatus.getValue()),
                  signerStatus.getSince().toInstant(),
                  XAdESReference.of(xAdESUrl)
          ));
      }

      return new DirectJobStatusResponse(
              statusResponse.getSignatureJobId(),
              DirectJobStatus.fromXmlType(statusResponse.getSignatureJobStatus()),
              ConfirmationReference.of(statusResponse.getConfirmationUrl()),
              DeleteDocumentsUrl.of(statusResponse.getDeleteDocumentsUrl()),
              signatures,
              PAdESReference.of(statusResponse.getPadesUrl()),
              nextPermittedPollTime);
  }
  */

  private static function forSigner(String $signer) {
    //return url -> url.getSigner().equals(signer);

    return TRUE;
  }
}
