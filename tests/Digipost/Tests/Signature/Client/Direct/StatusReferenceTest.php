<?php

namespace Digipost\Signature\Client\Direct;

use PHPUnit\Framework\TestCase;

class StatusReferenceTest extends TestCase {

  function testBuildsCorrectUrlWithToken() {
    $statusUrl = "https://statusqueryservice/status/?job=1337";
    $token = "abcdefgh";
    $statusReference = StatusReference::ofUrl($statusUrl)
      ->withStatusQueryToken($token);
    $this->assertSame($statusUrl . "&" . StatusReference::$STATUS_QUERY_TOKEN_PARAM_NAME . "=" . $token,
                      $statusReference->getStatusUrl());
  }
}
