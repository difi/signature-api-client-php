<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

use GuzzleHttp\Client;

interface SignatureHttpClient {

  function signatureServiceRoot(): Client;

  function target(String $uri): Client;
}
