<?php

namespace Digipost\Signature\Client\Portal;

use Digipost\Signature\Client\Core\Internal\IdentifierType;
use Digipost\Signature\Client\Core\Internal\PersonalIdentificationNumbers;
use Digipost\Signature\Client\Core\Internal\SignerCustomizations;
use Digipost\Signature\Client\Core\OnBehalfOf;
use Digipost\Signature\Client\Core\SignatureType;

class PortalSigner {

  protected $identifierType;  // IdentifierType

  protected $identifier;  // Optional<String>

  protected $notifications;  // Notifications

  public $notificationsUsingLookup;  // NotificationsUsingLookup

  public $order = 0;

  public $signatureType = NULL;

  /**
   * @var OnBehalfOf
   */
  public $onBehalfOf = NULL;

  function __construct(IdentifierType $identifierType = NULL,
                       String $personalIdentificationNumber = NULL,
                       Notifications $notifications = NULL,
                       NotificationsUsingLookup $notificationsUsingLookup = NULL) {
    if (isset($identifierType)) {
      $this->identifierType = $identifierType;
    }
    if (isset($personalIdentificationNumber)) {
      $this->identifier = $personalIdentificationNumber;
    }
    if (isset($notifications)) {
      $this->notifications = $notifications;
    }
    if (isset($notificationsUsingLookup)) {
      $this->notificationsUsingLookup = $notificationsUsingLookup;
    }
    return $this;
  }

  public static function identifiedByPersonalIdentificationNumber_String_Notifications(String $personalIdentificationNumber,
                                                                                       Notifications $notifications) {
    return new PortalSignerBuilder(IdentifierType::PERSONAL_IDENTIFICATION_NUMBER(),
                                   $personalIdentificationNumber,
                                   $notifications);
  }

  public static function identifiedByPersonalIdentificationNumber_String_NotificationsUsingLookup($personalIdentificationNumber,
                                                                                                  $notificationsUsingLookup) // [String personalIdentificationNumber, NotificationsUsingLookup notificationsUsingLookup]
  {
    return new PortalSignerBuilder(IdentifierType::PERSONAL_IDENTIFICATION_NUMBER(),
                                   $personalIdentificationNumber, NULL,
                                   $notificationsUsingLookup);
  }

  public static function identifiedByEmail(String $emailAddress) {
    return new PortalSignerBuilder(IdentifierType::EMAIL(),
                                   NULL,
                                   Notifications::builder()
                                     ->withEmailTo($emailAddress)
                                     ->build());
  }

  public static function identifiedByMobileNumber(String $number) {
    return new PortalSignerBuilder(IdentifierType::MOBILE_NUMBER(),
                                   NULL,
                                   Notifications::builder()
                                     ->withSmsTo($number)
                                     ->build());
  }

  public static function identifiedByEmailAndMobileNumber(String $emailAddress,
                                                          String $number) {
    return new PortalSignerBuilder(IdentifierType::EMAIL_AND_MOBILE_NUMBER(),
                                   NULL,
                                   Notifications::builder()
                                     ->withEmailTo($emailAddress)
                                     ->withSmsTo($number)
                                     ->build());
  }

  public function isIdentifiedByPersonalIdentificationNumber() {
    return ($this->identifierType === IdentifierType::PERSONAL_IDENTIFICATION_NUMBER());
  }

  public function getIdentifier() {
    return $this->identifier;
  }

  public function getIdentifierType() {
    return $this->identifierType;
  }

  public function getOrder() {
    return $this->order;
  }

  public function getNotifications() {
    return $this->notifications;
  }

  public function getNotificationsUsingLookup() {
    return $this->notificationsUsingLookup;
  }

  public function getSignatureType(): SignatureType {
    return $this->signatureType;
  }

  public function getOnBehalfOf() {
    return $this->onBehalfOf;
  }

  public function toString() {
    return $this->isIdentifiedByPersonalIdentificationNumber() ?
      PersonalIdentificationNumbers::mask($this->identifier->get()) : ("Signer with " . $this->notifications);
  }
}

class PortalSignerBuilder implements SignerCustomizations {

  private $target;

  private $built = FALSE;

  function __construct(IdentifierType $identifierType,
                       String $personalIdentificationNumber,
                       Notifications $notifications,
                       NotificationsUsingLookup $notificationsUsingLookup = NULL) {
    $this->target = new PortalSigner($identifierType,
                                     $personalIdentificationNumber,
                                     $notifications,
                                     $notificationsUsingLookup);
  }

  //  private function Builder_Identifiertype(IdentifierType $identifierType,
  //                                          Notifications $notifications) {
  //    $this->target = new PortalSigner($identifierType, $notifications);
  //  }

  public function withOrder(int $order) {
    $this->target->order = $order;
    return $this;
  }

  public function withSignatureType(SignatureType $type) {
    $this->target->signatureType = $type;
    return $this;
  }

  public function onBehalfOf(OnBehalfOf $onBehalfOf) {
    $this->target->onBehalfOf = $onBehalfOf;
    return $this;
  }

  public function build() {
    if ($this->target->onBehalfOf !== NULL && $this->target->onBehalfOf === OnBehalfOf::OTHER() && $this->target->notificationsUsingLookup !== NULL) {
      throw new IllegalStateException("Can't look up contact information for notifications when signing on behalf of a third party");
    }
    if ($this->built) {
      throw new IllegalStateException("Can't build twice");
    }
    $this->built = TRUE;
    return $this->target;
  }

}