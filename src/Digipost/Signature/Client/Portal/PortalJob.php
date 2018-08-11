<?php

namespace Digipost\Signature\Client\Portal;

use Digipost\Signature\Client\Core\AuthenticationLevel;
use Digipost\Signature\Client\Core\IdentifierInSignedDocuments;
use Digipost\Signature\Client\Core\Internal\JobCustomizations;
use Digipost\Signature\Client\Core\JOB;
use Digipost\Signature\Client\Core\Sender;

/**
 * Class PortalJob
 *
 * @package Digipost\Signature\Client\Portal
 */
class PortalJob implements JOB {

  /** @var PortalSigner[] */
  private $signers;

  /** @var PortalDocument */
  private $document;

  /** @var String */
  private $reference;

  /** @var \DateTime */
  private $activationTime = NULL;

  /** @var integer */
  private $availableSeconds;

  /** @var Sender */
  private $sender = NULL;

  /** @var AuthenticationLevel */
  private $requiredAuthentication = NULL;

  /** @var IdentifierInSignedDocuments */
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

  public function getRequiredAuthentication() {
    return $this->requiredAuthentication;
  }

  public function getIdentifierInSignedDocuments() {
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


  public static function builder(PortalDocument $document, $signers) {
    if (!is_array($signers)) {
      $signers = [$signers];
    }
    return new PortalJobBuilder($signers, $document);
  }

  /**
   * @param \DateTime $activationTime
   */
  public function setActivationTime($activationTime) {
    $this->activationTime = $activationTime;
  }

  /**
   * @param integer $availableSeconds
   */
  public function setAvailableSeconds($availableSeconds) {
    $this->availableSeconds = $availableSeconds;
  }

  /**
   * @param Sender $sender
   */
  public function setSender($sender) {
    $this->sender = $sender;
  }

  /**
   * @param AuthenticationLevel $requiredAuthentication
   */
  public function setRequiredAuthentication($requiredAuthentication) {
    $this->requiredAuthentication = $requiredAuthentication;
  }

  /**
   * @param IdentifierInSignedDocuments $identifierInSignedDocuments
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

  public function withReference(String $reference) {
    if (!is_string($reference)) {
      $reference = (string) $reference;
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

  public function availableFor(int $duration, TimeUnit $unit) {
    $seconds = $duration;
    $this->target->setAvailableSeconds($unit->toSeconds($seconds));
    return $this;
  }

  public function build() {
    if ($this->built) {
      throw new \RuntimeException("Can't build twice");
    }
    $this->built = TRUE;
    return $this->target;
  }
}