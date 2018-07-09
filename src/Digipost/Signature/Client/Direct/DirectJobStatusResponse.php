<?php

namespace Digipost\Signature\Client\Direct;

use Digipost\Signature\Client\Core\ConfirmationReference;
use Digipost\Signature\Client\Core\DeleteDocumentsUrl;
use Digipost\Signature\Client\Core\Internal\Confirmable;
use Digipost\Signature\Client\Core\PAdESReference;

class DirectJobStatusResponse implements Confirmable {

  /**
   * This instance indicates that there has been no status updates since the last poll request for
   * {@link DirectJobStatusResponse}. Its status is {@link DirectJobStatus#NO_CHANGES NO_CHANGES}.
   *
   * @param \DateTime $nextPermittedPollTime
   *
   * @return \Digipost\Signature\Client\Direct\DirectJobStatusResponse
   */
  static function noUpdatedStatus(\DateTime $nextPermittedPollTime) {
    return new DirectJobStatusResponse(NULL, DirectJobStatus::NO_CHANGES(),
                                       NULL, NULL, NULL, NULL,
                                       $nextPermittedPollTime);
    //      {
    //            public function getSignatureJobId() {
    //                throw new IllegalStateException(
    //                        "There were " . this . ", and querying the job ID is a programming error. " +
    //                        "Use the method is(" . DirectJobStatusResponse.class.getSimpleName() . "." . NO_CHANGES.name() . ") " +
    //                        "to check if there were any status change before attempting to get any further information.");
    //            }
    //
    //            public function toString() {
    //                return "no direct jobs with updated status";
    //            }
    //        };
  }

  private $signatureJobId;

  private $status;

  private $confirmationReference;

  private $deleteDocumentsUrl;

  private $signatures;

  private $pAdESReference;

  private $nextPermittedPollTime;

  public function __construct(int $signatureJobId,
                              DirectJobStatus $signatureJobStatus,
                              ConfirmationReference $confirmationUrl,
                              DeleteDocumentsUrl $deleteDocumentsUrl,
                              array $signatures,
                              PAdESReference $pAdESReference,
                              \DateTime $nextPermittedPollTime) {
    $this->signatureJobId = $signatureJobId;
    $this->status = $signatureJobStatus;
    $this->confirmationReference = $confirmationUrl;
    $this->deleteDocumentsUrl = $deleteDocumentsUrl;
    $this->signatures = $signatures;
    $this->pAdESReference = $pAdESReference;
    $this->nextPermittedPollTime = $nextPermittedPollTime;
  }

  public function getSignatureJobId() {
    return $this->signatureJobId;
  }

  public function getStatus() {
    return $this->status;
  }

  public function is(DirectJobStatus $status) {
    return $this->status === $status;
  }

  public function isPAdESAvailable() {
    return $this->pAdESReference !== NULL;
  }

  public function getpAdESUrl() {
    return $this->pAdESReference;
  }

  public function getSignatures() {
    return $this->signatures;
  }

  /**
   * Gets the signature from a given signer.
   *
   * @param Strig signer a string referring to a signer of the job. It may be a personal identification number or
   *               a custom signer reference, depending of how the {@link DirectSigner signer} was initially created
   *               (using {@link DirectSigner#withPersonalIdentificationNumber(String)} or
   *               {@link DirectSigner#withCustomIdentifier(String)}).
   *
   * @throws IllegalArgumentException if the job response doesn't contain a signature from this signer
   * @see #getSignatures()
   */
  public function getSignatureFrom(String $signer) {
    //        return $this->signatures.stream()
    //                .filter(signatureFrom(signer))
    //                .findFirst()
    //                .orElseThrow(() -> new IllegalArgumentException("Unable to find signature from this signer"));
  }

  /**
   * Gets the point in time where you are allowed to {@link DirectClient#getStatusChange() get status changes}.
   * <p>
   * Only applicable for jobs with {@link DirectJob.Builder#retrieveStatusBy(StatusRetrievalMethod) status retrieval method}
   * set to {@link StatusRetrievalMethod#POLLING POLLING}.
   *
   * @throws IllegalStateException for jobs with {@link DirectJob.Builder#retrieveStatusBy(StatusRetrievalMethod) status retrieval method}
   * <b>not</b> set to {@link StatusRetrievalMethod#POLLING POLLING}.
   */
  public function getNextPermittedPollTime() {
    if ($this->nextPermittedPollTime === NULL) {
      throw new IllegalStateException("Retrieving the next permitted poll time for " . get_class($this) . " is a programming error. " .
                                      "This is only allowed for jobs with status retrieval method set to '" . StatusRetrievalMethod::POLLING() . "'.");
    }
    return $this->nextPermittedPollTime;
  }

  public function getConfirmationReference() {
    return $this->confirmationReference;
  }

  public function getDeleteDocumentsUrl() {
    return $this->deleteDocumentsUrl;
  }

  public function __toString() {
    return "status for direct job with ID " . $this->signatureJobId . ": " . $this->status;
  }

}
