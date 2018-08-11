<?php
namespace Tests\DigipostSignatureBundle\Client\Portal;

use Digipost\Signature\Client\Portal\Notifications;
use Digipost\Signature\Client\Portal\PortalSigner;
use Tests\DigipostSignatureBundle\Client\ClientBaseTestCase;

class PortalSignerTest extends ClientBaseTestCase {

  public function testGetPersonalIdentificationNumber() {

    $portalSigner = PortalSigner::identifiedByPersonalIdentificationNumber(
      '01013300001',
      Notifications::builder()
                   ->withEmailTo('email@example.com')
                   ->build()
    )->build();

    $this->assertSame('01013300001', $portalSigner->getIdentifier());
    $this->assertTrue($portalSigner->isIdentifiedByPersonalIdentificationNumber());
  }

  public function testGetEmailCustomIdentifier() {
    $portalSigner = PortalSigner::identifiedByEmail('email@example.com')->build();

    $this->assertSame('email@example.com', $portalSigner->getNotifications()->getEmailAddress());
    $this->assertTrue($portalSigner->getNotifications()->shouldSendEmail());
    $this->assertFalse($portalSigner->isIdentifiedByPersonalIdentificationNumber());

  }

  public function testGetMobileNumberCustomIdentifier() {
    $portalSigner = PortalSigner::identifiedByMobileNumber('12345678')->build();

    $this->assertSame('12345678', $portalSigner->getNotifications()->getMobileNumber());
    $this->assertTrue($portalSigner->getNotifications()->shouldSendSms());
    $this->assertFalse($portalSigner->isIdentifiedByPersonalIdentificationNumber());
  }

  public function testGetEmailAndMobileNumberCustomIdentifier() {
    $portalSigner =
      PortalSigner::identifiedByEmailAndMobileNumber('email@example.com', '12345678')->build();

    $this->assertSame('email@example.com', $portalSigner->getNotifications()->getEmailAddress());
    $this->assertTrue($portalSigner->getNotifications()->shouldSendEmail());
    $this->assertSame('12345678', $portalSigner->getNotifications()->getMobileNumber());
    $this->assertTrue($portalSigner->getNotifications()->shouldSendSms());
    $this->assertFalse($portalSigner->isIdentifiedByPersonalIdentificationNumber());
  }
}
