<?php
/**
 * Created by PhpStorm.
 * User: bendik
 * Date: 22.06.18
 * Time: 05:55
 */

namespace Digipost\Signature\Client\ASiCe\Signature;

use Digipost\Signature\Client\ClientConfiguration;
use Digipost\Signature\Client\Core\DocumentFileType;
use Digipost\Signature\Client\Core\IdentifierInSignedDocuments;
use Digipost\Signature\Client\Core\OnBehalfOf;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Core\SignatureType;
use Digipost\Signature\Client\Direct\DirectClient;
use Digipost\Signature\Client\Direct\DirectDocument;
use Digipost\Signature\Client\Direct\DirectJob;
use Digipost\Signature\Client\Direct\DirectSigner;
use Digipost\Signature\Client\Direct\ExitUrls;
use Digipost\Signature\Client\Direct\StatusRetrievalMethod;
use Digipost\Signature\Client\TestKonfigurasjon;
use PHPUnit\Framework\TestCase;

class CreateSignatureTest extends TestCase {

  static $dumpFolder = '/tmp';


  private static function strToByteArray($str) {
    return unpack('C*', $str);
  }

  private static function byteArrayToString($byteArray) {
    return call_user_func_array('pack', array_merge(['C*'], $byteArray));
  }

  public function setUp() {
    self::$dumpFolder = realpath(
      dirname(realpath(PHPUNIT_COMPOSER_INSTALL)) . '/../output'
    );
  }

  public function testCreateSignature() {
    $clientConfigBuilder = ClientConfiguration::builder(
      TestKonfigurasjon::$CLIENT_KEYSTORE
    );
    $clientConfig = $clientConfigBuilder->globalSender(new Sender("991825827"))
                                        ->enableDocumentBundleDiskDump(
                                          self::$dumpFolder
                                        )
                                        ->build();

    $client = new DirectClient($clientConfig);

    //$document = self::strToByteArray("This is a text");
    $document = "This is a text";
    $document = DirectDocument::builder(
      "Title", "file.txt",
      $document
    )
                              ->message("Message")
                              ->fileType(DocumentFileType::TXT())
                              ->build();

    $signer1 = DirectSigner::withCustomIdentifier('Bendik Brenne sin')
                           ->withSignatureType(
                             SignatureType::AUTHENTICATED_SIGNATURE()
                           )
                           ->onBehalfOf(OnBehalfOf::OTHER());
    //$signers = [$signer1->build()];
    $directJob = DirectJob::builder(
      $document,
      ExitUrls::of(
        "http://localhost/signed",
        "http://localhost/canceled",
        "http://localhost/failed"
      ),
      $signer1->build()
    )
                          ->withReference('123-ABC')
                          ->withIdentifierInSignedDocuments(
                            IdentifierInSignedDocuments::NAME()
                          )
                          ->retrieveStatusBy(
                            StatusRetrievalMethod::WAIT_FOR_CALLBACK()
                          )
                          ->build();
    $client->create($directJob);
  }
}
