<?php

namespace Digipost\Signature\Client\Portal;

use Digipost\Signature\API\XML\XMLNotifications;
use Digipost\Signature\Client\Core\Internal\PersonalIdentificationNumbers;

/**
 * The signer is represented either with a personal identification number, or a custom identifier
 * as specified by the sender {@link PortalSigner upon creation of the job}.
 *
 * Exactly one of {@link Signer::$personalIdentificationNumber} or {@link Signer::$emailAddress} and/or
 * {@link Signer::$mobileNumber} will have a value.
 *
 * @package Digipost\Signature\Client\Portal
 */
class Signer {

  /** @var String */
  protected $personalIdentificationNumber;

  /** @var String */
  protected $emailAddress;

  /** @var String */
  protected $mobileNumber;

  function __construct(String $personalIdentificationNumber = NULL, XMLNotifications $identifier = NULL) {
    $this->personalIdentificationNumber = $personalIdentificationNumber;
    if ($identifier !== NULL) {
      if ($identifier->getEmail() !== NULL) {
        $this->emailAddress = $identifier->getEmail()->getAddress();
      }
      if ($identifier->getSms() !== NULL) {
        $this->mobileNumber = $identifier->getSms()->getNumber();
      }
    }
  }

  private static function isEqual($a, $b) {
    return ($a === NULL && $b === NULL) || ($a !== NULL && $a === $b);
  }

  function isSameAs(SignerIdentifier $other) {
    return
      self::isEqual($this->personalIdentificationNumber,
        $other->getPersonalIdentificationNumber()) &&
      self::isEqual($this->emailAddress, $other->getEmailAddress()) &&
      self::isEqual($this->mobileNumber, $other->getMobileNumber());
  }

  function hasPersonalIdentificationNumber() {
    return $this->personalIdentificationNumber !== NULL;
  }

  public function __toString() {

    if ($this->personalIdentificationNumber !== NULL) {
      return PersonalIdentificationNumbers::mask($this->personalIdentificationNumber);
    }
    else {
      if ($this->emailAddress !== NULL && $this->mobileNumber === NULL) {
        return $this->emailAddress;
      }
      else {
        if ($this->emailAddress === NULL && $this->mobileNumber !== NULL) {
          return $this->mobileNumber;
        }
        else {
          return $this->emailAddress . " and " . $this->mobileNumber;
        }
      }
    }
  }

  /**
   * @return String
   */
  public function getPersonalIdentificationNumber(): String {
    return $this->personalIdentificationNumber;
  }

  /**
   * @return String
   */
  public function getEmailAddress(): String {
    return $this->emailAddress;
  }

  /**
   * @return String
   */
  public function getMobileNumber(): String {
    return $this->mobileNumber;
  }
}