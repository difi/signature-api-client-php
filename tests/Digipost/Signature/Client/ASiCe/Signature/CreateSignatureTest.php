<?php
/**
 * Created by PhpStorm.
 * User: bendik
 * Date: 22.06.18
 * Time: 05:55
 */

namespace Tests\DigipostSignatureBundle\Client\ASiCe\Signature;

use Digipost\Signature\Client\Core\AuthenticationLevel;
use Digipost\Signature\Client\Core\DocumentFileType;
use Digipost\Signature\Client\Core\IdentifierInSignedDocuments;
use Digipost\Signature\Client\Core\Internal\Security\Constants as C;
use Digipost\Signature\Client\Core\Internal\Security\Signature;
use Digipost\Signature\Client\Core\OnBehalfOf;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Core\SignatureType;
use Digipost\Signature\Client\Direct\DirectClient;
use Digipost\Signature\Client\Direct\DirectDocument;
use Digipost\Signature\Client\Direct\DirectJob;
use Digipost\Signature\Client\Direct\DirectJobResponse;
use Digipost\Signature\Client\Direct\DirectJobStatusResponse;
use Digipost\Signature\Client\Direct\DirectSigner;
use Digipost\Signature\Client\Direct\ExitUrls;
use Digipost\Signature\Client\Direct\RedirectUrl;
use Digipost\Signature\Client\Direct\StatusReference;
use Digipost\Signature\Client\Direct\StatusRetrievalMethod;
use Digipost\Signature\Client\Portal\PortalClient;
use Digipost\Signature\Client\Portal\PortalDocument;
use Digipost\Signature\Client\Portal\PortalJob;
use Digipost\Signature\Client\Portal\PortalJobResponse;
use Digipost\Signature\Client\Portal\PortalSigner;
use Digipost\Signature\Client\Portal\TimeUnit;
use Digipost\Signature\Client\ServiceUri;
use SimpleSAML\XMLSec\Key\PrivateKey;
use SimpleSAML\XMLSec\Key\X509Certificate;
use SimpleSAML\XMLSec\Utils\DOMDocumentFactory;
use Tests\DigipostSignatureBundle\Client\ClientBaseTestCase;

class CreateSignatureTest extends ClientBaseTestCase {

  private static $root_dir;
  private $privKey;
  private $cert;

  public function setUp() {
    parent::setUp();
    self::$root_dir = $this->getContainer()->getParameter('kernel.project_dir');

    $this->privKey =
      PrivateKey::fromFile(self::$root_dir . '/vendor/simplesamlphp/xmlseclibs/tests/privkey.pem');
    //$this->cert = X509Certificate::fromFile(self::$root_dir . '/vendor/simplesamlphp/xmlseclibs/tests/mycert.pem');
    $this->cert = X509Certificate::fromFile(self::$root_dir . '/app/Resources/config/smt_test.cer');
  }

