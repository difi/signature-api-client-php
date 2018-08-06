<?php
/**
 * Created by PhpStorm.
 * User: bendik
 * Date: 10.07.18
 * Time: 10:13
 */

namespace Tests\DigipostSignatureBundle\Client\Core\Internal\XML;

use Digipost\Signature\API\XML\CustomBase64BinaryType;
use Digipost\Signature\API\XML\Thirdparty\ASiCe\XAdESSignatures;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\CanonicalizationMethod;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestValue;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\Reference;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureMethod;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignedInfo;
use Digipost\Signature\API\XML\XMLDirectSignatureJobManifest;
use Digipost\Signature\API\XML\XMLDirectSignatureJobResponse;
use Digipost\Signature\API\XML\XMLDirectSignatureJobStatusResponse;
use Digipost\Signature\API\XML\XMLError;
use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use MyCLabs\Enum\Enum;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use SimpleSAML\XMLSec\Constants as C;
use SimpleSAML\XMLSec\Utils\DOMDocumentFactory;
use SimpleSAML\XMLSec\Utils\XPath;
use Tests\DigipostSignatureBundle\Client\ClientBaseTestCase;

/**
 * @method static XmlNS XMLdSig
 * @method static XmlNS XAdES
 * @method static XmlNS ASiCe
 */
class XmlNS extends Enum {

  const XMLdSig = ['ds', 'http://www.w3.org/2000/09/xmldsig#'];
  const XAdES   = ['xades', 'http://uri.etsi.org/01903/v1.3.2#'];
  const ASiCe   = ['asice', 'http://uri.etsi.org/2918/v1.2.1#'];

  function __construct($value) {
    parent::__construct($value);
  }

