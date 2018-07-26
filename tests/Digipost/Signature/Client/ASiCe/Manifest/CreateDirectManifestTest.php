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
use PHPUnit\Framework\TestCase;

class CreateDirectManifestTest extends TestCase {

  private static function strToByteArray($str) {
    return unpack('C*', $str);
  }

  private static function byteArrayToString($byteArray) {
    return call_user_func_array('pack', array_merge(['C*'], $byteArray));
  }

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
    //$signer1 = DirectSigner::withCustomIdentifier('Bendik Brenne sin');
    //$signer1->withSignatureType(SignatureType::AUTHENTICATED_SIGNATURE());
    //$signer1->onBehalfOf(OnBehalfOf::SELF());
    //$signers = [$signer1->build()];

    $job = DirectJob::builder(
      $document, ExitUrls::of(
      "http://localhost/signed",
      "http://localhost/canceled",
      "http://localhost/failed"
    ),
      $signer1->build()
    )
      //->requireAuthentication(\Digipost\Signature\Client\Core\AuthenticationLevel::THREE())
      //->withIdentifierInSignedDocuments(IdentifierInSignedDocuments::NAME())
                    ->build();

    //    $naming_strategy = new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(
    //      new \JMS\Serializer\Naming\CamelCaseNamingStrategy('-')
    //    );
    //
    //    $xmlNode = new \DOMDocument('1.0', 'UTF-8');
    //    $xmlNode->xmlStandalone = TRUE;
    //    Marshalling::marshal($job, $xmlNode, NULL, $naming_strategy);
    //    print $xmlNode->saveXML();


    //$this->assertEquals("This is a text", $job->getDocument()->getBytes());
    //$this->assertEquals('http://localhost/failed', $job->getErrorUrl());

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
