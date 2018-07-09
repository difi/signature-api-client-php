<?php

namespace Digipost\Signature\Client\Core\Internal;

use Digipost\Signature\API\XML\Thirdparty\XMLdSig\CanonicalizationMethod;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\KeyInfo;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\XMLObject;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\Reference;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\Signature;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureMethod;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignedInfo;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transforms;
use MyCLabs\Enum\Enum;
use XmlDsig\XmlDigitalSignature;

class XMLSignatureFactory {

  static $PROVIDERS = [
    "XMLdSig" => XmlDigitalSignature::class,
  ];

  /** @var XmlDigitalSignature */
  protected $provider;

  //function __construct() {
  //$dsig = new XmlDigitalSignature();
  //}

  public static function getInstance(String $mechanismType,
                                     String $provider = NULL) {
    if (!isset($provider)) {
      $provider = 'XMLdSig';
    }
    else {
      if (!isset(self::$PROVIDERS[$provider])) {
        throw new NoSuchProviderException("No such provider: " . $provider);
      }
    }

    $factory = new XMLSignatureFactory();
    $factory->provider = new self::$PROVIDERS[$provider]();

    return $factory;
  }


  public function getKeyInfoFactory() {

  }

  /**
   * @param String $algorithm
   * @param null   $params
   *
   * @return DigestMethod
   */
  public function newDigestMethod(String $algorithm, $params = NULL) {
    $this->provider->setDigestMethod($algorithm);
    $digestMethod = new DigestMethod(NULL, $algorithm);
    //return SignatureDigestMethod::fromString($algorithm);
    return $digestMethod;
  }

  /**
   * @param String $algorithm
   * @param null   $params
   *
   * @return CanonicalizationMethod
   */
  public function newCanonicalizationMethod(String $algorithm, $params = NULL) {
    $this->provider->setCanonicalMethod($algorithm);

    //return SignatureCanonicalizationMethod::fromString($algorithm);
    $canonicalizationMethod = new CanonicalizationMethod(NULL, $algorithm);
    return $canonicalizationMethod;
  }

  public function newSignatureMethod(String $method, $params = NULL) {
    $signatureMethod = new SignatureMethod($params, $method);
    // TODO: implement
    //$this->provider->setSignatureMethod($method, $params);
    return $signatureMethod;
  }


  public function newTransform(String $algorithm, $params = NULL) {
    $transform = new Transform([], $algorithm);
    return $transform;
  }

  /**
   * @param String                 $uri
   * @param DigestMethod           $digestMethod
   * @param Transforms | Transform $transforms
   * @param String                 $type
   * @param String                 $id
   * @param String                 $digestValue
   *
   * @return Reference
   */
  public function newReference(String $uri = NULL,
                               DigestMethod $digestMethod = NULL,
                               $transforms = NULL,
                               String $type = NULL,
                               String $id = NULL,
                               $digestValue = NULL
  ) {
    //$node = new \DOMDocument();
    //$this->provider->addReference($node, $uri);
    if (isset($transforms) && $transforms instanceof Transform) {
      $transforms = new Transforms([$transforms]);
    }
    $reference = new Reference($transforms, $digestMethod, $digestValue, $id,
                               $uri, $type);
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
  public function newSignedInfo(CanonicalizationMethod $cm,
                                SignatureMethod $sm,
                                array $references,
                                String $id = NULL) {

    $signedInfo = new SignedInfo($cm, $sm, $references, $id);

    return $signedInfo;
  }

  /**
   * @param array  $content
   * @param String $id
   * @param String $mimeType
   * @param String $encoding
   *
   * @return Object
   */
  public function newXMLObject(array $content = NULL, String $id = NULL,
                               String $mimeType = NULL,
                               String $encoding = NULL) {

    $xmlObject = new XMLObject($content, $id, $mimeType, $encoding);
    return $xmlObject;
  }

  public function newXMLSignature(SignedInfo $si, KeyInfo $ki, array $objects,
                                  String $id, String $signatureValueId = NULL) {

    $xmlSignature = new Signature($si, $signatureValueId, $ki, $objects, $id);
    //return new \Digipost\Signature\API\XML\XMLSignature($status, $notifications, $pn, $xadesurl);
    //$this->provider->
    $this->provider->sign();
    return $xmlSignature;
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

  const SHA1 = XmlDigitalSignature::DIGEST_SHA1;

  const SHA256 = XmlDigitalSignature::DIGEST_SHA256;

  const SHA512 = XmlDigitalSignature::DIGEST_SHA512;

  const RIPEMD160 = XmlDigitalSignature::DIGEST_RIPEMD160;

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

  const C14N = XmlDigitalSignature::C14N;

  const C14N_COMMENTS = XmlDigitalSignature::C14N_COMMENTS;

  const C14N_EXCLUSIVE = XmlDigitalSignature::C14N_EXCLUSIVE;

  const C14N_EXCLUSIVE_COMMENTS = XmlDigitalSignature::C14N_EXCLUSIVE_COMMENTS;

  public static function fromString($value) {
    return new SignatureCanonicalizationMethod($value);
  }
}

class NoSuchProviderException extends \Exception {

}


class XMLSignature {

}