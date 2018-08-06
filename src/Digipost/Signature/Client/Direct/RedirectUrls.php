<?php

namespace Digipost\Signature\Client\Direct;

use Digipost\Signature\Client\Core\Exceptions\IllegalStateException;

class RedirectUrls {

  /** @var RedirectUrl[] $urls */
  protected $urls;

  public function __construct(array $urls) {
    $this->urls = $urls;

    return $this;
  }

  /**
   * @param RedirectUrl[] $urls
   *
   * @return RedirectUrls
   */
  public static function List(array $urls) {
    return new RedirectUrls($urls);
  }

  public function getSingleRedirectUrl() {
    if (sizeof($this->urls) !== 1) {
      throw new IllegalStateException(
        "Calls to this method should only be done when there are no more than one (1) redirect URL.");
    }

    return $this->urls[0]->getUrl();
  }

  /**
   * Gets the redirect URL for a given signer.
   *
   * @param String $personalIdentificationNumber
   *
   * @return String
   * @see DirectJobResponse::getSingleRedirectUrl()
   */
  public function getFor(String $personalIdentificationNumber) {
    foreach ($this->urls as $redirectUrl) {
      if ($redirectUrl->getSigner() === $personalIdentificationNumber) {
        return $redirectUrl->getUrl();
      }
    }
    throw new \InvalidArgumentException("Unable to find redirect URL for this signer");
  }

  public function getAll() {
    return $this->urls;
  }
}
