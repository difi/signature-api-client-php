<?php

namespace Digipost\Signature\Client\Portal;

/**
 * Class SignerIdentifier
 *
 * @package Digipost\Signature\Client\Portal
 */
class SignerIdentifier {
  /** @var String  */
  protected $personalIdentificationNumber;

  /** @var String */
  protected $emailAddress;

  /** @var String */
  protected $mobileNumber;

  function __construct(String $personalIdentificationNumber = NULL,
                       String $emailAddress = NULL,
                       String $mobileNumber = NULL) {
    $this->personalIdentificationNumber = $personalIdentificationNumber;
    $this->emailAddress = $emailAddress;
    $this->mobileNumber = $mobileNumber;
  }

  public static function identifiedByPersonalIdentificationNumber(String $personalIdentificationNumber) {
    return new SignerIdentifier($personalIdentificationNumber);
  }

  public static function identifiedByEmailAddress(String $emailAddress) {
    return new SignerIdentifier(NULL, $emailAddress);
  }

  public static function identifiedByMobileNumber(String $mobileNumber) {
    return new SignerIdentifier(NULL, NULL, $mobileNumber);
  }

  public static function identifiedByEmailAddressAndMobileNumber(String $emailAddress,
                                                                 String $mobileNumber) {
    return new SignerIdentifier(NULL, $emailAddress, $mobileNumber);
  }

  /**
   * @return String
   */
  public function getPersonalIdentificationNumber(): String {
    return $this->personalIdentificationNumber;
  }

  /**
   * @param String $personalIdentificationNumber
   */
  public function setPersonalIdentificationNumber(String $personalIdentificationNumber) {
    $this->personalIdentificationNumber = $personalIdentificationNumber;
  }

  /**
   * @return String
   */
  public function getEmailAddress(): String {
    return $this->emailAddress;
  }

  /**
   * @param String $emailAddress
   */
  public function setEmailAddress(String $emailAddress) {
    $this->emailAddress = $emailAddress;
  }

  /**
   * @return String
   */
  public function getMobileNumber(): String {
    return $this->mobileNumber;
  }

  /**
   * @param String $mobileNumber
   */
  public function setMobileNumber(String $mobileNumber) {
    $this->mobileNumber = $mobileNumber;
  }
}

