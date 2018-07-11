<?php

namespace Digipost\Signature\Client\Direct;

use GuzzleHttp\Psr7\Uri;

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

  public static function ofUrl(String $statusUrl) {
    return new StatusUrlConstruction($statusUrl);
  }

  public function __construct(String $statusUrl, String $statusQueryToken) {
    $this->statusUrl = $statusUrl;
    $this->statusQueryToken = (isset($statusQueryToken) && isset(self::$STATUS_QUERY_TOKEN_PARAM_NAME)) ? $statusQueryToken : NULL;
  }

  public function getStatusUrl() {
    $uri = new Uri($this->statusUrl);
    return (string) Uri::withQueryValue($uri,
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
   * {@link DirectClient#getStatus(StatusReference)}.
   *
   * @param String $token
   *
   * @return \Digipost\Signature\Client\Direct\StatusReference
   */
  public function withStatusQueryToken(String $token): StatusReference {
    return new StatusReference($this->statusUrl, $token);
  }
}
