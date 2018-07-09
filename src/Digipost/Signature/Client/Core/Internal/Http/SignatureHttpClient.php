<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

interface SignatureHttpClient {

  function signatureServiceRoot();

  function target(String $uri);
}
