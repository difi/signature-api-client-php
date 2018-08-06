<?php

namespace Digipost\Signature\Client\Direct;

use Digipost\Signature\Client\Core\Exceptions\IllegalStateException;

/**
 * Class DirectJobResponse
 *
 * @package Digipost\Signature\Client\Direct
 */
class DirectJobResponse {

  protected $signatureJobId;

  protected $reference;

  /**
   * @var RedirectUrls[]
   */
  protected $redirectUrls;

  protected $statusUrl;

  public function __construct($signatureJobId, $reference, array $redirectUrls, $statusUrl) {
    $this->signatureJobId = $signatureJobId;
    $this->reference = $reference;
    $this->redirectUrls = RedirectUrls::List($redirectUrls);
    $this->statusUrl = $statusUrl;
  }

  public function getSignatureJobId() {
    return $this->signatureJobId;
  }

  /**
   * Gets the only redirect URL for this job.
   * Convenience method for retrieving the redirect URL for jobs with exactly one signer.
   * @throws IllegalStateException if there are multiple redirect URLs
   * @see DirectJobResponse::getRedirectUrls
   */
  public function getSingleRedirectUrl() {
    return $this->redirectUrls->getSingleRedirectUrl();
  }

  public function getRedirectUrls() {
    return $this->redirectUrls;
  }

  public function getStatusUrl() {
    return $this->statusUrl;
  }

  /**
   * @return string the signature job's custom reference as specified upon
   * {@link DirectJobBuilder::withReference() creation}. May be `null`.
   */
  public function getReference() {
    return $this->reference;
  }
}

