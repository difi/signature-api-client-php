<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

interface HttpIntegrationConfiguration {

  function getGuzzleConfiguration();

  function getSSLContext();

  function getServiceRoot();
}

