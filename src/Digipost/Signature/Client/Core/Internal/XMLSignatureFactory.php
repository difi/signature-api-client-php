<?php

namespace Digipost\Signature\Client\Core\Internal;

use Digipost\Signature\API\XML\CustomBase64BinaryType;
use Digipost\Signature\API\XML\Thirdparty\XAdES\QualifyingProperties;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\CanonicalizationMethod;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\KeyInfo;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\ObjectXsd;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\Reference;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\Signature;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureMethod;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureValue;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignedInfo;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transforms;
use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use MyCLabs\Enum\Enum;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class XMLSignatureFactory {

  private $container;

  /***
   * @var String
   */
  private $mechanismType;

  static $PROVIDERS = [
    "XMLdSig" => XMLDigitalSignatureContext::class,
  ];

  /** @var self */
  static $INSTANCE;

  /** @var XMLDigitalSignatureContext */
  protected $provider;

  /**
   * XMLSignatureFactory constructor.
   *
   * @param ContainerInterface $container
   */
  function __construct(ContainerInterface $container = NULL) {
    if ($container) {
      $this->container = $container;
    }
  }

  public static function factory(String $mechanismType,
                                 String $provider = NULL) {

    $self = new XMLSignatureFactory();
    $self->mechanismType = $mechanismType;
    $self->provider = new self::$PROVIDERS[$provider]();
    return $self;
  }

  public function getKeyInfoFactory() {
    //return KeyInfoFactory::getInstance_String_Provider($this->mechanismType, $this->getProvider());
    //return DOMKeyInfoFactory::getInstance();
    //return new DOMKeyInfoFactory();
  }

  /**
   * @param String $algorithm
   *
   * @return DigestMethod
   */
  public function newDigestMethod(String $algorithm) {
    $this->provider->setDigestMethod($algorithm);
    $digestMethod = new DigestMethod();
    $digestMethod->setAlgorithm($algorithm);
    //return SignatureDigestMethod::fromString($algorithm);
    return $digestMethod;
  }

  /**
   * @param String $algorithm
   *
   * @return CanonicalizationMethod
   */
  public function newCanonicalizationMethod(String $algorithm) {
    $this->provider->setCanonicalMethod($algorithm);

    //return SignatureCanonicalizationMethod::fromString($algorithm);
    $canonicalizationMethod = new CanonicalizationMethod();
    $canonicalizationMethod->setAlgorithm($algorithm);

    return $canonicalizationMethod;
  }

  public function newSignatureMethod(String $method, $params = NULL) {
    $signatureMethod = new SignatureMethod();
    $signatureMethod
      ->setAlgorithm($method)
      ->setHMACOutputLength($params);
    // TODO: implement
    //$this->provider->setSignatureMethod($method, $params);
    return $signatureMethod;
  }

  public function newTransform(String $algorithm, $params = NULL) {
    $transform = new Transform();
    $transform
      ->setAlgorithm($algorithm);
    if (isset($params)) {
      $transform->setXPath($params);
    }

    return $transform;
  }

  /**
   * @param String                 $uri
   * @param DigestMethod           $digestMethod
   * @param Transforms|Transform[] $transform
   * @param String                 $type
   * @param String                 $id
   * @param String                 $digestValue
   *
   * @return Reference
   */
  public function newReference(
    String $uri = NULL,
    DigestMethod $digestMethod = NULL,
    $transform = NULL,
    String $type = NULL,
    String $id = NULL,
    $digestValue = NULL
  ) {
    if (isset($digestValue) && !($digestValue instanceof CustomBase64BinaryType)) {
      $digestValue = new CustomBase64BinaryType($digestValue);
    }

    if (!isset($digestMethod)) {
      throw new \InvalidArgumentException("No digest method was provided");
    }
    //$node = new \DOMDocument();
    //$this->provider->addReference($node, $uri);
    if (isset($transform) && $transform instanceof Transform) {
      //$transforms = new Transforms();
      //$transforms->addToTransform($transform);
    }
    else {
      //$transforms = $transform;
    }

    $reference = new Reference();
    $reference
      ->setURI($uri)
      ->setDigestMethod($digestMethod)
      ->setId($id)
      ->setType($type);
    if (isset($transform) && $transform instanceof Transform) {
      $reference->addToTransforms($transform);
    }
    else {
      if (is_array($transform)) {
        $reference->setTransforms($transform);
      }
    }
    if (isset($digestValue)) {
      $reference->setDigestValue($digestValue);
    }

    //$this->provider->addReference($reference, $uri);
    return $reference;
  }

  /**
   * @param CanonicalizationMethod $cm
   * @param SignatureMethod        $sm
   * @param array                  $references
   * @param String                 $id
   *
   * @return SignedInfo
   */
  public function newSignedInfo(
    CanonicalizationMethod $cm,
    SignatureMethod $sm,
    array $references,
    String $id = NULL
  ) {

    $signedInfo = new SignedInfo();
    $signedInfo
      ->setCanonicalizationMethod($cm)
      ->setSignatureMethod($sm)
      ->setReference($references)
      ->setId($id);

    return $signedInfo;
  }

  /**
   * @param \DOMElement $content
   * @param String      $id
   * @param String      $mimeType
   * @param String      $encoding
   *
   * @return ObjectXsd
   */
  public function newXMLObject(
    $content = NULL,
    String $id = NULL,
    String $mimeType = NULL,
    String $encoding = NULL
  ) {

    $second = $content->ownerDocument->documentElement;

    //    print $doc->saveXML();
    //    print "\n---------\n\n";
    $first = new \DOMDocument();
    $object = $first->createElementNS(
      'http://uri.etsi.org/01903/v1.3.2#', 'QualifyingProperties'
    );
    $first->appendChild($object);

    foreach ($second->childNodes as $node) {
      $importNode = $first->importNode($node, TRUE);
      $first->documentElement->appendChild($importNode);
    }
    $first->saveXML();

    $xml = new \DOMDocument("1.0", 'UTF-8');
    $xml->formatOutput = TRUE;
    $xml->appendChild($xml->importNode($first->documentElement, TRUE));

    $docXML = $xml->saveXML();
    $qualifyingProperties = Marshalling::unmarshal(
      $docXML, QualifyingProperties::class
    );

    //print $xml->saveXML($xml); exit;
    //print $docXML; exit;

    //    $object = $doc->createElementNS('http://uri.etsi.org/01903/v1.3.2#', 'ds:Object');
    //    $objectImported = $doc->importNode($object, TRUE);
    //    $doc->appendChild()

    //    $object = $doc->createDocumentFragment();
    //    $object->appendChild($doc->createElementNS('http://uri.etsi.org/01903/v1.3.2#', 'ds:Object'));

    //$object = new \DOMElement('Object', '')

    //$doc->firstChild->appendChild($object);


    //exit;
    //$marshalling = Marshalling::
    //DOMStructure
    //$doc = new \DOMDocumentFragment();
    //$doc->appendChild($content);
    //$doc = $content;
    //$doc->xmlStandalone = FALSE;
    //$doc->loadXML($content, LIBXML_NOCDATA | LIBXML_NOXMLDECL | LIBXML_NSCLEAN);
    //Marshalling::unmarshal()
    //    $xPath = new \DOMXPath($doc);
    //    $signedProperties = $xPath->evaluate("//*[local-name()='SignedProperties']")->item(0);
    //$xmlData = $doc->saveXML($query);
    //    $newDoc = new \DOMDocument();
    //    $newDoc->loadXML('<Object></Object>');

    //    $node = $newDoc->importNode($doc->firstChild, true);
    //    $newDoc->firstChild->appendChild($node);

    //    $newDoc->formatOutput = TRUE;


    //$objectXML = $doc->saveXML($object->ownerDocument->firstChild);
    //$qualifyingProperties = Marshalling::unmarshal($objectXML, QualifyingProperties::class);


    //print_r($qualifyingProperties);
    //print_r($qualifyingProperties);
    //foreach ($content as $content) {
    //}
    //$test = new ObjectIdentifier();
    //$test->set
    //print $objectXML;

    //$objectXsd = new ObjectXsd($qualifyingProperties);
    $xmlObject = new ObjectXsd();
    $xmlObject
      //->setQualifyingProperties($qualifyingProperties)
      ->setContent($qualifyingProperties)
      ->setMimeType($mimeType)
      ->setId($id)
      ->setEncoding($encoding);
    //    $xmlObject = new ObjectXsd($qualifyingProperties);
    //    $xmlObject
    //      ->setId($id)
    //      ->setEncoding($encoding)
    //      ->setMimeType($mimeType);
    //    $xmlObject
    //      ->setMimeType($mimeType)
    //      ->setEncoding($encoding)
    //      ->setId($id);
    //    return $xmlObject;
    //$qualifyingProperties = new QualifyingProperties();
    //$qualifyingProperties->setId($id);
    return $xmlObject;
  }

  public function newXMLSignature(
    SignedInfo $si,
    KeyInfo $ki,
    array $objects,
    String $id = NULL,
    SignatureValue $signatureValue = NULL
  ) {
    $xmlSignature = new Signature();
    $xmlSignature
      ->setSignedInfo($si)
      ->setKeyInfo($ki)
      ->setObject($objects)
      ->setId($id);
    if (isset($signatureValue)) {
      $xmlSignature->setSignatureValue($signatureValue);
    }
    //return new \Digipost\Signature\API\XML\XMLSignature($status, $notifications, $pn, $xadesurl);
    //$this->provider->
    //$this->provider->sign();
    return $xmlSignature;
  }

  /**
   * @return XMLDigitalSignatureContext
   */
  public function getProvider(): XMLDigitalSignatureContext {
    return $this->provider;
  }

  public function getXMLSignatureContext() {
    //return $this->container->get('digipost_signature.xml_signature_context');
    return new XMLDigitalSignatureContext();
  }
}

