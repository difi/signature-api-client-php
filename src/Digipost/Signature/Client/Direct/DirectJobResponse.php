<?php

namespace Digipost\Signature\Client\Direct;

/**
 * Class DirectJobResponse
 *
 * @package Digipost\Signature\Client\Direct
 */
class DirectJobResponse {

  protected $signatureJobId;

  /**
   * @var RedirectUrls[]
   */
  protected $redirectUrls;

  protected $statusUrl;

  public function __construct($signatureJobId, array $redirectUrls, String $statusUrl)
  {
    $this->signatureJobId = $signatureJobId;
    $this->redirectUrls = RedirectUrls::List($redirectUrls);
    $this->statusUrl = $statusUrl;
  }

  public function getSignatureJobId() {
    return $this->signatureJobId;
  }

  public function getSingleRedirectUrl() {
    return $this->redirectUrls->getSingleRedirectUrl();
  }

  public function getRedirectUrls() {
    return $this->redirectUrls;
  }

  public function getStatusUrl() {
    return $this->statusUrl;
  }
}

