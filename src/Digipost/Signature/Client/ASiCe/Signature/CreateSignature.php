<?php

namespace Digipost\Signature\Client\ASiCe\Signature;

//use Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod;
//use Digipost\Signature\API\XML\Thirdparty\XMLdSig\KeyInfo;
//use Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureMethod;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\KeyInfo;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureMethod;
//use Digipost\Signature\Client\Core\Document;
use Digipost\Signature\Client\ASiCe\Manifest\Manifest;
use Digipost\Signature\Client\Core\Exceptions\ConfigurationException;
use Digipost\Signature\Client\Core\Exceptions\XmlConfigurationException;
use Digipost\Signature\Client\Core\Internal\SignatureCanonicalizationMethod;
use Digipost\Signature\Client\Core\Internal\SignatureDigestMethod;
use Digipost\Signature\Client\Core\Internal\NoSuchProviderException;
use Digipost\Signature\Client\Core\Internal\XMLSignatureFactory;
use Digipost\Signature\Client\Core\Internal\XMLSignContext;
use Digipost\Signature\Client\Direct\DirectDocument;
use Digipost\Signature\Client\Security\KeyStoreConfig;
use Digipost\Signature\XSD\SignatureApiSchemas;
use \DOMDocument as Document;

use GoetasWebservices\XML\XSDReader\Schema\Exception\SchemaException;
use GoetasWebservices\XML\XSDReader\SchemaReader;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use PhpOffice\PhpWord\Exception\Exception;

/**
 * Class CreateSignature
 *
 * @package Digipost\Signature\Client\ASiCe\Signature
 */
class CreateSignature {

  public static $C14V1 = "http://www.w3.org/TR/2001/REC-xml-c14n-20010315";

  private $asicNamespace = "http://uri.etsi.org/2918/v1.2.1#";

  private $signedPropertiesType = "http://uri.etsi.org/01903#SignedProperties";

  private $sha256DigestMethod;

  /** @var SignatureCanonicalizationMethod */
  private $canonicalizationMethod;

  private $canonicalXmlTransform;

  private $createXAdESProperties;

  private $transformerFactory;

  private $schema;

  public function __construct(\DateTime $clock) {

    $this->createXAdESProperties = new CreateXAdESProperties($clock);

    //$this->transformerFactory = TransformerFactory::newInstance();
    try {
      $xmlSignatureFactory = $this->getSignatureFactory();
      $this->sha256DigestMethod = $xmlSignatureFactory->newDigestMethod(SignatureDigestMethod::SHA256());
      $this->canonicalizationMethod = $xmlSignatureFactory->newCanonicalizationMethod(self::$C14V1);
      $this->canonicalXmlTransform = $xmlSignatureFactory->newTransform(self::$C14V1);

      //    } catch (NoSuchAlgorithmException $e) {
      //      throw new ConfigurationException("Failed to initialize XML-signing", $e);
      //    } catch (InvalidAlgorithmParameterException $e) {
      //      throw new ConfigurationException("Failed to initialize XML-signing", $e);
      //    }
    } catch (\Exception $e) {
      throw new ConfigurationException("Failed to initialize XML-signing", $e);
    }

    $this->schema = $this->loadSchema();
  }

  private function loadSchema() {
    try {
      $reader = new SchemaReader();
      $schema = $reader->getGlobalSchema();
      $schema->addSchema($reader->readFile(SignatureApiSchemas::$XMLDSIG_SCHEMA));
      $schema->addSchema($reader->readFile(SignatureApiSchemas::$ASICE_SCHEMA));
      return $schema;
      /*
      return SchemaLoaderUtils::loadSchema(new Resource[] {
        new ClassPathResource(SignatureApiSchemas::$XMLDSIG_SCHEMA),
       new ClassPathResource(SignatureApiSchemas::$ASICE_SCHEMA)
    }, XmlValidatorFactory . SCHEMA_W3C_XML);
      */
    } catch (SchemaException $e) {
      throw new ConfigurationException("Failed to load schemas for validating signatures",
                                       $e);
    }
  }

  private function singletonList($list) {

  }

