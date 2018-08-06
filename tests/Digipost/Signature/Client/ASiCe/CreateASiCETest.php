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
  }

  public function testCreateASiCE() {
    $job = DirectJob::builder(
      self::$DIRECT_DOCUMENT,
      ExitUrls::singleExitUrl("https://job.well.done.org"),
      DirectSigner::withPersonalIdentificationNumber("12345678910")->build()
    )
                    ->withReference("direct job")
                    ->build();

    /** @throws \Exception */
    $this->create_document_bundle_and_dump_to_disk(
      new CreateDirectManifest(),
      $job
    );
  }

  /**
   * @throws \Exception
   */
  public function testXmlSecSigning() {
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




  //    public function testXmlSec2Signing() {
  //    $clientConfigBuilder = $this->getContainer()->get(
  //      'Digipost\Signature\Client\ClientConfigurationBuilder'
  //    );
  //
  //    $path =
  //      '/home/difi/drupal7/profiles/samarbeid2lukket/signature-api-client-php/app/Resources/test/java';
  //    $filename = $path . '/META-INF/signatures_empty.xml';

  //$doc = DOMDocumentFactory::fromFile($filename);
  //$sigElement = $doc->getElementsByTagName('Signature')->item(0);

  //$signature = new Signature($sigElement->parentNode);
  //    $signature = new Signature($sigElement->C14N());

  //$signature = new Signature($sigElement->parentNode);
  //$signature->setCanonicalizationMethod(C::C14N_INCLUSIVE_WITHOUT_COMMENTS);
  //    $signature->setSignatureElement(
  //      $sigElement->getElementsByTagName('SignedInfo')->item(0)->parentNode
  //    );

  //$signature->setSignatureElement($signature->getRoot()->ownerDocument->documentElement->firstChild);
  //$signature->setIdNamespaces();
  //$signature->setBlacklistedAlgorithms([]);
  //$signature->setPrefix('ds');
  //$signature->setIdAttributes(['Id', 'default1' => 'ObjectReference', 'URI']);

  //$signature->setIdNamespaces()
  //$key = $clientConfig->getKeyStoreConfig()->getPrivateKey()->getXMLSecurityKey();
  //    $cert = new X509Certificate($key->getX509Certificate());
  //    $cert =
  //      new X509Certificate($clientConfig->getKeyStoreConfig()->getCertificate()->getClearText());
  //    $key = new \SimpleSAML\XMLSec\Key\PrivateKey(
  //      $clientConfig->getKeyStoreConfig()->getPrivateKey()->getEncoded('12345')
  //    );
  //    //$cert = \SimpleSAML\XMLSec\Key\X509Certificate::fromDetails('mod', 'exp');
  //    $signature->addX509Certificates($cert, FALSE, C::DIGEST_SHA1, FALSE);
  //
  //    $qualifyingProperties = DOMDocumentFactory::fromFile("$path/object.xml");
  //    //$sigElement->ownerDocument->importNode($qualifyingProperties->documentElement);
  //    $signature->addObject($qualifyingProperties->documentElement);
  //    //$signature->addObject($object->documentElement);
  //    $signature->setSignatureElement($signature->getRoot()->ownerDocument->getElementsByTagName('Signature')->item(0));
  //    //$node = $doc->getElementById('SignedProperties');
  //    //$node1 = $sigElement->childNodes->item(0)->childNodes->item(2);
  //    //$node2 = $sigElement->childNodes->item(0)->childNodes->item(3);
  //    //$node0 = $doc->getElementById('ID_0');
  //    //$signature->addReference($node1, C::DIGEST_SHA256);
  //    //$signature->addReference($node2, C::DIGEST_SHA256, [C::C14N_INCLUSIVE_WITHOUT_COMMENTS]);
  //    //$signature->addReference()
  //    //$signature->envelop();
  //    $object = $signature->getRoot();
  //    $root = $object->ownerDocument;
  //
  //    $signature->addReference(
  //      $root->getElementsByTagNameNS('http://uri.etsi.org/01903/v1.3.2#', 'SignedProperties')->item(
  //        0
  //      ), C::DIGEST_SHA256, [C::C14N_INCLUSIVE_WITHOUT_COMMENTS], [
  //        //      'prefix_ns' => 'http://uri.etsi.org/01903/v1.3.2#',
  //        'force_uri' => FALSE,
  //        'overwrite' => FALSE,
  //        //'id_name'   => 'Id',
  //      ]
  //    );
  //
  //    $signedDataObjectProperties = $root->documentElement->getElementsByTagNameNS(
  //      'http://uri.etsi.org/01903/v1.3.2#', 'SignedDataObjectProperties'
  //    )->item(0)->getElementsByTagNameNS('http://uri.etsi.org/01903/v1.3.2#', 'DataObjectFormat');
  //    //$childObjects = $signedDataObjectProperties->childNodes;
  //    foreach ($signedDataObjectProperties as $id => $ref) {
  //      /** @var $ref \DOMElement */
  //
  //      //$signature->addObject($ref->C14N());
  ////      $signature->addReference(
  ////        $ref, C::DIGEST_SHA256, [], [
  //////          'id_name' => 'ObjectReference',
  ////          'force_uri' => FALSE,
  //////          'overwrite' => FALSE,
  ////          ]
  ////      );
  //    }
  //
  //
  //    $signature->sign($key, C::SIG_RSA_SHA256, TRUE);
  //
  //    print $root->C14N();
  //    exit;
  //
  //    $root->formatOutput = FALSE;
  //    $root->preserveWhiteSpace = FALSE;
  //    print $root->saveXML($sigElement->ownerDocument);
  //    //print $object->saveXML($object->ownerDocument);
  //
  //    print "\n";
  //
  //    exit;
  //  }

  private function create_document_bundle_and_dump_to_disk(
    ManifestCreator $manifestCreator,
    JOB $job
  ) {
    //$keyStore = $this->getContainer()->get('digipost_signature.keystore_config');

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

    //    try {
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
    //    } catch (\Exception $e) {
    //    }

    $this->assertContains($job->getDocument()->getFileName(), $fileNames);
    $this->assertContains('manifest.xml', $fileNames);
    $this->assertContains('META-INF/signatures.xml', $fileNames);

    //    $files = [];
    //    foreach ($extractedFiles as $delta => $fileData) {
    //      //print " -- " . $fileNames[$delta] . " ----\n";
    //      //      print $fileData;
    //      //      print "\n---------------------\n\n";
    //      $key = $fileNames[$delta];
    //      $files[$key] = $fileData;
    //    }
    //
    //    $doc = new \DOMDocument();
    //    $doc->load(__DIR__ . '/asice-test.xml');
    //    //$doc->loadXML($files['manifest.xml']);
    //
    //    // Create a new Security object
    //    $objDSig = new XMLSecurityDSig('ds');
    //    $objDSig->setCanonicalMethod(C::C14N_INCLUSIVE_WITHOUT_COMMENTS);
    //
    //    if ($sigNode = $objDSig->locateSignature($doc)) {
    //      //print $doc->saveXML($sigNode);
    //    }
    //    if ($keyNode = $objDSig->locateKey($doc->getElementsByTagName('KeyInfo')->item(0))) {
    //      print "GOT KEY";
    //    }
    //
    //    $passphrase = $this->getContainer()->getParameter('digipost_signature.keystore.key.password');
    //    $keyStore = $this->getContainer()->get('digipost_signature.keystore_config');
    //    $key_pem = $keyStore->getPrivateKey()->getEncoded($passphrase);
    //    $file_cert = $this->getContainer()->getParameter('digipost_signature.keystore.client_cert');
    //    // Create a new (private) Security key
    //    $privateKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, ['type' => 'private']);
    //    $privateKey->passphrase = $passphrase;
    //    $privateKey->loadKey($keyStore->getPrivateKey()->getEncoded($passphrase), FALSE);
    //    //
    //
    //    //$objDSig->add509Cert(file_get_contents($file_cert));
    //    $objDSig->appendKey($privateKey, $sigNode);
    //    //$objDSig->appendCert();
    //
    //    print $doc->saveXML();

    // Sign
    //$objDSig->sign($privateKey);

    // Add the associated public key to the signature
    //$objDSig->add509Cert(file_get_contents($file_cert));

    // Append the signature to the XML
    //$objDSig->appendSignature($doc->documentElement);

    //print $doc->save(__DIR__ . '/../../../../Resources/test.xml');
    /*
    $privKey = new PrivateKey($key_pem, $passphrase);

    //$doc = DOMDocumentFactory::fromString($files['manifest.xml']);
    //$doc = new XMLSecurityDSig();

    $signature = new Signature($dsig);
    $signature->addReference(
      $doc->documentElement,
      C::DIGEST_SHA1,
      [C::XMLDSIG_ENVELOPED],
      ['overwrite' => FALSE]
    );
    $signature->setBlacklistedAlgorithms([]);
    $signature->sign($privKey, C::SIG_RSA_SHA1);
    $signature->envelop();
    $object = $signature->getRoot();
    print $signature->getSignatureMethod();
    */
  }

}
