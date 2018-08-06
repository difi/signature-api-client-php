<?php

namespace Digipost\Signature\Client\Portal;

use Digipost\Signature\API\XML\XMLSignatureStatus;

class SignatureStatus {

  /**
   * @var SignatureStatus
   * The signer has rejected to sign the document.
   */
  public static $REJECTED;
  /**
   * @var SignatureStatus
   * This signer has been cancelled by the sender, and will not be able to sign the document.
   */
  public static $CANCELLED;
  /**
   * @var SignatureStatus
   * This signer is reserved from receiving documents electronically, and will not receive the document for signing.
   */
  public static $RESERVED;
  /**
   * @var SignatureStatus
   * We were not able to locate any channels (email, SMS) for notifying the signer to sign the document.
   */
  public static $CONTACT_INFORMATION_MISSING;
  /**
   * @var SignatureStatus
   * The signer has not made a decision to either sign or reject the document within the specified time limit,
   */
  public static $EXPIRED;
  /**
   * @var SignatureStatus
   * The signer has yet to review the document and decide if she/he wants to sign or reject it.
   */
  public static $WAITING;
  /**
   * @var SignatureStatus
   * The signer has successfully signed the document.
   */
  public static $SIGNED;

  /**
   * The job has reached a state where the status of this signature is not applicable.
   * This includes the case where a signer rejects to sign, and thus ending the job in a
   * {@link PortalJobStatus::FAILED} state. Any remaining (previously {@link SignatureStatus::$WAITING})
   * signatures are marked as {@link SignatureStatus::$NOT_APPLICABLE}.
   *
   * @var SignatureStatus
   */
  public static $NOT_APPLICABLE;

  /**
   * The signer entered the wrong security code too many times. Only applicable for
   * signers addressed by {@link PortalSigner::identifiedByEmail() e-mail address} or
   * {@link PortalSigner::identifiedByMobileNumber() mobile number}.
   *
   * @var SignatureStatus
   */
  public static $BLOCKED;

  /**
   * Indicates that the service was unable to retrieve the signer's name.
   * <p>
   * This happens when the signer's name is permanently unavailable in the lookup service,
   * creating and signing a new signature job with the same signer will yield the same result.
   * <p>
   * Only applicable for {@link SignatureType::AUTHENTICATED_SIGNATURE authenticated signatures}
   * where the sender requires signed documents to contain {@link IdentifierInSignedDocuments::NAME name}
   * as {@link PortalJobBuilder::withIdentifierInSignedDocuments() the signer's identifier}.
   *
   * @var SignatureStatus
   */
  public static $SIGNERS_NAME_NOT_AVAILABLE;

  /** @var SignatureStatus[] */
  protected static $KNOWN_STATUSES;

  /** @var String */
  protected $identifier;

  public static function __staticInit() {
    self::$REJECTED = new SignatureStatus("REJECTED");
    self::$CANCELLED = new SignatureStatus("CANCELLED");
    self::$RESERVED = new SignatureStatus("RESERVED");
    self::$CONTACT_INFORMATION_MISSING = new SignatureStatus("CONTACT_INFORMATION_MISSING");
    self::$EXPIRED = new SignatureStatus("EXPIRED");
    self::$WAITING = new SignatureStatus("WAITING");
    self::$SIGNED = new SignatureStatus("SIGNED");
    self::$NOT_APPLICABLE = new SignatureStatus("NOT_APPLICABLE");
    self::$BLOCKED = new SignatureStatus("BLOCKED");
    self::$SIGNERS_NAME_NOT_AVAILABLE = new SignatureStatus("SIGNERS_NAME_NOT_AVAILABLE");
    self::$KNOWN_STATUSES = [
      self::$REJECTED,
      self::$CANCELLED,
      self::$RESERVED,
      self::$CONTACT_INFORMATION_MISSING,
      self::$EXPIRED,
      self::$WAITING,
      self::$SIGNED,
      self::$NOT_APPLICABLE,
      self::$BLOCKED,
      self::$SIGNERS_NAME_NOT_AVAILABLE,
    ];
  }

  public function __construct(String $identifier) {
    $this->identifier = $identifier;
    return $this;
  }

  public static function fromXmlType(XMLSignatureStatus $xmlSignatureStatus) {
    $value = $xmlSignatureStatus->getValue();
    foreach (self::$KNOWN_STATUSES as $status) {
      /** @var SignatureStatus $status */
      if ($status->is($value)) {
        return $status;
      }
    }
    return new SignatureStatus($value);
  }

  protected function is($xmlSignatureStatus) {
    return $this->identifier === $xmlSignatureStatus;
  }

  public function equals($o) {
    if ($o instanceof SignatureStatus) {
      $that = clone $o;
      return $this->identifier === $that->identifier;
    }
    return FALSE;
  }

  public function hashCode() {
    return md5($this->identifier);
  }

  public function __toString() {
    return $this->identifier;
  }
}

SignatureStatus::__staticInit();
