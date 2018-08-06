<?php

namespace Digipost\Signature\Client\Direct;

class SignerStatus {

  /**
   * The signer has rejected to sign the document.
   */
  public static $REJECTED;

  /**
   * The signer has not made a decision to either sign or reject the document within the specified
   * time limit.
   */
  public static $EXPIRED;

  /**
   * The signer has yet to review the document and decide if she/he wants to sign or reject it.
   */
  public static $WAITING;

  /**
   * The signer has successfully signed the document.
   */
  public static $SIGNED;

  /**
   * An unexpected error occured during the signing ceremony.
   */
  public static $FAILED;

  /**
   * The job has reached a state where the status of this signature is not applicable.
   * This includes the case where a signer rejects to sign, and thus ending the job in a
   * {@link DirectJobStatus::FAILED FAILED} state. Any remaining (previously
   * {@link SignerStatus::$WAITING WAITING}) signatures are marked as
   * {@link SignerStatus::$NOT_APPLICABLE NOT_APPLICABLE}.
   */
  public static $NOT_APPLICABLE;

  /**
   * Indicates that the service was unable to retrieve the signer's name.
   * <p>
   * This happens when the signer's name is permanently unavailable in the lookup service,
   * creating and signing a new signature job with the same signer will yield the same result.
   * <p>
   * Only applicable for {@link SignatureType::AUTHENTICATED_SIGNATURE authenticated signatures}
   * where the sender requires signed documents to contain {@link IdentifierInSignedDocuments::NAME name}
   * as {@link DirectJobBuilder::withIdentifierInSignedDocuments the signer's identifier}.
   */
  public static $SIGNERS_NAME_NOT_AVAILABLE;

  protected static $KNOWN_STATUSES;

  protected $identifier;

  public static function __staticInit() {
    self::$REJECTED = new SignerStatus("REJECTED");
    self::$EXPIRED = new SignerStatus("EXPIRED");
    self::$WAITING = new SignerStatus("WAITING");
    self::$SIGNED = new SignerStatus("SIGNED");
    self::$FAILED = new SignerStatus("FAILED");
    self::$NOT_APPLICABLE = new SignerStatus("NOT_APPLICABLE");
    self::$SIGNERS_NAME_NOT_AVAILABLE = new SignerStatus("SIGNERS_NAME_NOT_AVAILABLE");
    self::$KNOWN_STATUSES = [
      self::$REJECTED,
      self::$EXPIRED,
      self::$WAITING,
      self::$SIGNED,
      self::$FAILED,
      self::$NOT_APPLICABLE,
      self::$SIGNERS_NAME_NOT_AVAILABLE,
    ];
  }

  public function __construct($identifier) {
    $this->identifier = $identifier;
    return $this;
  }

  public static function fromXmlType($xmlSignerStatus) {
    foreach (self::$KNOWN_STATUSES as $status) {
      /** @var SignerStatus $status */
      if ($status->is($xmlSignerStatus)) {
        return $status;
      }
    }

    return new SignerStatus($xmlSignerStatus);
  }

  protected function is($xmlSignerStatus) {
    return $this->identifier === $xmlSignerStatus;
  }

  public function __toString() {
    return $this->identifier;
  }
}

SignerStatus::__staticInit();