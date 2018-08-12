<?php

namespace Digipost\Signature\Client\ASiCe\Signature;

use Digipost\Signature\API\XML\Thirdparty\XMLdSig\KeyInfo;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\X509Data;
use Digipost\Signature\Client\ASiCe\Signature\Signature as SignatureManifest;
use Digipost\Signature\Client\Core\Exceptions\ConfigurationException;
use Digipost\Signature\Client\Core\Internal\Security\Certificate;
use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use Digipost\Signature\Client\Core\Internal\XMLSignatureFactory;
use Digipost\Signature\Client\Direct\DirectDocument;
use Digipost\Signature\Client\Security\KeyStoreConfig;
use Digipost\Signature\XSD\SignatureApiSchemas;
use GoetasWebservices\XML\XSDReader\Schema\Exception\SchemaException;
use Digipost\Signature\Client\Core\Internal\Security\Constants as C;
use Digipost\Signature\Client\Core\Internal\Security\Signature;
use SimpleSAML\XMLSec\Utils\DOMDocumentFactory;

/**
 * Class CreateSignature
 *
 * @package Digipost\Signature\Client\ASiCe\Signature
 */
class CreateSignature {

  private $sha256DigestMethod;

  private $createXAdESProperties;

  /** @var Signature */
  private $signature;

  /** @var \DOMElement */
  private $sigElement;

  /** @var \DOMDocument */
  private $document;

  public function __construct(\DateTime $clock) {
    $this->document = DOMDocumentFactory::fromString(
      '<?xml version="1.0" encoding="UTF-8" standalone="no"?>'.
      '<XAdESSignatures xmlns="http://uri.etsi.org/2918/v1.2.1#">'.
        '<ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#" Id="Signature">'.
          '<ds:SignedInfo>'.
            '<ds:CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>'.
            '<ds:SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256"/>'.
          '</ds:SignedInfo>'.
          '<ds:Object>'.
            '<xades:QualifyingProperties xmlns:xades="http://uri.etsi.org/01903/v1.3.2#" Target="#Signature">'.
              '<xades:SignedProperties Id="SignedProperties">'.
                '<xades:SignedSignatureProperties>'.
                  '<xades:SigningCertificate/>'.
                '</xades:SignedSignatureProperties>'.
              '</xades:SignedProperties>'.
            '</xades:QualifyingProperties>'.
          '</ds:Object>'.
        '</ds:Signature>'.
      '</XAdESSignatures>'
    );

    try {
      $rootNode = $this->document->documentElement;
      $this->signature = Signature::fromXML($rootNode);
      $this->signature->setBlacklistedAlgorithms([]);

      $this->createXAdESProperties = new CreateXAdESProperties($clock);
    } catch (\Exception $e) {
      throw new ConfigurationException("Failed to initialize XML-signing", $e);
    }
  }

  /**
   * @param                $attachedFiles
   * @param KeyStoreConfig $keyStoreConfig
   *
   * @return SignatureManifest
   * @throws SchemaException
   */
  public function createSignature(
    $attachedFiles,
    KeyStoreConfig $keyStoreConfig
  ) {
    //$xmlSignatureFactory = $this->getSignatureFactory();
    //    $signatureMethod = $this->getSignatureMethod($xmlSignatureFactory);
    //    $signContext = $xmlSignatureFactory->getXMLSignatureContext();

    // Create signature references for all files
    //$references = $this->references($xmlSignatureFactory, $attachedFiles);
    //$signContext->addReferencedFiles($attachedFiles);
    //$schema = $this->loadSchema();
    //$this->signature->add

    //$this->signature->addObject()

    // Create signature reference for XAdES properties
    //    array_push(
    //      $references,
    //      $xmlSignatureFactory->newReference(
    //        "#SignedProperties",
    //        $this->sha256DigestMethod,
    //        $this->canonicalXmlTransform,
    //        $this->signedPropertiesType,
    //        NULL
    //      )
    //    );

    // Generate XAdES document to sign, information about the key used for signing and information about what's signed
    //$test = $this->document->importNode($qualifyingProperties->documentElement);
    //$this->wrapSignatureInXADeSEnvelope($this->document);

    $qualifyingProperties = $this->createXAdESProperties->createPropertiesToSign(
      $this->signature,
      $attachedFiles,
      $keyStoreConfig->getCertificate()
    );

    //    $keyInfo = $this->keyInfo(
    //      $xmlSignatureFactory,
    //      ...$keyStoreConfig->getCertificateChain()
    //    );

    //    $signedInfo = $xmlSignatureFactory->newSignedInfo(
    //      $this->canonicalizationMethod,
    //      $signatureMethod,
    //      $references
    //    );

    //    // Define signature over XAdES document
    //    $xmlObject = $xmlSignatureFactory->newXMLObject(
    //      [new XMLStructure($document->documentElement)],
    //      NULL, NULL, NULL
    //    );

    try {
      $this->signature->sign($keyStoreConfig->getPrivateKey()->toXmlSecLibPrivateKey(), C::SIG_RSA_SHA256, TRUE);
    } catch (\Exception $e) {
      throw new ConfigurationException("Failed to initialize XML-signing", $e);
    }

    $root = $this->signature->getRoot();
    $outputStream = $root->C14N(FALSE, FALSE);

    try {
      //$this->wrapSignatureInXADeSEnvelope($root->ownerDocument);
      $outputStream = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>' . $outputStream;

      $this->validateXml($root->ownerDocument);
    } catch (\RuntimeException $e) {
      throw $e;
    } catch (SchemaException $e) {
      throw $e;
    }

    return new SignatureManifest($outputStream);
  }

