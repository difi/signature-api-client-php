<?php
/**
 * Created by PhpStorm.
 * User: bendik
 * Date: 21.06.18
 * Time: 01:18
 */

namespace Digipost\Signature\Client\ASiCe\Manifest;


use Digipost\Signature\Client\Core\DocumentFileType;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Direct\DirectDocument;
use Digipost\Signature\Client\Direct\DirectJob;
use Digipost\Signature\Client\Direct\DirectSigner;
use Digipost\Signature\Client\Direct\ExitUrls;
use Tests\DigipostSignatureBundle\Client\ClientBaseTestCase;

class CreateDirectManifestTest extends ClientBaseTestCase {

  public function testBuildXmlManifest() {
    $createManifest = new CreateDirectManifest();

    $document = "This is a text";
    $document = DirectDocument::builder(
      "Title", "file.txt",
      $document
    )
                              ->message("Message")
                              ->fileType(DocumentFileType::TXT())
                              ->build();

    $signer1 = DirectSigner::withPersonalIdentificationNumber("28129307058");

    $job = DirectJob::builder(
      $document, ExitUrls::of(
      "http://localhost/signed",
      "http://localhost/canceled",
      "http://localhost/failed"
    ),
      $signer1->build()
    )->build();

    try {
      $manifest = $createManifest->createManifest(
        $job,
        new Sender("991825827")
      );
      //$this->assertEquals("application/xml", $manifest->getMimeType());
      $bytes = $manifest->getBytes();

      //$bytes = $job->getDocument()->getBytes();
      //$manifest->
      print "\n----------\n";
      print $bytes;
      print "\n----------\n";
    } catch (\Exception $e) {
      $this->fail(
        "Expected no exception, got: " . get_class($e) . ' : ' . $e->getMessage(
        )
      );
    }
  }
}
