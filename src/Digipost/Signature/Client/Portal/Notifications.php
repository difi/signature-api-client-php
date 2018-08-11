<?php

namespace Digipost\Signature\Client\Portal;

use Digipost\Signature\Client\Core\Exceptions\IllegalStateException;

class Notifications {

  protected $emailAddress;

  protected $mobileNumber;

  public function __construct(String $emailAddress = NULL, String $mobileNumber = NULL) {
    $this->emailAddress = $emailAddress;
    $this->mobileNumber = $mobileNumber;
  }

  public function getEmailAddress() {
    return $this->emailAddress;
  }

  public function getMobileNumber() {
    return $this->mobileNumber;
  }

  public function shouldSendEmail() {
    return ($this->emailAddress !== NULL);
  }

  public function shouldSendSms() {
    return ($this->mobileNumber !== NULL);
  }

  public static function builder() {
    return new NotificationsBuilder();
  }

  public function __toString() {
    if ($this->emailAddress !== NULL && $this->mobileNumber !== NULL) {
      return "Notifications to " . $this->emailAddress . " and " . $this->mobileNumber;
    }
    else {
      if ($this->emailAddress !== NULL) {
        return "Notification to " . $this->emailAddress;
      }
      else {
        if ($this->mobileNumber !== NULL) {
          return "Notification to " . $this->mobileNumber;
        }
        else {
          return "No notifications";
        }
      }
    }
  }
}

class NotificationsBuilder {

  private $target;

  private $built = FALSE;
  private $emailAddress;
  private $mobileNumber;

  function __construct() {
    $this->target = new Notifications();
  }

  public function withEmailTo(String $emailAddress) {
    $this->emailAddress = $emailAddress;

    return $this;
  }

  public function withSmsTo(String $mobileNumber) {
    $this->mobileNumber = $mobileNumber;

    return $this;
  }

  public function build() {
    if ($this->built) {
      throw new IllegalStateException("Can't build twice");
    }
    if ($this->emailAddress === NULL && $this->mobileNumber === NULL) {
      throw new IllegalStateException("At least one way of notifying the signer must be specified");
    }
    $this->built = TRUE;
    return new Notifications($this->emailAddress, $this->mobileNumber);
  }
}