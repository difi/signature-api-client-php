<?php

namespace Tests\DigipostSignatureBundle\Client\ASiCe\Manifest;

use Digipost\Signature\Client\ASiCe\Manifest\CreatePortalManifest;
use Digipost\Signature\Client\Core\DocumentFileType;
use Digipost\Signature\Client\Core\IdentifierInSignedDocuments;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Portal\NotificationsUsingLookup;
use Digipost\Signature\Client\Portal\PortalDocument;
use Digipost\Signature\Client\Portal\PortalJob;
use Digipost\Signature\Client\Portal\PortalSigner;
use Digipost\Signature\Client\Portal\TimeUnit;
use Tests\DigipostSignatureBundle\Client\ClientBaseTestCase;

class CreatePortalManifestTest extends ClientBaseTestCase {

  private static $clock;

  public function setUp() {
    parent::setUp();

    self::$clock = new \DateTime();
  }

  public function testAcceptValidManifest() {
    $createManifest = new CreatePortalManifest(self::$clock);

    $document = PortalDocument::builder('Title', 'file.txt', 'hello')
                              ->message('Message')
                              ->fileType(DocumentFileType::TXT())
                              ->build();

    $job = PortalJob::builder(
      $document, PortalSigner::identifiedByPersonalIdentificationNumber(
      '12345678910', NotificationsUsingLookup::EMAIL_ONLY())->build())
                    ->withActivationTime(self::$clock)
                    ->availableFor(30, TimeUnit::DAYS())
                    ->withIdentifierInSignedDocuments(
                      IdentifierInSignedDocuments::PERSONAL_IDENTIFICATION_NUMBER_AND_NAME())
                    ->build();
    try {
      $createManifest->createManifest($job, new Sender('123456789'));


    } catch (\Exception $e) {
      $this->fail('Expected no exception, got: ' . $e->getMessage());
    }
  }
}