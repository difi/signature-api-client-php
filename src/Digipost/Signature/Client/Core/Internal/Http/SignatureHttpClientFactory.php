<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

use Digipost\Signature\Client\ClientConfiguration;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri as URI;

class SignatureHttpClientFactory {

  public static function create(ClientConfiguration $config
  ) // [HttpIntegrationConfiguration config]
  {
    $params = $config->getGuzzleConfiguration();
    $guzzleClient = new Client($params);
    return new DefaultClient($guzzleClient, $config->getServiceRoot());
  }
}

class DefaultClient implements SignatureHttpClient {

  private $guzzleClient;

  /**
   * @var Client
   */
  private $_signatureServiceRoot;

  function __construct(Client $guzzleClient, URI $root) {

    $this->guzzleClient = $guzzleClient;
    $this->_signatureServiceRoot = $this->target($root);
  }

  /**
   * @param String $uri
   *
   * @return Client
   */
  public function target(String $uri) {
    $config = $this->guzzleClient->getConfig();
    $config['base_uri'] = $uri;
    return new Client($config);
  }

  /**
   * @return Client
   */
  public function signatureServiceRoot() {
    return $this->_signatureServiceRoot;
  }

}

