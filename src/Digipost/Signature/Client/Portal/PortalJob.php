<?php

namespace Digipost\Signature\Client\Portal;

use Digipost\Signature\Client\Core\AuthenticationLevel;
use Digipost\Signature\Client\Core\IdentifierInSignedDocuments;
use Digipost\Signature\Client\Core\Internal\JobCustomizations;
use Digipost\Signature\Client\Core\JOB;
use Digipost\Signature\Client\Core\Sender;
use Time\Unit\TimeUnitInterface;
use Time\Unit\TimeUnitDay;
use Time\Unit\TimeUnitHour;
use Time\Unit\TimeUnitMinute;

/**
 * Class PortalJob
 *
 * @package Digipost\Signature\Client\Portal
 */
class PortalJob implements JOB {

  private $signers;

  private $document;

  private $reference;

  private $activationTime = NULL;

  private $availableSeconds;

  private $sender = NULL;

  private $requiredAuthentication = NULL;

  private $identifierInSignedDocuments = NULL;

  function __construct(array $signers, PortalDocument $document) {
    $this->signers = $signers;
    $this->document = $document;
  }

  public function getReference() {
    return $this->reference;
  }

  public function setReference($reference) {
    $this->reference = $reference;
  }

  public function getDocument() {
    return $this->document;
  }

  public function getSender() {
    return $this->sender;
  }


  public function getRequiredAuthentication(): AuthenticationLevel {
    return $this->requiredAuthentication;
  }


  public function getIdentifierInSignedDocuments(): IdentifierInSignedDocuments {
    return $this->identifierInSignedDocuments;
  }

  public function getSigners() {
    return $this->signers;
  }

  public function getActivationTime() {
    return $this->activationTime;
  }

  public function getAvailableSeconds() {
    return $this->availableSeconds;
  }


  public function builder(PortalDocument $document, $signers) {
    if (!is_array($signers)) {
      $signers = [$signers];
    }
    return new PortalJobBuilder($signers, $document);
  }

  /**
   * @param null $activationTime
   */
  public function setActivationTime($activationTime) {
    $this->activationTime = $activationTime;
  }

  /**
   * @param mixed $availableSeconds
   */
  public function setAvailableSeconds($availableSeconds) {
    $this->availableSeconds = $availableSeconds;
  }

  /**
   * @param null $sender
   */
  public function setSender($sender) {
    $this->sender = $sender;
  }

  /**
   * @param null $requiredAuthentication
   */
  public function setRequiredAuthentication($requiredAuthentication) {
    $this->requiredAuthentication = $requiredAuthentication;
  }

  /**
   * @param null $identifierInSignedDocuments
   */
  public function setIdentifierInSignedDocuments($identifierInSignedDocuments) {
    $this->identifierInSignedDocuments = $identifierInSignedDocuments;
  }
}

/**
 * Class PortalJobBuilder
 *
 * @package Digipost\Signature\Client\Portal
 */
class PortalJobBuilder implements JobCustomizations {

  /**
   * @var PortalJob
   */
  private $target;

  /**
   * @var bool
   */
  private $built = FALSE;

  /**
   * PortalJobBuilder constructor.
   *
   * @param PortalSigner[] $signers
   * @param PortalDocument $document
   */
  function __construct(array $signers, PortalDocument $document) {
    $this->target = new PortalJob($signers, $document);
  }

  public function withReference($reference) {
    if (!is_string($reference)) {
      $reference = $reference->toString();
    }
    $this->target->setReference($reference);
    return $this;
  }


  public function withSender(Sender $sender) {
    $this->target->setSender($sender);
    return $this;
  }


  public function requireAuthentication(AuthenticationLevel $minimumLevel) {
    $this->target->setRequiredAuthentication($minimumLevel);
    return $this;
  }


  public function withIdentifierInSignedDocuments(IdentifierInSignedDocuments $identifier) {
    $this->target->setIdentifierInSignedDocuments($identifier);
    return $this;
  }

  public function withActivationTime(\DateTime $activationTime) {
    $this->target->setActivationTime($activationTime);
    return $this;
  }

  public function availableFor(int $duration, TimeUnitInterface $unit) {
    $seconds = $duration;
    switch (get_class($unit)) {
      case TimeUnitDay::class:
        $seconds = TimeUnitDay::toSeconds($duration); break;
      case TimeUnitHour::class:
        $seconds = TimeUnitHour::toSeconds($duration); break;
      case TimeUnitMinute::class:
        $seconds = TimeUnitMinute::toSeconds($duration); break;
    }

    $this->target->setAvailableSeconds($seconds);
    return $this;
  }

  public function build() {
    if ($this->built) {
      throw new \RuntimeException("Can't build twice");
    }
    $this->built = TRUE;
    return $this->target;
  }

  function withReference_UUID($uuid) {
    return $this->withReference_String($uuid->toString());
  }

  function withReference_String(String $reference) {
    return $this->withReference($reference);
  }
}