  /**
   * @param XMLSignatureFactory $xmlSignatureFactory
   * @param DirectDocument[]    $files
   *
   * @return array
   */
  private function references(
    XMLSignatureFactory $xmlSignatureFactory,
    array $files
  ) {
    $result = [];
    for ($i = 0; $i < sizeof($files); $i++) {
      try {
        $signatureElementId = sprintf("ID_%s", $i);
        $uri = urlencode($files[$i]->getFileName());
        $reference = $xmlSignatureFactory->newReference(
          $uri,
          $this->sha256DigestMethod,
          NULL,
          NULL,
          $signatureElementId,
          hash(
            'sha256',
            $files[$i]->getBytes()
          )
        );
        array_push($result, $reference);
        //} catch (UnsupportedEncodingException $e) {
      } catch (\Exception $e) {
        throw new \RuntimeException($e);
      }
    }

    return $result;
  }

  /**
   * @param XMLSignatureFactory $xmlSignatureFactory
   * @param Certificate[]       $certificates
   *
   * @return KeyInfo
   */
  private function keyInfo(
    XMLSignatureFactory $xmlSignatureFactory,
    Certificate ...$certificates
  ): KeyInfo {
    /** @var KeyInfoFactory $keyInfoFactory */
    //    $keyInfoFactory = $xmlSignatureFactory->getKeyInfoFactory();
    $keyInfo = new KeyInfo();
    $x509Data = new X509Data();
    $x509Data->setX509Certificate($certificates);
    $keyInfo->addToX509Data($x509Data);
    //$x509Data = $keyInfoFactory->newX509Data($certificates);
    //return $keyInfoFactory->newKeyInfo($this->singletonList($x509Data));
    return $keyInfo;
  }

  //
  private function wrapSignatureInXADeSEnvelope(\DOMDocument $document) {
    $signatureElement = $document->removeChild($document->documentElement);
    $xadesElement = $document->createElementNS(C::ASICENS, "XAdESSignatures");
    $xadesElement->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns', C::ASICENS);
    $xadesElement->appendChild($signatureElement);
    $document->appendChild($xadesElement);
    return $document;
  }

  private function getSignatureFactory() {
    return XMLSignatureFactory::factory("DOM", "XMLdSig");
  }

  /**
   * Validate the XML document
   *
   * @param \DOMDocument $dom
   * @throws SchemaException
   */
  protected function validateXml(\DOMDocument $dom) {
    libxml_use_internal_errors(FALSE);

    $xsd = SignatureApiSchemas::ASICE_AND_XADES_SCHEMA()->getXSD();
    try {
      $dom->schemaValidateSource($xsd, Marshalling::LIBXML_OPTIONS);
    } catch (\Exception $e) {
      print $e->getMessage();
    }
    print "OK";
    if ($errors = $this->getXmlValidationErrors()) {
      $error = $this->formatXmlValidationErrors();

      throw new SchemaException($error);
    }
  }

  /**
   * @param \LibXMLError $error
   *
   * @return string
   */
  static function displaySingleLibXmlError(\LibXMLError $error) {
    $return = "\n";
    switch ($error->level) {
      case LIBXML_ERR_WARNING:
        $return .= "Warning $error->code: ";
        break;
      case LIBXML_ERR_ERROR:
        $return .= "Error $error->code: ";
        break;
      case LIBXML_ERR_FATAL:
        $return .= "Fatal Error $error->code: ";
        break;
    }
    $return .= trim($error->message);
    if ($error->file) {
      $return .= " in [" . $error->file . "]";
    }
    $return .= " on line [" . $error->line . "]\n";

    return $return;
  }

  protected function getXmlValidationErrors() {
    $errors = array_filter(libxml_get_errors(), function($error) {
      if ($error->code === 1824) {
        return FALSE;
      }
      return TRUE;
    });

    return count($errors) > 0 ? $errors : NULL;
  }

  /**
   * @return string
   */
  protected function formatXmlValidationErrors() {
    $errors = libxml_get_errors();
    $ret = '';
    foreach ($errors as $error) {
      $ret .= self::displaySingleLibXmlError($error) . "\n";
    }
    libxml_clear_errors();

    return $ret;
  }
}
