<?php
namespace Digipost\Signature\Client\Direct;

class ExitUrls implements WithExitUrls {

  protected $completionUrl;  // String

  protected $rejectionUrl;  // String

  protected $errorUrl;  // String

  public static function singleExitUrl($url) // [String url]
  {
    return ExitUrls::of($url, $url, $url);
  }

  public static function of($completionUrl, $rejectionUrl, $errorUrl) // [String completionUrl, String rejectionUrl, String errorUrl]
  {
    return new ExitUrls($completionUrl, $rejectionUrl, $errorUrl);
  }

  public function __construct($completionUrl, $rejectionUrl, $errorUrl) // [String completionUrl, String rejectionUrl, String errorUrl]
  {
    $this->completionUrl = $completionUrl;
    $this->rejectionUrl = $rejectionUrl;
    $this->errorUrl = $errorUrl;
    return $this;
  }

  public function getCompletionUrl() {
    return $this->completionUrl;
  }

  public function getRejectionUrl() {
    return $this->rejectionUrl;
  }

  public function getErrorUrl() {
    return $this->errorUrl;
  }
}


