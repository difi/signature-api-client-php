<?php

namespace Digipost\Signature\Client\Direct;

class SignerStatus {

  public static $REJECTED;

  public static $EXPIRED;

  public static $WAITING;

  public static $SIGNED;

  public static $FAILED;

  public static $NOT_APPLICABLE;

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

  protected static function fromXmlType($xmlSignerStatus)
  {
    foreach (self::$KNOWN_STATUSES as $status) {
      /** @var SignerStatus $status */
      if ($status->is($xmlSignerStatus)) {
        return $status;
      }
    }
    return new SignerStatus($xmlSignerStatus);
  }

  protected function is($xmlSignerStatus)
  {
    return $this->identifier === $xmlSignerStatus;
  }

  public function __toString() {
    return $this->identifier;
  }
}

SignerStatus::__staticInit(); // initialize static vars for this class on load

