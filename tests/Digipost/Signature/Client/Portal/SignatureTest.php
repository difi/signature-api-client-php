<?php
namespace Tests\DigipostSignatureBundle\Client\Portal;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Digipost\Signature\API\XML\XMLEmail;
use Digipost\Signature\API\XML\XMLNotifications;
use Digipost\Signature\API\XML\XMLSms;
use Digipost\Signature\Client\Portal\SignerIdentifier;
use Digipost\Signature\Client\Portal\Signer;

class SignatureTest extends KernelTestCase {

  public function testAllKindsOfSignersCanBeIdentifiedByASignerIdentifier() {
    $pinSigner = new Signer("00000000000", null);
    $emailSigner = new Signer(null, new XMLNotifications(new XMLEmail("email@example.com"), null));
    $smsSigner = new Signer(null, new XMLNotifications(null, new XMLSms("11111111")));
    $emailAndSmsSigner = new Signer(null, new XMLNotifications(new XMLEmail("email@example.com"), new XMLSms("11111111")));

    $this->assertTrue($pinSigner->isSameAs(SignerIdentifier::identifiedByPersonalIdentificationNumber("00000000000")));
    $this->assertFalse($pinSigner->isSameAs(SignerIdentifier::identifiedByPersonalIdentificationNumber("11111111111")));
    $this->assertFalse($pinSigner->isSameAs(SignerIdentifier::identifiedByEmailAddress("test@example.com")));

    $this->assertTrue($emailSigner->isSameAs(SignerIdentifier::identifiedByEmailAddress("email@example.com")));
    $this->assertFalse($emailSigner->isSameAs(SignerIdentifier::identifiedByEmailAddress("other@example.com")));
    $this->assertFalse($emailSigner->isSameAs(SignerIdentifier::identifiedByEmailAddressAndMobileNumber("email@example.com", "11111111")));

    $this->assertTrue($smsSigner->isSameAs(SignerIdentifier::identifiedByMobileNumber("11111111")));
    $this->assertFalse($smsSigner->isSameAs(SignerIdentifier::identifiedByMobileNumber("22222222")));
    $this->assertFalse($smsSigner->isSameAs(SignerIdentifier::identifiedByEmailAddressAndMobileNumber("email@example.com", "11111111")));

    $this->assertTrue($emailAndSmsSigner->isSameAs(SignerIdentifier::identifiedByEmailAddressAndMobileNumber("email@example.com", "11111111")));
    $this->assertFalse($emailAndSmsSigner->isSameAs(SignerIdentifier::identifiedByEmailAddressAndMobileNumber("other@example.com", "11111111")));
    $this->assertFalse($emailAndSmsSigner->isSameAs(SignerIdentifier::identifiedByEmailAddressAndMobileNumber("email@example.com", "00000000")));
    $this->assertFalse($emailAndSmsSigner->isSameAs(SignerIdentifier::identifiedByEmailAddress("email@example.com")));
    $this->assertFalse($emailAndSmsSigner->isSameAs(SignerIdentifier::identifiedByMobileNumber("11111111")));
  }
}
