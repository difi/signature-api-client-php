<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

use Digipost\Signature\Client\ClientConfiguration;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri as URI;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SignatureHttpClientFactory {

  public static function create(ClientConfiguration $config) {
    $params = $config->getGuzzleConfiguration();
    $guzzleClient = new Client($params);
    $client = new DefaultClient($guzzleClient, $config->getServiceRoot(), $config->getContainer());

    //$client->setContainer($config->getContainer());
    return $client;
  }
}

class DefaultClient implements SignatureHttpClient {

  /**
   * @var ContainerInterface
   */
  protected $container;

  private $guzzleClient;

  /**
   * @var Client
   */
  private $_signatureServiceRoot;

  function __construct(Client $guzzleClient, URI $root, ContainerInterface $container) {
    $this->guzzleClient = $guzzleClient;
    $this->_signatureServiceRoot = $this->target($root);
    $this->setContainer($container);
  }

  public function getContainer() {
    return $this->container;
  }

  public function target(String $uri): Client {
    $config = $this->guzzleClient->getConfig();
    $config['base_uri'] = $uri;

    $client = new Client($config);

    return $client;
  }

  public function signatureServiceRoot(): Client {
    return $this->_signatureServiceRoot;
  }

  public function setContainer(ContainerInterface $container) {
    $this->container = $container;
  }
}

