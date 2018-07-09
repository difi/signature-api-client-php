<?php

namespace Digipost\Signature\Client\Direct;

use Digipost\Signature\API\XML\XMLDirectSignatureJobRequest;
use Digipost\Signature\Client\ASiCe\CreateASiCE;
use Digipost\Signature\Client\ASiCe\Manifest\CreateDirectManifest;
use Digipost\Signature\Client\ClientConfiguration;
use Digipost\Signature\Client\Core\DeleteDocumentsUrl;
use Digipost\Signature\Client\Core\Internal\ClientHelper;
use Digipost\Signature\Client\Core\Internal\Http\SignatureHttpClientFactory;
use Digipost\Signature\Client\Core\PAdESReference;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Core\XAdESReference;

/**
 * Class DirectClient
 *
 * @package Digipost\Signature\Client\Direct
 */
class DirectClient {

  private $client;

  private $aSiCECreator;

  private $clientConfiguration;

  public function __construct(ClientConfiguration $config) {
    $this->clientConfiguration = $config;
    $this->client = new ClientHelper(SignatureHttpClientFactory::create($config),
                                     $config->getGlobalSender());
    $this->aSiCECreator = new CreateASiCE(new CreateDirectManifest(), $config);
  }

  public function create(DirectJob $job) {
    $documentBundle = $this->aSiCECreator->createASiCE($job);
    /** @var XMLDirectSignatureJobRequest $signatureJobRequest */
    $signatureJobRequest = JaxbEntityMapping::toJaxb($job,
                                         $this->clientConfiguration->getGlobalSender());
    $xmlSignatureJobResponse = $this->client->sendSignatureJobRequest($signatureJobRequest,
                                                                      $documentBundle,
                                                                      $job->getSender());
    return JaxbEntityMapping::fromJaxb($xmlSignatureJobResponse);
  }


  /**
   * Get the current status for the given {@link StatusReference}, which references the status for a specific job.
   * When processing of the status is complete (e.g. retrieving {@link #getPAdES(PAdESReference) PAdES} and/or
   * {@link #getXAdES(XAdESReference) XAdES} documents for a {@link DirectJobStatus#COMPLETED_SUCCESSFULLY completed} job
   * where all signers have {@link SignerStatus#SIGNED signed} their documents),
   * the returned status must be {@link #confirm(DirectJobStatusResponse) confirmed}.
   *
   * @param StatusReference statusReference the reference to the status of a specific job.
   *
   * @return DirectJobResponse the {@link DirectJobStatusResponse} for the job referenced by the given {@link StatusReference},
   *         never {@code null}.
   */
  public function getStatus(StatusReference $statusReference) {
    $xmlSignatureJobStatusResponse = $this->client->sendSignatureJobStatusRequest($statusReference->getStatusUrl());
    return JaxbEntityMapping::fromJaxb($xmlSignatureJobStatusResponse, NULL);
  }

  /**
   * If there is a job with an updated {@link DirectJobStatus status}, the returned object contains
   * necessary information to act on the status change. The returned object can be queried using
   * {@link DirectJobStatusResponse#is(DirectJobStatus) .is(}{@link DirectJobStatus#NO_CHANGES NO_CHANGES)}
   * to determine if there has been a status change. When processing of the status change is complete, (e.g. retrieving
   * {@link #getPAdES(PAdESReference) PAdES} and/or {@link #getXAdES(XAdESReference) XAdES} documents for a
   * {@link DirectJobStatus#COMPLETED_SUCCESSFULLY completed} job where all signers have {@link SignerStatus#SIGNED signed} their documents,
   * the returned status must be {@link #confirm(DirectJobStatusResponse) confirmed}.
   * <p>
   * Only jobs with {@link DirectJob.Builder#retrieveStatusBy(StatusRetrievalMethod) status retrieval method} set
   * to {@link StatusRetrievalMethod#POLLING POLLING} will be returned.
   *
   * @return the changed status for a job, or an instance indicating {@link DirectJobStatus#NO_CHANGES no changes},
   *         never {@code null}.
   */
  public function getStatusChange(Sender $sender) {
    $statusChangeResponse = $this->client->getDirectStatusChange($sender);
    if ($statusChangeResponse->gotStatusChange()) {
      return JaxbEntityMapping::fromJaxb($statusChangeResponse->getStatusResponse(),
                             $statusChangeResponse->getNextPermittedPollTime());
    }
    else {
      return $this->noUpdatedStatus($statusChangeResponse->getNextPermittedPollTime());
    }
  }

  /**
   * Confirms that the status retrieved from {@link #getStatus(StatusReference)} or {@link #getStatusChange()} is received.
   * If the confirmed {@link DirectJobStatus} is a terminal status
   * (i.e. {@link DirectJobStatus#COMPLETED_SUCCESSFULLY completed} or {@link DirectJobStatus#FAILED failed}),
   * the Signature service may make the job's associated resources unavailable through the API when
   * receiving the confirmation. Calling this method for a response with no {@link ConfirmationReference}
   * has no effect.
   * <p>
   * If the status is retrieved using {@link #getStatusChange() the polling method}, failing to confirm the
   * received response may cause subsequent statuses for the same job to be reported as "changed", even
   * though the status has not changed.
   *
   * @param receivedStatusResponse the updated status retrieved from {@link #getStatus(StatusReference)}.
   */
  public function confirm(DirectJobStatusResponse $receivedStatusResponse) {
    $this->client->confirm($receivedStatusResponse);
  }

  public function getXAdES(XAdESReference $xAdESReference) {
    return $this->client->getSignedDocumentStream($xAdESReference->getxAdESUrl());
  }

  public function getPAdES(PAdESReference $pAdESReference) {
    return $this->client->getSignedDocumentStream($pAdESReference->getpAdESUrl());
  }

  public function deleteDocuments(DeleteDocumentsUrl $deleteDocumentsUrl) {
    $this->client->deleteDocuments($deleteDocumentsUrl);
  }

}
