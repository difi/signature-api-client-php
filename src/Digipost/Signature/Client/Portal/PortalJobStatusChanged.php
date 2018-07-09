<?php

namespace Digipost\Signature\Client\Portal;

use Digipost\Signature\Client\Core\ConfirmationReference;
use Digipost\Signature\Client\Core\DeleteDocumentsUrl;
use Digipost\Signature\Client\Core\Internal\Cancellable;
use Digipost\Signature\Client\Core\Internal\Confirmable;
use Digipost\Signature\Client\Core\PAdESReference;

/**
 * Indicates a job which has got a new {@link PortalJobStatus status}
 * since the last time its status was queried.
 *
 * <h3>Confirmation</h3>
 *
 * When the client {@link Confirmable confirms} this, the job and its associated
 * resources will become unavailable through the Signature API.
 */
class PortalJobStatusChanged implements Confirmable, Cancellable {


  /**
   * This instance indicates that there has been no status updates since the last poll request for
   * {@link PortalJobStatusChanged}. Its status is {@link PortalJobStatus::NO_CHANGES NO_CHANGES}.
   *
   * @param \DateTime $nextPermittedPollTime
   *
   * @return PortalJobStatusChanged
   */
  static function noUpdatedStatus(\DateTime $nextPermittedPollTime) {
    return new PortalJobStatusChanged(NULL, PortalJobStatus::NO_CHANGES(), NULL,
                                      NULL, NULL, NULL,
                                      NULL, $nextPermittedPollTime);
    //    {
    //      public
    //      function getSignatureJobId() {
    //        throw new IllegalStateException(
    //          "There were " . get_class($this) . ", and querying the job ID is a programming error. " .
    //          "Use the method is(" . PortalJobStatus::class . "." . NO_CHANGES::name() . ") " .
    //        "to check if there were any status change before attempting to get any further information.");
    //            }
    //
    //      public
    //      function toString() {
    //        return "no portal jobs with updated status";
    //      }
    //    };
  }

  private $signatureJobId;

  private $status;

  private $deleteDocumentsUrl;

  private $pAdESReference;

  private $confirmationReference;

  private $cancellationUrl;

  private $signatures;

  private $nextPermittedPollTime;

  function __construct(int $signatureJobId,
                       PortalJobStatus $status,
                       ConfirmationReference $confirmationReference,
                       CancellationUrl $cancellationUrl,
                       DeleteDocumentsUrl $deleteDocumentsUrl,
                       PAdESReference $pAdESReference,
                       array $signatures,
                       \DateTime $nextPermittedPollTime) {
    $this->signatureJobId = $signatureJobId;
    $this->status = $status;
    $this->cancellationUrl = $cancellationUrl;
    $this->deleteDocumentsUrl = $deleteDocumentsUrl;
    $this->pAdESReference = $pAdESReference;
    $this->confirmationReference = $confirmationReference;
    $this->signatures = $signatures;
    $this->nextPermittedPollTime = $nextPermittedPollTime;
  }

  public function getSignatureJobId() {
    return $this->signatureJobId;
  }

  public function getStatus() {
    return $this->status;
  }

  public function is(PortalJobStatus $status) {
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
   * @param SignerIdentifier $signer an identifier referring to a signer of the job. It may be a personal identification number or
   *                                 contact information, depending of how the {@link PortalSigner signer} was initially created
   *                                 (using {@link PortalSigner::identifiedByPersonalIdentificationNumber personal identification number}<sup>1</sup>,
   *                                 {@link PortalSigner::identifiedByPersonalIdentificationNumber(String, NotificationsUsingLookup) personal identification number}<sup>2</sup>,
   *                                 {@link PortalSigner::identifiedByEmail}, {@link PortalSigner::identifiedByMobileNumber mobile number} or
   *                                 {@link PortalSigner::identifiedByEmailAndMobileNumber both email address and mobile number}).
   *                                 <p>
   *                                 <sup>1</sup>: with contact information provided.<br>
   *                                 <sup>2</sup>: using contact information from a lookup service.
   *                                 </p>
   *
   * @return
   * @throws IllegalArgumentException if the job response doesn't contain a signature from this signer
   */
  public function getSignatureFrom(SignerIdentifier $signer) {
    //    return $this->signatures->stream()
    //      ->filter($this->signatureFrom($signer))
    //      ->findFirst()
    //      ->orElseThrow(()-> new IllegalArgumentException("Unable to find signature from this signer"));
  }

  public function getNextPermittedPollTime() {
    return $this->nextPermittedPollTime;
  }

  public function getConfirmationReference() {
    return $this->confirmationReference;
  }

  public function getCancellationUrl() {
    return $this->cancellationUrl;
  }

  public function getDeleteDocumentsUrl() {
    return $this->deleteDocumentsUrl;
  }

  public function toString() {
    return "updated status for portal job with id " . $this->signatureJobId . ": " . $this->status;
  }
}