/**
 * Class DigestMethod
 *
 * @package Digipost\Signature\Client\Core\Internal
 *
 * @method static SignatureDigestMethod SHA1
 * @method static SignatureDigestMethod SHA256
 * @method static SignatureDigestMethod SHA512
 * @method static SignatureDigestMethod RIPEMD160
 */
class SignatureDigestMethod extends Enum {

  const SHA1 = ['sha1', 'http://www.w3.org/2000/09/xmldsig#sha1'];

  const SHA256 = ['sha256', 'http://www.w3.org/2001/04/xmlenc#sha256'];

  const SHA512 = ['sha512', 'http://www.w3.org/2001/04/xmlenc#sha512'];

  const RIPEMD160 = ['ripmed160', 'http://www.w3.org/2001/04/xmlenc#ripemd160'];

  function __construct($value) {
    parent::__construct($value);
  }

  public function getValue() {
    return $this->value[0];
  }

  public function getUri() {
    return $this->value[1];
  }

  public function __toString() {
    return (string) $this->value[0];
  }

  public static function fromString($value) {
    return new SignatureDigestMethod($value);
  }
}

/**
 * Class CanonicalizationMethods
 *
 * @package Digipost\Signature\Client\Core\Internal
 *
 * @method static SignatureCanonicalizationMethod C14N
 * @method static SignatureCanonicalizationMethod C14N_COMMENTS
 * @method static SignatureCanonicalizationMethod C14N_EXCLUSIVE
 * @method static SignatureCanonicalizationMethod C14N_EXCLUSIVE_COMMENTS
 */
class SignatureCanonicalizationMethod extends Enum {

  const C14N = XMLDigitalSignatureContext::C14N;

  const C14N_COMMENTS = XMLDigitalSignatureContext::C14N_COMMENTS;

  const C14N_EXCLUSIVE = XMLDigitalSignatureContext::C14N_EXCLUSIVE;

  const C14N_EXCLUSIVE_COMMENTS = XMLDigitalSignatureContext::C14N_EXCLUSIVE_COMMENTS;

  public static function fromString($value) {
    return new SignatureCanonicalizationMethod($value);
  }
}

class NoSuchProviderException extends \Exception {

}

class XMLSignature {

}