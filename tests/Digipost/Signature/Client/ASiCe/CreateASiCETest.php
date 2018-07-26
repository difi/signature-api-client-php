<?php
/**
 * Created by PhpStorm.
 * User: bendik
 * Date: 21.06.18
 * Time: 01:15
 */

namespace Tests\DigipostSignatureBundle\Client\ASiCe;


use Digipost\Signature\Client\ASiCe\CreateASiCE;
use Digipost\Signature\Client\ASiCe\DumpDocumentBundleToDisk;
use Digipost\Signature\Client\ASiCe\Manifest\CreateDirectManifest;
use Digipost\Signature\Client\ASiCe\Manifest\ManifestCreator;
use Digipost\Signature\Client\Core\DocumentFileType;
use Digipost\Signature\Client\Core\JOB;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Direct\DirectDocument;
use Digipost\Signature\Client\Direct\DirectJob;
use Digipost\Signature\Client\Direct\DirectSigner;
use Digipost\Signature\Client\Direct\ExitUrls;
use Digipost\Signature\Client\Portal\PortalDocument;
use Tests\DigipostSignatureBundle\Client\ClientBaseTestCase;

class CreateASiCETest extends ClientBaseTestCase {

  static $DIRECT_DOCUMENT;

  static $PORTAL_DOCUMENT;

  static $dumpFolder;

  public function setUp() {
    parent::setUp();

    self::$DIRECT_DOCUMENT = DirectDocument::builder(
      "Title",
      "file.txt",
      "hello"
    )
                                           ->message("Message")
                                           ->fileType(DocumentFileType::TXT())
                                           ->build();

    self::$PORTAL_DOCUMENT = PortalDocument::builder(
      "Title",
      "file.txt",
      "hello"
    )
                                           ->message("Message")
                                           ->fileType(DocumentFileType::TXT())
                                           ->build();

    $root_path = $this->getContainer()->getParameter('kernel.project_dir');
    self::$dumpFolder = $root_path . '/var/output';
  }

  public function testCreateASiCE() {
    $job = DirectJob::builder(
      self::$DIRECT_DOCUMENT,
      ExitUrls::singleExitUrl("https://job.well.done.org"),
      DirectSigner::withPersonalIdentificationNumber("12345678910")
                  ->build()
    )
                    ->withReference("direct job")
                    ->build();

    $this->create_document_bundle_and_dump_to_disk(
      new CreateDirectManifest(),
      $job
    );
  }


  private function create_document_bundle_and_dump_to_disk(
    ManifestCreator $manifestCreator,
    JOB $job
  ) {
    //$keyStore = $this->getContainer()->get('digipost_signature.keystore_config');
    $clientConfigBuilder = $this->getContainer()->get(
      'Digipost\Signature\Client\ClientConfigurationBuilder'
    );
    //$clientConfigBuilder = ClientConfiguration::builder(TestKonfigurasjon::$CLIENT_KEYSTORE);
    $clientConfig = $clientConfigBuilder->globalSender(new Sender("983163327"))
                                        ->enableDocumentBundleDiskDump(
                                          self::$dumpFolder
                                        )
                                        ->build();

    $aSiCECreator = new CreateASiCE($manifestCreator, $clientConfig);
    $aSiCECreator->createASiCE($job);

    $fileNames = [];
    $extractedFiles = [];
    try {
      $dumpedFiles = glob(
        self::$dumpFolder . '/*-' . DumpDocumentBundleToDisk::referenceFilenamePart(
          $job->getReference()
        ) . '*.zip'
      );
      $asiceFile = end($dumpedFiles);
      $asiceStream = zip_open($asiceFile);
      while ($zipEntry = zip_read($asiceStream)) {
        if (zip_entry_open($asiceStream, $zipEntry, "r")) {
          $fileNames[] = zip_entry_name($zipEntry);
          $contents = zip_entry_read($zipEntry, 2048);
          $extractedFiles[] = $contents;

          zip_entry_close($zipEntry);
        }
      }
      zip_close($asiceStream);
    } catch (\Exception $e) {
    }

    $this->assertContains($job->getDocument()->getFileName(), $fileNames);
    $this->assertContains('manifest.xml', $fileNames);
    $this->assertContains('META-INF/signatures.xml', $fileNames);

    foreach ($extractedFiles as $delta => $fileData) {
      print " -- " . $fileNames[$delta] . " ----\n";
      print $fileData;
      print "\n---------------------\n\n";
    }

  }
}
