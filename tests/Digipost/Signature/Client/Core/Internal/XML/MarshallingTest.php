<?php
/**
 * Created by PhpStorm.
 * User: bendik
 * Date: 10.07.18
 * Time: 10:13
 */

namespace Tests\DigipostSignatureBundle\Client\Core\Internal\XML;

use Digipost\Signature\API\XML\Thirdparty\ASiCe\XAdESSignatures;
use Digipost\Signature\API\XML\XMLDirectSignatureJobManifest;
use Digipost\Signature\API\XML\XMLDirectSignatureJobResponse;
use Digipost\Signature\API\XML\XMLDirectSignatureJobStatusResponse;
use Digipost\Signature\API\XML\XMLError;
use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use Tests\DigipostSignatureBundle\Client\ClientBaseTestCase;

class MarshallingTest extends ClientBaseTestCase {

  private static $VENDOR_DIR;

  function setUp() {
    parent::setUp();

    $root_dir = $this->getContainer()->getParameter('kernel.project_dir');

    self::$VENDOR_DIR = realpath($root_dir . '/vendor/');
  }

  private function assertAndGetSchemaDir() {
    $schema_dir = self::$VENDOR_DIR . '/digipost/signature-api-specification/schema';
    $this->assertDirectoryExists($schema_dir);
    return $schema_dir;
  }

  function testUnmarshallingOfError() {
    $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><ns4:error xmlns="http://uri.etsi.org/01903/v1.3.2#" xmlns:ns2="http://www.w3.org/2000/09/xmldsig#" xmlns:ns3="http://uri.etsi.org/2918/v1.2.1#" xmlns:ns4="http://signering.posten.no/schema/v1"><ns4:error-code>ASICE_VALIDATION_FAILED</ns4:error-code><ns4:error-message>Error when valicating ASiCE: Parse error: Failed to parse XMLDirectSignatureJobManifest</ns4:error-message><ns4:error-type>CLIENT</ns4:error-type></ns4:error>';

    $object = Marshalling::unmarshal($xml, XMLError::class);
    var_dump($object);

    Marshalling::marshal($object, $outputXML);
    $xmlGenerated = $outputXML->saveXML();
    $this->assertSame($xml, str_replace("\n", "", $xmlGenerated));
  }

  /**
   *
   */
  function testMarshallingError() {
    $object = new XMLError(
      'ASICE_VALIDATION_FAILED',
      'Error when validating ASiCE: Parse error: Failed to parse XMLDirectSignatureJobManifest',
      'CLIENT'
    );
    $xml = Marshalling::marshal($object, $outputXML);
    /** @var \DOMDocument $outputXML */
    $outputXML->formatOutput = FALSE;
    print $outputXML->saveXML();
  }

  function testUnmarshallingOfDirectResponse() {
    $schema_dir = $this->assertAndGetSchemaDir();
    $direct_response_example = file_get_contents(
      $schema_dir . '/examples/direct/response.xml'
    );
    print $direct_response_example;
    print "\n---\n";

    $object = Marshalling::unmarshal(
      $direct_response_example,
      XMLDirectSignatureJobResponse::class
    );
    //    var_dump($object);

    $xml = Marshalling::marshal($object, $outputXML);
    print $outputXML->saveXML();
  }

  function testUnmarshallingOfXAdESSignatures() {
    $schema_dir = $this->assertAndGetSchemaDir();
    $xml_example = file_get_contents(
      $schema_dir . '/examples/xades/signatures.xml'
    );


    $object = Marshalling::unmarshal($xml_example, XAdESSignatures::class);
    /** @var $object XAdESSignatures */

    //print_r($object->getSignatures()[0]);
    //dump($object);
    dump($object);

    //$str = print_r($object, TRUE);
    //var_dump($object);
  }

  function testMarshallingOfXAdESSignatures() {
    $schema_dir = $this->assertAndGetSchemaDir();
    //$xml_example = file_get_contents($schema_dir . '/examples/xades/signatures.xml');
    $xml_example = file_get_contents(__DIR__ . '/signatures.xml');

    $object = Marshalling::unmarshal($xml_example, XAdESSignatures::class);
    /** @var XAdESSignatures $object */
    dump($object);
    //    $keyInfo = $object->getSignatures()[0]->getKeyInfo();
    //
    //    $object = new XAdESSignatures();
    //    $signedInfo = new SignedInfo();
    //    $signedInfo->setCanonicalizationMethod(new CanonicalizationMethod());
    //$signature = new \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Signature();

    Marshalling::marshal($object, $xmlOutput);
    /** @var \DOMDocument $xmlOutput */
    //    $xmlOutput->xmlStandalone = TRUE;
    //$xmlOutput->normalizeDocument();

    //DOMUtils::removeDOMNamespace($xmlOutput, 'ns-f1c343a8');
    //DOMUtils::removeWhiteSpace($xmlOutput);
    //$elements = $xmlOutput->documentElement->getElementsByTagName('Signature');

    //removeAttributeNS('http://www.w3.org/2000/09/xmldsig#"', 'ds');

    print $xmlOutput->saveXML();
    //    $config = new \DOMConfiguration();
    //    $config->setParameter('testings', 'ja');
    //    $xmlOutput->config = $config;
    //    $xmlOutput->documentElement->removeAttributeNS('http://www.w3.org/2000/09/xmldsig#"', 'ds');
    //    $namespaces = DOMUtils::getDocNamespaces($xmlOutput);
    //    dump($namespaces);
    print "Hei";
  }

  function testUnmarshallingOfDirectManifest() {
    $schema_dir = $this->assertAndGetSchemaDir();
    $xml_example = file_get_contents(
      $schema_dir . '/examples/direct/manifest-signer-without-pin.xml'
    );

    $object = Marshalling::unmarshal(
      $xml_example,
      XMLDirectSignatureJobManifest::class,
      ['snake-case' => TRUE]
    );
    /** @var $object XAdESSignatures */
    //print_r($object->getSignatures()[0]);

    print_r($object);
    //var_dump($object);
  }

  function testUnmarshallingOfDirectJobStatusResponse() {
    $schema_dir = $this->assertAndGetSchemaDir();
    $xml_example = file_get_contents(
      $schema_dir . '/examples/direct/status-response.xml'
    );

    $object = Marshalling::unmarshal(
      $xml_example,
      XMLDirectSignatureJobStatusResponse::class,
      ['snake-case' => TRUE]
    );
    /** @var $object XAdESSignatures */
    //print_r($object->getSignatures()[0]);

    //print_r($object);
    //var_dump($object);
    Marshalling::marshal(
      $object, $outputXML, NULL, ['snake-case' => TRUE]
    );
    print $outputXML->saveXML();
  }
}
