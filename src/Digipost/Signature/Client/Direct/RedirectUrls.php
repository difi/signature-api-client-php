<?php

namespace Digipost\Signature\Client\Direct;

use Digipost\Signature\API\XML\XMLSignerSpecificUrl;

class RedirectUrls {

  /** @var RedirectUrl[] $urls */
  protected $urls;

  public function __construct(array $urls) {
    $this->urls = $urls;
    return $this;
  }

  public static function List(array $urls) {
    return new RedirectUrls($urls);
  }

  public function getSingleRedirectUrl() {
    if (sizeof($this->urls) !== 1) {
      throw new \RuntimeException("Calls to this method should only be done when there are no more than one (1) redirect URL.");
    }
    return $this->urls[0]->getUrl();
  }

  public function getFor(String $personalIdentificationNumber) // [String personalIdentificationNumber]
  {
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

class RedirectUrl {

  private $signer;

  private $url;

  function __construct(String $signer, String $url) {
    $this->signer = $signer;
    $this->url = $url;
  }

  static function fromJaxb(XMLSignerSpecificUrl $xmlSignerSpecificUrl) {
    return new RedirectUrl($xmlSignerSpecificUrl->getSigner(),
                           $xmlSignerSpecificUrl->getValue());
  }

  public function getSigner(): String {
    return $this->signer;
  }

  public function getUrl(): String {
    return $this->url;
  }
}


