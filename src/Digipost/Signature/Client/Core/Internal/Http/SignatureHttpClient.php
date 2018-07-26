<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

interface SignatureHttpClient {

  /**
   * @return \GuzzleHttp\Client
   */
  function signatureServiceRoot();

  function target(String $uri);
}