  public function testWithXMLSecLibsSignature() {
    $doc = DOMDocumentFactory::fromString(
      '<XAdESSignatures xmlns="http://uri.etsi.org/2918/v1.2.1#">' .
      '<Signature xmlns="http://www.w3.org/2000/09/xmldsig#" Id="Signature">' .
      '<SignedInfo>' .
      '<CanonicalizationMethod Algorithm="' . C::C14N_INCLUSIVE_WITHOUT_COMMENTS . '"/>' .
      '<SignatureMethod Algorithm="' . C::SIG_RSA_SHA256 . '"/>' .
      '</SignedInfo>' .
      '<Object>' .
      '<QualifyingProperties xmlns="' . C::XADESNS . '" xmlns:ns2="' . C::XMLDSIGNS .
      '" Target="#Signature"/>' .
      '</Object>' .
      '</Signature>' .
      '</XAdESSignatures>'
    );
    //$doc = DOMDocumentFactory::create();
    //$root = $doc->appendChild($doc->createElementNS(C::ASICENS, 'XAdESSignatures'));
    //$root->appendChild($doc->createElementNS(C::ASICENS, 'Signature'));
    $signature = Signature::fromXML($doc->documentElement);
    $signature->setBlacklistedAlgorithms([]);

    $fileData = file_get_contents(
      self::$root_dir . '/vendor/simplesamlphp/xmlseclibs/tests/asice-files/document1.pdf');
    $signature->addSignedDataObjectFormat('ID_0', 'document1.pdf', 'application/pdf', $fileData);
    $fileData = file_get_contents(
      self::$root_dir . '/vendor/simplesamlphp/xmlseclibs/tests/asice-files/manifest.xml');
    $signature->addSignedDataObjectFormat('ID_1', 'manifest.xml', 'application/xml', $fileData);

    $spNode = $signature->getSignedPropertiesNode();
    $signature->addReference(
      $spNode, C::DIGEST_SHA256, [C::C14N_INCLUSIVE_WITHOUT_COMMENTS], [
      'overwrite' => FALSE,
      'type'      => C::REF_TYPE_SIGNED_PROPERTIES,
    ]);

    //    print $signature->getRoot()->C14N(false, false);
    $signature->addX509Certificates($this->cert, FALSE, C::DIGEST_SHA1, TRUE);
    //$node = $signature->insert();
    $signature->sign($this->privKey, C::SIG_RSA_SHA256, TRUE);

    $node = $signature->getRoot();
    $xml = $node->ownerDocument->C14N(FALSE, FALSE);
    print $xml;
  }

  /**
   * @throws \Exception
   */
  public function testDirectSignatureStatus() {
    $clientConfigBuilder = $this->getContainer()->get(
      'digipost_signature.client_configuration_builder'
    );
    $clientConfig = $clientConfigBuilder->globalSender(new Sender("991825827"))
                                        ->serviceUri(ServiceUri::DIFI_TEST())
                                        ->enableDocumentBundleDiskDump(
                                          self::$dumpFolder
                                        )
                                        ->build();

    $statusQueryToken = 'bjv8Q5vJsN9_0BZeOLX1o9GZJi7r_HHGkwACf5p0TPw';
    $redirectUrl = 'https://difitest.signering.posten.no/signere/#/-/ic74KVpCcBf0R_6vMwRxiXwmfRo5PBF3zmuOPUz_LxE';
    $statusUrl = 'https://api.difitest.signering.posten.no/api/991825827/direct/signature-jobs/12106/status';
    $jobId = 12106;

    $client = new DirectClient($clientConfig);
    $directJobResponse = new DirectJobResponse(
      $jobId, 'test-job', [
      new RedirectUrl(
        '28129307058',
        $redirectUrl),
    ], 'https://api.difitest.signering.posten.no/api/991825827/direct/signature-jobs/' . $jobId .
      '/status');

    $directJobStatusResponse = $client->getStatus(
      StatusReference::ofUrl($statusUrl)
                     ->withStatusQueryToken($statusQueryToken));
    $this->assertInstanceOf(DirectJobStatusResponse::class, $directJobStatusResponse);

    $pAdESUrl = $directJobStatusResponse->getpAdESUrl();
    $xAdESUrl = $directJobStatusResponse->getSignatureFrom('28129307058')->getxAdESUrl();

    $responseStream = $client->getPAdES($pAdESUrl);
    $data = $responseStream->getContents();

    $path = realpath(__DIR__ . '/../../../../../../var/data/');
    $filename = date('YmdHis_') . $directJobResponse->getReference() . '_%s.%s';
    file_put_contents(sprintf($path . '/' . $filename, 'pAdES', 'pdf'), $data);
    $responseStream->close();

    $responseStream = $client->getXAdES($xAdESUrl);
    $data = $responseStream->getContents();
    file_put_contents(sprintf($path . '/' . $filename, 'xAdES', 'xml'), $data);
    $responseStream->close();
  }

