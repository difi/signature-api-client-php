<?php
namespace Digipost\Signature\Client\Direct;

class ExitUrls implements WithExitUrls {

  /** @var String */
  protected $completionUrl;

  /** @var String */
  protected $rejectionUrl;

  /** @var String */
  protected $errorUrl;

  /**
   * A single exit url can be used if you do not need to separate resources for handling the
   * different outcomes of a direct job. This is simply a convenience factory method for
   * {@link \Digipost\Signature\Client\Direct\ExitUrls::of ExitUrls::of(String, String, String)}
   * with the same url given for all the arguments.
   *
   * @param String $url The url you want the user to be redirected to upon completing the signing
   *                    ceremony, regardless of its outcome
   *
   * @return ExitUrls
   */
  public static function singleExitUrl($url) {
    return ExitUrls::of($url, $url, $url);
  }

  /**
   * Specify the urls the user is will be redirected to for different outcomes of a signing
   * ceremony. When the user is redirected, the urls will have an appended query parameter
   * ({@link \Digipost\Signature\Client\Direct\StatusReference::$STATUS_QUERY_TOKEN_PARAM_NAME StatusReference::$STATUS_QUERY_TOKEN_PARAM_NAME}) which contains a token required to {@link \Digipost\Signature\Client\Direct\DirectClient::getStatus DirectClient#getStatus(StatusReference) query for the status of the job}.
   *
   * @param String $completionUrl the user will be redirected to this url after having successfully
   *                              signed the document.
   * @param String $rejectionUrl  the user will be redirected to this url if actively rejecting to
   *                              sign the document.
   * @param String $errorUrl      the user will be redirected to this url if any unexpected error
   *                              happens during the signing ceremony.
   *
   * @return ExitUrls
   */
  public static function of(String $completionUrl, String $rejectionUrl, String $errorUrl) {
    return new ExitUrls($completionUrl, $rejectionUrl, $errorUrl);
  }

  public function __construct(String $completionUrl, String $rejectionUrl, String $errorUrl) {
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


