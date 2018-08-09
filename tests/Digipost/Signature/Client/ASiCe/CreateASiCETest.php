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
use Digipost\Signature\Client\ASiCe\Manifest\CreatePortalManifest;
use Digipost\Signature\Client\ASiCe\Manifest\ManifestCreator;
use Digipost\Signature\Client\Core\DocumentFileType;
use Digipost\Signature\Client\Core\JOB;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Direct\DirectDocument;
use Digipost\Signature\Client\Direct\DirectJob;
use Digipost\Signature\Client\Direct\DirectSigner;
use Digipost\Signature\Client\Direct\ExitUrls;
use Digipost\Signature\Client\Portal\NotificationsUsingLookup;
use Digipost\Signature\Client\Portal\PortalDocument;
use Digipost\Signature\Client\Portal\PortalJob;
use Digipost\Signature\Client\Portal\PortalSigner;
use Digipost\Signature\Client\Portal\TimeUnit;
use GoetasWebservices\XML\XSDReader\Schema\Exception\SchemaException;
use Tests\DigipostSignatureBundle\Client\ClientBaseTestCase;

class CreateASiCETest extends ClientBaseTestCase {

  /** @var DirectDocument */
  static $DIRECT_DOCUMENT;

  /** @var PortalDocument */
  static $PORTAL_DOCUMENT;

  /** @var \DateTime */
  static $clock;

  public function setUp() {
    parent::setUp();

    self::$DIRECT_DOCUMENT = DirectDocument::builder("Title", "file.txt", "hello")
                                           ->message("Message")
                                           ->fileType(DocumentFileType::TXT())
                                           ->build();

    self::$PORTAL_DOCUMENT = PortalDocument::builder("Title", "file.txt", "hello")
                                           ->message("Message")
                                           ->fileType(DocumentFileType::TXT())
                                           ->build();

    self::$clock = new \DateTime();
  }

  /**
   * @throws SchemaException
   */
  public function testCreateDirectASiCeAndWriteToDisk() {
    $job = DirectJob::builder(
      self::$DIRECT_DOCUMENT,
      ExitUrls::singleExitUrl("https://job.well.done.org"),
      DirectSigner::withPersonalIdentificationNumber("12345678910")->build()
    )
                    ->withReference("direct job")
                    ->build();

    $this->create_document_bundle_and_dump_to_disk(
      new CreateDirectManifest(),
      $job
    );
  }

  /**
   * @throws SchemaException
   */
  public function testCreatePortalASiCeAndWriteToDisk() {

    $job = PortalJob::builder(
      self::$PORTAL_DOCUMENT,
      PortalSigner::identifiedByPersonalIdentificationNumber(
        "12345678910", NotificationsUsingLookup::EMAIL_ONLY()
      )->build())
                    ->withReference("portal job")
                    ->withActivationTime(self::$clock)
                    ->availableFor(30, TimeUnit::DAYS())
                    ->build();

    $this->create_document_bundle_and_dump_to_disk(
      new CreatePortalManifest(self::$clock),
      $job
    );
  }

  /**
   * @param ManifestCreator $manifestCreator
   * @param JOB             $job
   *
   * @throws SchemaException
   */
  private function create_document_bundle_and_dump_to_disk(
    ManifestCreator $manifestCreator,
    JOB $job
  ) {
    $clientConfigBuilder = $this->getContainer()->get(
      'digipost_signature.client_configuration_builder'
    );
    $clientConfig = NULL;
    try {
      $clientConfig = $clientConfigBuilder
        ->globalSender(new Sender("983163327"))
        ->enableDocumentBundleDiskDump(
          self::$dumpFolder
        )
        ->usingClock(new \DateTime())
        ->build();
    } catch (\Exception $e) {
    }

    $aSiCECreator = new CreateASiCE($manifestCreator, $clientConfig);
    $aSiCECreator->createASiCE($job);

    $fileNames = [];
    $extractedFiles = [];

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
        $size = zip_entry_filesize($zipEntry);
        $contents = zip_entry_read($zipEntry, $size);
        $extractedFiles[] = $contents;

        zip_entry_close($zipEntry);
      }
    }
    zip_close($asiceStream);

    $this->assertContains($job->getDocument()->getFileName(), $fileNames);
    $this->assertContains('manifest.xml', $fileNames);
    $this->assertContains('META-INF/signatures.xml', $fileNames);
  }
}
