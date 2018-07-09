<?php
/**
 * Created by PhpStorm.
 * User: bendik
 * Date: 21.06.18
 * Time: 01:15
 */

namespace Digipost\Signature\Client\ASiCe;


use Digipost\Signature\Client\ASiCe\Manifest\CreateDirectManifest;
use Digipost\Signature\Client\ASiCe\Manifest\ManifestCreator;
use Digipost\Signature\Client\ClientConfiguration;
use Digipost\Signature\Client\Core\DocumentFileType;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Direct\DirectDocument;
use Digipost\Signature\Client\Direct\DirectJob;
use Digipost\Signature\Client\Direct\DirectSigner;
use Digipost\Signature\Client\Direct\ExitUrls;
use Digipost\Signature\Client\Portal\PortalDocument;
use Digipost\Signature\Client\TestKonfigurasjon;
use PHPUnit\Framework\TestCase;

class CreateASiCETest extends TestCase {

  static $DIRECT_DOCUMENT;

  static $PORTAL_DOCUMENT;

  static $dumpFolder = '';

  public static function __staticInit() {
    self::$DIRECT_DOCUMENT = DirectDocument::builder("Title",
                                                     "file.txt",
                                                     "hello")
      ->message("Message")
      ->fileType(DocumentFileType::TXT())
      ->build();

    self::$PORTAL_DOCUMENT = PortalDocument::builder("Title",
                                                     "file.txt",
                                                     "hello")
      ->message("Message")
      ->fileType(DocumentFileType::TXT())
      ->build();
  }

  public function testCreateASiCE() {
    $job = DirectJob::builder(self::$DIRECT_DOCUMENT,
                              ExitUrls::singleExitUrl("https://job.well.done.org"),
                              DirectSigner::withPersonalIdentificationNumber("12345678910")
                                ->build())
      ->withReference("direct job")
      ->build();

    $this->create_document_bundle_and_dump_to_disk(new CreateDirectManifest(), $job);
  }


  private function create_document_bundle_and_dump_to_disk(ManifestCreator $manifestCreator,
                                                           $job) {


    $clientConfigBuilder = ClientConfiguration::builder(TestKonfigurasjon::$CLIENT_KEYSTORE);
    $clientConfig = $clientConfigBuilder->globalSender(new Sender("123456789"))
      ->enableDocumentBundleDiskDump(self::$dumpFolder)
      ->build();

    $aSiCECreator = new CreateASiCE($manifestCreator, $clientConfig);
    $aSiCECreator->createASiCE($job);

    $asiceFile = "";
    try {
      //$dumpedFileStream = newDirectoryStream($dumpFolder, "*-" + referenceFilenamePart.apply(job.getReference()) + "*.zip")
      //asiceFile = dumpedFileStream.iterator().next();
    } catch (\Exception $e) {
    }

    $fileNames = [];
    try {
//      $asiceStream = Files . newInputStream(asiceFile);
//      $uncompressed = new ZipInputStream(asiceStream);
//      for ($entry = $uncompressed->getNextEntry(); $entry != NULL; $entry = $uncompressed->getNextEntry()) {
//        fileNames.add(entry.getName());
//      }
    } catch (\Exception $e) {
    }
//        assertThat(fileNames, hasItem(job.getDocument().getFileName()));
//        assertThat(fileNames, hasItem("manifest.xml"));
//        assertThat(fileNames, hasItem("META-INF/signatures.xml"));
  }
}

CreateASiCETest::__staticInit();