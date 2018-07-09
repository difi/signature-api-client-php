<?php

namespace Digipost\Signature\Client\Portal;

use Digipost\Signature\API\XML\XMLSignatureStatus;

class SignatureStatus {

  public static $REJECTED;  // SignatureStatus

  public static $CANCELLED;  // SignatureStatus

  public static $RESERVED;  // SignatureStatus

  public static $CONTACT_INFORMATION_MISSING;  // SignatureStatus

  public static $EXPIRED;  // SignatureStatus

  public static $WAITING;  // SignatureStatus

  public static $SIGNED;  // SignatureStatus

  public static $NOT_APPLICABLE;  // SignatureStatus

  public static $BLOCKED;  // SignatureStatus

  public static $SIGNERS_NAME_NOT_AVAILABLE;  // SignatureStatus

  protected static $KNOWN_STATUSES;  // List<SignatureStatus>

  protected $identifier;  // String

  public static function __staticInit() { // static class members
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

  public function toString() {
    return $this->identifier;
  }
}

SignatureStatus::__staticInit(); // initialize static vars for this class on load