  public function createSignature($attachedFiles,
                                  KeyStoreConfig $keyStoreConfig) {
    $xmlSignatureFactory = $this->getSignatureFactory();
    $signatureMethod = $this->getSignatureMethod($xmlSignatureFactory);

    // Create signature references for all files
    $references = $this->references($xmlSignatureFactory, $attachedFiles);

    // Create signature reference for XAdES properties
    array_push($references,
               $xmlSignatureFactory->newReference(
                 "#SignedProperties",
                 $this->sha256DigestMethod,
                 $this->canonicalXmlTransform,
                 $this->signedPropertiesType,
                 NULL,
                 NULL
               ));

    // Generate XAdES document to sign, information about the key used for signing and information about what's signed
    $document = $this->createXAdESProperties->createPropertiesToSign($attachedFiles,
                                                                     $keyStoreConfig->getCertificate());

    $keyInfo = $this->keyInfo($xmlSignatureFactory,
                              $keyStoreConfig->getCertificateChain());
    $signedInfo = $xmlSignatureFactory->newSignedInfo($this->canonicalizationMethod,
                                                      $signatureMethod,
                                                      $references);

    // Define signature over XAdES document
    $xmlObject = $xmlSignatureFactory->newXMLObject([$document->documentElement],
                                                    NULL, NULL, NULL);

    //
    $xmlSignature = $xmlSignatureFactory->newXMLSignature($signedInfo, $keyInfo,
                                                          [$xmlObject],
                                                          "Signature", NULL);

    try {
      $xmlSignature->sign(new XMLSignContext($keyStoreConfig->getPrivateKey(),
                                             $document));

      //print_r($document->saveXML());
    } catch (\Exception $e) {
      throw new ConfigurationException("Failed to initialize XML-signing", $e);
    } catch (XMLSignatureException $e) {
      throw new XmlConfigurationException("Failed to sign ASiC-E element.", $e);
    }

    $this->wrapSignatureInXADeSEnvelope($document);
    $document->formatOutput = TRUE;

    //print $document->saveXML();

    //$outputStream = NULL;
    $outputStream = $document->saveXML();
    //        try {
    //            outputStream = new ByteArrayOutputStream();
    //            Transformer transformer = transformerFactory.newTransformer();
    //            schema.newValidator().validate(new DOMSource(document));
    //            transformer.transform(new DOMSource(document), new StreamResult(outputStream));
    //        } catch (TransformerException e) {
    //            throw new ConfigurationException("Unable to serialize XML.", e);
    //        } catch (SAXException e) {
    //            throw new XmlValidationException("Failed to validate generated signature.xml. Verify that the input is valid and that there are no illegal symbols in file names etc.", e);
    //        } catch (IOException e) {
    //            throw new RuntimeIOException(e);
    //        }
    return new Signature($outputStream);
  }

  private function getSignatureMethod(XMLSignatureFactory $xmlSignatureFactory): SignatureMethod {
    try {
      return $xmlSignatureFactory->newSignatureMethod("http://www.w3.org/2001/04/xmldsig-more#rsa-sha256");
      //} catch (NoSuchAlgorithmException | InvalidAlgorithmParameterException e) {
    } catch (\Exception $e) {
      throw new ConfigurationException("Failed to initialize XML-signing", $e);
    }
  }

  /**
   * @param XMLSignatureFactory $xmlSignatureFactory
   * @param DirectDocument[]    $files
   *
   * @return array
   */
  private function references(XMLSignatureFactory $xmlSignatureFactory,
                              array $files) {
    $result = [];
    for ($i = 0; $i < sizeof($files); $i++) {
      try {
        $signatureElementId = sprintf("ID_%s", $i);
        //$uri = UriResolver::resolve()
        //$uri = URLEncoder::encode($files[$i]->getFileName(), "UTF-8");
        //print_r($files[$i]->getBytes());
        $uri = urlencode($files[$i]->getFileName());
        $reference = $xmlSignatureFactory->newReference($uri,
                                                        $this->sha256DigestMethod,
                                                        NULL,
                                                        NULL,
                                                        $signatureElementId,
                                                        hash('sha256',
                                                             $files[$i]->getBytes()
                                                        ));
        array_push($result, $reference);
        //} catch (UnsupportedEncodingException $e) {
      } catch (\Exception $e) {
        throw new \RuntimeException($e);
      }
    }
    return $result;
  }

  //
  private function keyInfo(XMLSignatureFactory $xmlSignatureFactory,
                           array $sertifikater): KeyInfo {
    //$keyInfoFactory = $xmlSignatureFactory->getKeyInfoFactory();
    //$x509Data = $keyInfoFactory->newX509Data($sertifikater);
    //return $keyInfoFactory->newKeyInfo($this->singletonList($x509Data));
    //return $xmlSignatureFactory->newKeyInfo();
    return new KeyInfo();
  }

  //
  private function wrapSignatureInXADeSEnvelope(Document $document) {
    $signatureElement = $document->removeChild($document->documentElement);
    $xadesElement = $document->createElementNS($this->asicNamespace,
                                               "XAdESSignatures");
    $xadesElement->appendChild($signatureElement);
    $document->appendChild($xadesElement);
  }


  private function getSignatureFactory() {
    try {
      return XMLSignatureFactory::getInstance("DOM", "XMLdSig");
    } catch (NoSuchProviderException $e) {
      throw new ConfigurationException("Failed to find XML Digital Signature provided. The library depends on default Java-provider");
    }
  }
}