  /**
   *
   */
  public function testCreatePortalSignature() {
    $clientConfigBuilder = $this->getContainer()->get(
      'digipost_signature.client_configuration_builder'
    );
    $sender = new Sender("991825827");
    $clientConfig = $clientConfigBuilder->globalSender($sender)
                                        ->serviceUri(ServiceUri::DIFI_TEST())
                                        ->enableDocumentBundleDiskDump(
                                          self::$dumpFolder
                                        )
                                        ->build();

    $client = new PortalClient($clientConfig);

    $docData = file_get_contents(self::$root_dir . '/Signeringsdokument_v1.0.pdf');
    $document = PortalDocument::builder("Signeringsdokument", "Signeringsdokument_v1.0.pdf", $docData);
    $document = $document
      ->fileType(DocumentFileType::PDF())
      ->nonsensitiveTitle('Dette er ikke sensitivt!!')
      ->message("Dette er en test!")
      ->build();

    //$signer1 = DirectSigner::withPersonalIdentificationNumber('28129307058');
    //->onBehalfOf(OnBehalfOf::OTHER());
    //$signer1 = DirectSigner::withCustomIdentifier('bendik_brenne')->withSignatureType(SignatureType::AUTHENTICATED_SIGNATURE());
    $signer1 = PortalSigner::identifiedByEmailAndMobileNumber('bendik@brenne.nu', '91773395')
      ->withSignatureType(SignatureType::AUTHENTICATED_SIGNATURE());

    $jobReference = 'test-job_' . sha1(microtime(FALSE));

    $portalJob = PortalJob::builder($document, $signer1->build())
                          //->requireAuthentication(AuthenticationLevel::FOUR())
                          ->withReference($jobReference)
                          ->withIdentifierInSignedDocuments(IdentifierInSignedDocuments::NAME())
                          ->withSender($sender)
                          ->availableFor(6, TimeUnit::DAYS())
                          ->build();

    try {
      $response = $client->create($portalJob);

      //print "\n" . $response->getNextPermittedPollTime() . "\n";
    } catch (\Exception $e) {
      $this->fail('Caught exception: ' . $e->getMessage());
    }
    //$this->assertInstanceOf(PortalJobResponse::class, $response);
    //$this->assertSame($jobReference, $response->getConfirmationReference());
  }

  /**
   * @throws \Exception
   */
  public function testCreateSignature() {
    $clientConfigBuilder = $this->getContainer()->get(
      'digipost_signature.client_configuration_builder'
    );
    $clientConfig = $clientConfigBuilder->globalSender(new Sender("991825827"))
                                        ->serviceUri(ServiceUri::DIFI_TEST())
                                        ->enableDocumentBundleDiskDump(
                                          self::$dumpFolder
                                        )
                                        ->build();

    $client = new DirectClient($clientConfig);

    $docData = file_get_contents(self::$root_dir . '/Signeringsdokument_v1.0.pdf');
    $document = DirectDocument::builder("Brukervilkår", "Signeringsdokument_v1.0.pdf", $docData);
    $document = $document
      ->fileType(DocumentFileType::PDF())
      ->message("Dette er en test!")
      ->build();

    $signer1 = DirectSigner::withPersonalIdentificationNumber('28129307058')
                           ->onBehalfOf(OnBehalfOf::OTHER());
//    $signer1 = DirectSigner::withCustomIdentifier('bendik_brenne')
//                           ->withSignatureType(SignatureType::AUTHENTICATED_SIGNATURE());
    $jobReference = 'test-job_' . sha1(microtime(FALSE));

    $directJob = DirectJob::builder(
      $document,
      ExitUrls::of(
        'http://dev-drupal.difi.local/samarbeid2lukket/digipost-signature/direct-test-phpunit/completion', 'http://dev-drupal.difi.local/samarbeid2lukket/digipost-signature/direct-test-phpunit/failure',
        'http://dev-drupal.difi.local/samarbeid2lukket/digipost-signature/direct-test-phpunit/error'),
      $signer1->build()
    )
                          //->requireAuthentication(AuthenticationLevel::FOUR())
                          ->withReference($jobReference)
                          ->withIdentifierInSignedDocuments(IdentifierInSignedDocuments::NAME())
                          ->retrieveStatusBy(StatusRetrievalMethod::WAIT_FOR_CALLBACK())
                          ->build();
    $response = $client->create($directJob);

    $this->assertInstanceOf(DirectJobResponse::class, $response);
    $this->assertSame($jobReference, $response->getReference());

    dump($response);

    print "\n" . $response->getSingleRedirectUrl() . "\n";
  }
}