  /**
   * @return string
   */
  function __toString() {
    return $this->getNamespaceUri();
  }
  public function getNamespaceUri() {
    return $this->value[1];
  }
  public function getPrefix() {
    return $this->value[0];
  }
  public function clarkNotate(string $localName) {
    return '{' . $this->getNamespaceUri() . '}' . $localName;
  }
}

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

  public function testSabreXml() {
    //    $service = $this->getContainer()->get('sabre_io.xml.service');
    //    $service->namespaceMap['http://www.w3.org/2005/Atom'] = '';
    //    //$service->namespaceMap['http://signering.posten.no/schema/v1'] = '';
    //    $service->namespaceMap['http://www.w3.org/2000/09/xmldsig#'] = 'ds';
    //    $service->namespaceMap['http://uri.etsi.org/2918/v1.2.1#'] = 'asic';
    //    $service->namespaceMap['http://uri.etsi.org/01903/v1.3.2#'] = 'xades';
    //
    //    $asice = '{http://uri.etsi.org/2918/v1.2.1#}';
    //    $xades = '{http://uri.etsi.org/01903/v1.3.2#}';
    //    $ds = '{http://www.w3.org/2000/09/xmldsig#}';
    //
    //    echo $service->write($asice.'XAdESSignatures', [
    //      [
    //        $ds . 'Signature' => [
    //          $ds . 'SignedInfo' => [
    //            $ds . 'CanonicalizationMethod' => ['attributes' => ['Algorithm' => C::C14N_INCLUSIVE_WITHOUT_COMMENTS]],
    //            $ds . 'SignatureMethod' => ['attributes' => ['Algorithm' => C::SIG_RSA_SHA256]],
    //          ],
    //          $ds . 'Object' => [
    //            $xades . 'QualifyingProperties' => [
    //              'attributes' => [
    //                'Target' => '#Signature',
    //              ],
    //            ],
    //          ],
    //        ],
    //      ],
    //    ]);
    $doc = DOMDocumentFactory::fromString(
      '<XAdESSignatures>' .
      '<Signature Id="Signature">' .
      '<SignedInfo>' .
      '<CanonicalizationMethod Algorithm="' . C::C14N_INCLUSIVE_WITHOUT_COMMENTS . '"/>' .
      '<SignatureMethod Algorithm="' . C::SIG_RSA_SHA256 . '"/>' .
      '</SignedInfo>' .
      '<Object>' .
      '<QualifyingProperties Target="#Signature">' .
      '<SignedProperties Id="SignedProperties">' .
      '<SignedSignatureProperties>' .
      '<SigningTime>2018-08-03T06:54:19.855+02:00</SigningTime>' .
      '<SigningCertificate>' .
      '<Cert>' .
      '<CertDigest>' .
      '<ns2:DigestMethod Algorithm="' . C::DIGEST_SHA1 . '"/>' .
      '<ns2:DigestValue>iL23T62u2H9S0vXBGu1gfeuXALo=</ns2:DigestValue>' .
      '</CertDigest>' .
      '<IssuerSerial>' .
      '<ns2:X509IssuerName>CN=Buypass Class 3 Test4 CA 3, O=Buypass AS-983163327, C=NO</ns2:X509IssuerName>' .
      '<ns2:X509SerialNumber>1646201040405302454751306</ns2:X509SerialNumber>' .
      '</IssuerSerial>' .
      '</Cert>' .
      '</SigningCertificate>' .
      '</SignedSignatureProperties>' .
      '<SignedDataObjectProperties></SignedDataObjectProperties>' .
      '</SignedProperties>' .
      '</QualifyingProperties>' .
      '</Object>' .
      '</Signature>' .
      '</XAdESSignatures>');
    $rootNode = $doc->documentElement;
    $rootNode->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns', C::ASICENS);

    $rootNode->getElementsByTagName('Signature')
             ->item(0)
             ->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns', C::XMLDSIGNS);

    $dsNodeNames = ['SignedInfo', 'Object', 'CanonicalizationMethod', 'SignatureMethod'];
    foreach ($dsNodeNames as $localName) {
      $nodes = $rootNode->getElementsByTagName($localName);
      foreach ($nodes as $node) {
        /** @var \DOMElement $node */
        $node->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns', C::XMLDSIGNS);
      }
    }
    $node = $rootNode->getElementsByTagName('QualifyingProperties')->item(0);
    $node->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns', C::XADESNS);
    $node->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:ns2', C::XMLDSIGNS);

    $xp = XPath::getXPath($doc);
    $xp->registerNamespace('ds', C::XMLDSIGNS);
    $xp->registerNamespace('xades', C::XADESNS);

    $signedProperties = $xp->query('//*[@Id="SignedProperties" or @ObjectReference="SignedProperties"]', $rootNode)
         ->item(0);
    print $signedProperties->C14N(FALSE, FALSE);
    print $rootNode->C14N(FALSE, FALSE);
  }

  function testUnmarshallingOfError() {
    $xml =
      '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><ns4:error xmlns="http://uri.etsi.org/01903/v1.3.2#" xmlns:ns2="http://www.w3.org/2000/09/xmldsig#" xmlns:ns3="http://uri.etsi.org/2918/v1.2.1#" xmlns:ns4="http://signering.posten.no/schema/v1"><ns4:error-code>ASICE_VALIDATION_FAILED</ns4:error-code><ns4:error-message>Error when valicating ASiCE: Parse error: Failed to parse XMLDirectSignatureJobManifest</ns4:error-message><ns4:error-type>CLIENT</ns4:error-type></ns4:error>';

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

  function testMarshallingOfDirectJobStatusResponse() {

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

  function testXMLSecLibs() {
    $sabre = $this->getContainer()->get('sabre_io.xml.service');

    $ASiCe = XmlNS::ASiCe();
    $XMLdSig = XmlNS::XMLdSig();
    $XAdES = XmlNS::XAdES();

    $sabre->namespaceMap['http//www.w3.org/2005/Atom'] = 'atom';
    $sabre->namespaceMap['http://www.w3.org/2001/XMLSchema'] = 'xs';
    $sabre->namespaceMap['http://signering.posten.no/schema/v1'] = '';
    $sabre->namespaceMap[$XMLdSig->getNamespaceUri()] = $XMLdSig->getPrefix();
    $sabre->namespaceMap[$ASiCe->getNamespaceUri()] = $ASiCe->getPrefix();
    $sabre->namespaceMap[$XAdES->getNamespaceUri()] = $XAdES->getPrefix();
    //$sabre->classMap[''] = 'test';

    $sabre->mapValueObject($XMLdSig->clarkNotate('SignedInfo'), SignedInfo::class);
    $sabre->mapValueObject($XMLdSig->clarkNotate('Reference'), Reference::class);
    $sabre->mapValueObject($XMLdSig->clarkNotate('DigestValue'), DigestValue::class);
    $sabre->mapValueObject($XMLdSig->clarkNotate('DigestMethod'), DigestMethod::class);
    $sabre->mapValueObject($XMLdSig->clarkNotate('SignatureMethod'), SignatureMethod::class);
    $sabre->mapValueObject(
      $XMLdSig->clarkNotate('CanonicalizationMethod'), CanonicalizationMethod::class);

    $canonicalizationMethod = new CanonicalizationMethod();
    $canonicalizationMethod->setAlgorithm(XMLSecurityDSig::C14N);
    $signatureMethod = new SignatureMethod();
    $signatureMethod->setAlgorithm(XMLSecurityDSig::SHA256);
    $digestMethod = new DigestMethod();
    $digestMethod->setAlgorithm(XMLSecurityDSig::SHA256);

    $digestValue = hash('sha256', 'heisann hoppsann trallalalaa');
    $digestValue = new DigestValue(new CustomBase64BinaryType($digestValue));

    $references = [];
    $references[0] = new Reference();
    $references[0]->setDigestMethod($digestMethod)
                  ->setURI('manifest.xml')
                  ->setId('ID_0')
                  ->setDigestValue($digestValue);

    $signedInfo = new SignedInfo();
    $signedInfo
      ->setCanonicalizationMethod($canonicalizationMethod)
      ->setSignatureMethod($signatureMethod)
      ->setId('1234')
      ->setReference($references);

    //$xml = $sabre->writeValueObject($signedInfo);
    //print_r($xml);

    Marshalling::marshal($signedInfo, $domOutput);
    /** @var \DOMDocument $domOutput */
    $domOutput->formatOutput = TRUE;
    print $domOutput->saveXML();

    new XMLSecurityDSig('');
  }
}
