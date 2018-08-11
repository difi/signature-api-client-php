<?php

namespace Digipost\Signature\Client\Direct;

use Digipost\Signature\Client\Core\ConfirmationReference;
use Digipost\Signature\Client\Core\DeleteDocumentsUrl;
use Digipost\Signature\Client\Core\Exceptions\IllegalStateException;
use Digipost\Signature\Client\Core\Internal\Confirmable;
use Digipost\Signature\Client\Core\PAdESReference;
use Ds\Set;

class DirectJobStatusResponse implements Confirmable, \Serializable, \JsonSerializable {

  /**
   * This instance indicates that there has been no status updates since the last poll request for
   * {@link DirectJobStatusResponse}. Its status is {@link DirectJobStatus::NO_CHANGES NO_CHANGES}.
   *
   * @param \DateTime $nextPermittedPollTime
   *
   * @return DirectJobStatusResponse
   */
  static function noUpdatedStatus(\DateTime $nextPermittedPollTime) {
    return new DirectJobStatusResponse(
      NULL, DirectJobStatus::NO_CHANGES(),
      NULL, NULL, NULL, NULL,
      $nextPermittedPollTime);
  }

  /** @var int */
  private $signatureJobId;

  /** @var DirectJobStatus */
  private $status;

  /** @var ConfirmationReference */
  private $confirmationReference;

  /** @var DeleteDocumentsUrl */
  private $deleteDocumentsUrl;

  /** @var Signature[] */
  private $signatures;

  /** @var PAdESReference */
  private $pAdESReference;

  /** @var \DateTime */
  private $nextPermittedPollTime;

  public function __construct(
    int $signatureJobId = NULL,
    DirectJobStatus $signatureJobStatus = NULL,
    ConfirmationReference $confirmationUrl = NULL,
    DeleteDocumentsUrl $deleteDocumentsUrl = NULL,
    array $signatures = NULL,
    PAdESReference $pAdESReference = NULL,
    \DateTime $nextPermittedPollTime = NULL) {
    $this->signatureJobId = $signatureJobId;
    $this->status = $signatureJobStatus;
    $this->confirmationReference = $confirmationUrl;
    $this->deleteDocumentsUrl = $deleteDocumentsUrl;
    $this->signatures = new Set($signatures);
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

  public function getSignatures(): Set {
    return $this->signatures;
  }

  /**
   * Gets the signature from a given signer.
   *
   * @param String $signer a string referring to a signer of the job. It may be a personal
   *                       identification number or a custom signer reference, depending of how the
   *                       {@link DirectSigner signer} was initially created
   *                       (using
   *                       {@link DirectSigner::withPersonalIdentificationNumber #withPersonalIdentificationNumber} or
   *                       {@link DirectSigner::withCustomIdentifier #withCustomIdentifier}).
   *
   * @return Signature
   * @throws \InvalidArgumentException if the job response doesn't contain a signature from this
   *                                   signer
   * @see DirectJobStatusResponse::getSignatures()
   */
  public function getSignatureFrom(String $signer) {
    try {
      return $this->signatures->filter(self::signatureFrom($signer))
                              ->first();
    } catch (\UnderflowException $e) {
      throw new \InvalidArgumentException('Unable to find signature from this signer');
    }
  }

  /**
   * @param String $signer
   *
   * @return \Closure
   */
  static private function signatureFrom(String $signer) {
    return function ($signature) use ($signer) {
      /** @var Signature $signature */
      return $signature->isFrom($signer);
    };
  }
  /**
   * Gets the point in time where you are allowed to
   * {@link DirectClient::getStatusChange() get status changes}.
   * <p>
   * Only applicable for jobs with
   * {@link DirectJobBuilder::retrieveStatusBy() status retrieval method} set to
   * {@link StatusRetrievalMethod::POLLING POLLING}.
   *
   * @throws IllegalStateException for jobs with
   *                               {@link DirectJobBuilder::retrieveStatusBy() status retrieval method}
   * <b>not</b> set to {@link StatusRetrievalMethod::POLLING POLLING}.
   */
  public function getNextPermittedPollTime(): \DateTime {
    if ($this->nextPermittedPollTime === NULL) {
      throw new IllegalStateException(
        "Retrieving the next permitted poll time for " . get_class($this) .
        " is a programming error. " .
        "This is only allowed for jobs with status retrieval method set to '" .
        StatusRetrievalMethod::POLLING() . "'.");
    }

    return $this->nextPermittedPollTime;
  }

  public function getConfirmationReference(): ConfirmationReference {
    return $this->confirmationReference;
  }

  public function getDeleteDocumentsUrl(): DeleteDocumentsUrl {
    return $this->deleteDocumentsUrl;
  }

  public function __toString() {
    return "status for direct job with ID " . $this->signatureJobId . ": " . $this->status;
  }

  public function serialize() {
    $obj = get_object_vars($this);

    return \serialize($obj);
  }

  public function unserialize($serialized) {
    $v = \unserialize($serialized);
    $this->__construct(
      $v['signatureJobId'], $v['signatureJobStatus'], $v['confirmationUrl'],
      $v['deleteDocumentsUrl'], $v['signatures'], $v['pAdESReference'],
      $v['nextPermittedPollTime']);
    // TODO: Implement unserialize() method.
  }

  public function jsonSerialize() {
    $obj = get_object_vars($this);
    return json_encode($obj);
  }
}
