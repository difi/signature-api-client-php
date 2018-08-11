<?php

namespace Digipost\Signature\Client\Portal;

use Digipost\Signature\API\XML\XMLNotifications;
use Digipost\Signature\Client\Core\Exceptions\SignatureException;
use Digipost\Signature\Client\Core\XAdESReference;

class Signature {

  /** @var Signer */
  private $signer;

  /** @var SignatureStatus */
  private $status;

  /** @var \DateTime */
  private $statusDateTime;

  /** @var XAdESReference */
  private $xAdESReference;

  function __construct(String $personalIdentificationNumber,
                       XMLNotifications $identifier,
                       SignatureStatus $status,
                       \DateTime $statusDateTime,
                       XAdESReference $xAdESReference) {
    $this->signer = new Signer($personalIdentificationNumber, $identifier);
    $this->status = $status;
    $this->xAdESReference = $xAdESReference;
    $this->statusDateTime = $statusDateTime;
  }

  /**
   * Retrieves signer's personal identification number. If signer is identified
   * by contact information, use {@link PortalJobStatusChanged#getSignatureFrom(SignerIdentifier)}.
   *
   * @throws SignatureException if signer is identified by contact information.
   */
  public function getSigner() {
    if ($this->signer->hasPersonalIdentificationNumber()) {
      return $this->signer->getPersonalIdentificationNumber();
    }
    throw new SignatureException("Can't retrieve signers identified by contact information using this method. Use method PortalJobStatusChange.getSignatureFrom() instead.");
  }

  public function getStatus() {
    return $this->status;
  }

  public function is(SignatureStatus $status) {
    return $this->status === $status;
  }

  static function signatureFrom(SignerIdentifier $signer) {
    return function ($signature) use ($signer) {
      /** @var Signature $signature */
      return $signature->signer->isSameAs($signer);
    };
  }

  /**
   * @return
   */

  /**
   * @return \DateTime Point in time when the action (document was signed, signature job expired, etc.)
   * leading to the current {@link Signature::$status} happened.
   */
  public function getStatusDateTime() {
    return $this->statusDateTime;
  }

  public function getxAdESUrl() {
    return $this->xAdESReference;
  }

  public function toString() {
    return "Signature from " . $this->signer . " with status '" . $this->status . "' since " . $this->statusDateTime->format(\DateTime::RFC3339) .
      ($this->xAdESReference !== NULL ? ". XAdES available at " . $this->xAdESReference->getxAdESUrl() : "");
  }
}
