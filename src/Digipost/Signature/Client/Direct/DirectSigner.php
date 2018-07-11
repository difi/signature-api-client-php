<?php

namespace Digipost\Signature\Client\Direct;

use Digipost\Signature\Client\Core\Internal\SignerCustomizations;
use Digipost\Signature\Client\Core\OnBehalfOf;
use Digipost\Signature\Client\Core\SignatureType;
use Digipost\Signature\Client\Core\Internal\PersonalIdentificationNumbers;

class DirectSigner {

  protected $personalIdentificationNumber;

  protected $customIdentifier;

  /**
   * @var SignatureType
   */
  protected $signatureType;

  /**
   * @var OnBehalfOf
   */
  protected $onBehalfOf;

  public static function withPersonalIdentificationNumber($personalIdentificationNumber) {
    return new DirectSignerBuilder($personalIdentificationNumber, NULL);
  }

  public static function withCustomIdentifier($customIdentifier) // [String customIdentifier]
  {
    return new DirectSignerBuilder(NULL, $customIdentifier);
  }

  public function __construct(String $personalIdentificationNumber = NULL,
                              String $customIdentifier = NULL,
                              SignatureType $signatureType = NULL,
                              OnBehalfOf $onBehalfOf = NULL) {
    $this->personalIdentificationNumber = $personalIdentificationNumber;
    $this->customIdentifier = $customIdentifier;
    $this->signatureType = $signatureType;
    $this->onBehalfOf = $onBehalfOf;
  }

  public function isIdentifiedByPersonalIdentificationNumber() {
    return isset($this->personalIdentificationNumber);
  }

  public function getPersonalIdentificationNumber() {
    if (!$this->isIdentifiedByPersonalIdentificationNumber()) {
      throw new \RuntimeException(self::class . " is not identified by personal identification number, use getCustomIdentifier() instead.");
    }
    return $this->personalIdentificationNumber;
  }

  public function getCustomIdentifier() {
    if (!isset($this->customIdentifier)) {
      throw new \RuntimeException(self::class . " is not identified by a custom identifier, use getPersonalIdentificationNumber() instead.");
    }
    return $this->customIdentifier;
  }

  public function getSignatureType() {
    return $this->signatureType;
  }

  /**
   * @return \Digipost\Signature\Client\Core\OnBehalfOf
   */
  public function getOnBehalfOf() {
    return $this->onBehalfOf;
  }

  public function __toString() {
    return (DirectSigner::class . ": ") . ($this->isIdentifiedByPersonalIdentificationNumber() ? PersonalIdentificationNumbers::mask($this->personalIdentificationNumber) : $this->customIdentifier);
  }
}

class DirectSignerBuilder implements SignerCustomizations {

  private $personalIdentificationNumber;

  private $customIdentifier;

  private $signatureType = NULL;

  private $onBehalfOf = NULL;

  public function __construct(String $personalIdentificationNumber = NULL,
                              String $customIdentifier = NULL) {
    $this->personalIdentificationNumber = $personalIdentificationNumber;
    $this->customIdentifier = $customIdentifier;
  }

  public function withSignatureType(SignatureType $type) {
    $this->signatureType = $type;
    return $this;
  }

  public function onBehalfOf(OnBehalfOf $onBehalfOf) {
    $this->onBehalfOf = $onBehalfOf;
    return $this;
  }

  public function build() {
    return new DirectSigner($this->personalIdentificationNumber,
                            $this->customIdentifier, $this->signatureType,
                            $this->onBehalfOf);
  }
}


