<?php

namespace Tests\DigipostSignatureBundle\Client;

use Digipost\Signature\Client\ClientConfiguration;
use Digipost\Signature\Client\ClientConfigurationBuilder;
use Digipost\Signature\Client\ClientMetadata;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ClientConfigurationTest extends KernelTestCase {

  /** @var ClientConfigurationBuilder */
  private $config;

  public function setUp() {
    parent::setUp();
    static::$kernel = static::createKernel();
    static::$kernel->boot();

    $container = static::$kernel->getContainer();
    $this->config = ClientConfiguration::builder($container, TestKonfigurasjon::CLIENT_KEYSTORE());
  }

  public function testKeyStoreCertificateDetails() {
    $config = $this->config->build();
    $cert = $config->getKeyStoreConfig()->getCertificate()->toXmlSecLibCertificate();
    $details = $cert->getCertificateDetails();
    $this->assertSame('589725471', $details['serialNumber']);
    $this->assertSame('Avsender', $details['subject']['CN']);
  }

  public function testGivesDefaultUserAgent() {
    $userAgentString = $this->config->createUserAgentString();
    $this->assertSame(ClientConfiguration::$MANDATORY_USER_AGENT, $userAgentString);
    $this->assertContains(ClientMetadata::$VERSION, $userAgentString);
  }

  public function testAppendsCustomUserAgentAfterDefault() {
    $userAgentString = $this->config
      ->includeInUserAgent("My Corporation")
      ->createUserAgentString();
    $this->assertStringStartsWith(ClientConfiguration::$MANDATORY_USER_AGENT, $userAgentString);
    $this->assertContains(ClientMetadata::$VERSION, $userAgentString);
    $this->assertContains("My Corporation", $userAgentString);
  }
}
