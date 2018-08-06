<?php

namespace Digipost\Signature\Client\Direct;

use GuzzleHttp\Psr7\Uri;

/**
 * A `StatusReference` is constructed from the url acquired from
 * {@link DirectJobResponse::getStatusUrl()}, and a token provided as a
 * {@link ::$STATUS_QUERY_TOKEN_PARAM_NAME query parameter} which is
 * added to the {@link ExitUrls exit URL} the signer is redirected to when
 * the signing ceremony is completed/aborted/failed.
 *
 * The token needs to
 * be consumed by the system the user is redirected to, and consequently provided to
 * {@link StatusUrlConstruction::withStatusQueryToken()} to be able to construct a valid
 * complete `StatusReference` which is passed to {@link DirectClient::getStatus()}
 *
 * @package Digipost\Signature\Client\Direct
 */
class StatusReference {

  public static $STATUS_QUERY_TOKEN_PARAM_NAME = "status_query_token";

  protected $statusUrl;

  protected $statusQueryToken;

  /**
   * @param DirectJobResponse $response
   *
   * @return StatusUrlConstruction
   */
  public static function of(DirectJobResponse $response) {
    return StatusReference::ofUrl($response->getStatusUrl());
  }

  /**
   * Start constructing a new {@link StatusReference}.
   *
   * @param String $statusUrl the status url for the job
   *
   * @return StatusUrlConstruction partially constructed {@link StatusReference} which
   *         must be completed with a status query token using
   *         {@link StatusUrlConstruction::withStatusQueryToken #withStatusQueryToken(token)}
   */
  public static function ofUrl(String $statusUrl) {
    return new StatusUrlConstruction($statusUrl);
  }

  public function __construct(String $statusUrl, String $statusQueryToken) {
    $this->statusUrl = $statusUrl;
    $this->statusQueryToken = (isset($statusQueryToken) &&
      isset(self::$STATUS_QUERY_TOKEN_PARAM_NAME)) ? $statusQueryToken : NULL;
  }

  public function getStatusUrl() {
    $uri = new Uri($this->statusUrl);

    return (string) Uri::withQueryValue(
      $uri,
      self::$STATUS_QUERY_TOKEN_PARAM_NAME,
      $this->statusQueryToken);
  }
}

class StatusUrlConstruction {

  protected $statusUrl;

  function __construct($statusUrl) {
    $this->statusUrl = $statusUrl;
  }

  /**
   * Create a complete {@link StatusReference} which can be passed to
   * {@link DirectClient::getStatus()}.
   *
   * @param String $token The status query token.
   *
   * @return StatusReference
   */
  public function withStatusQueryToken(String $token): StatusReference {
    return new StatusReference($this->statusUrl, $token);
  }
}
