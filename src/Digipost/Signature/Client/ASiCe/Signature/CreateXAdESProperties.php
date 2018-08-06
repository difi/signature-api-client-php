<?php

namespace Digipost\Signature\Client\ASiCe\Signature;

use Digipost\Signature\API\XML\Thirdparty\XAdES\DataObjectFormat;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod;
use Digipost\Signature\Client\ASiCe\ASiCEAttachable;
use Digipost\Signature\Client\Core\Exceptions\CertificateException;
use Digipost\Signature\Client\Core\Exceptions\XmlConfigurationException;
use Digipost\Signature\Client\Core\Internal\Security\X509Certificate;
use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use DOMDocument as Document;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use Digipost\Signature\Client\Core\Internal\Security\Constants as C;
use Digipost\Signature\Client\Core\Internal\Security\Signature;

/**
 * Class CreateXAdESProperties
 *
 * @package Digipost\Signature\Client\ASiCe\Signature
 */
class CreateXAdESProperties {

  private $sha1DigestMethod;

  private $clock;

  private static $marshaller;

  function __staticInit() {
    self::$marshaller = new Marshalling();
  }

  /**
   * CreateXAdESProperties constructor.
   *
   * @param \DateTime $clock
   */
  function __construct(\DateTime $clock) {
    $this->sha1DigestMethod = new DigestMethod();
    $this->sha1DigestMethod->setAlgorithm(XMLSecurityDSig::SHA1);
    $this->clock = $clock;
  }

  /**
   * @param Signature               $signature
   * @param array                   $files
   * @param X509Certificate $certificate
   *
   * @return \DOMElement
   */
  function createPropertiesToSign(Signature $signature, array $files, X509Certificate $certificate) {
    $certificateDigestValue = NULL;
    try {
      $signature->addX509Certificates($certificate, FALSE, C::DIGEST_SHA1, TRUE);
    } catch (CertificateException $e) {
      throw new CertificateException(
        "Unable to get encoded from of certificate",
        $e
      );
    }

    // Explicitly mark the SignedProperties Id as an Document ID attribute, so that
    // it will be eligble as a reference for signature. If not, it will not be treated as something to sign.
    // self::markAsIdProperty($domResult, "SignedProperties", "Id");

    $signature->setSigningTime($this->clock);

    /** @var ASiCEAttachable[] $files */
    foreach ($files as $i => $file) {
      $id = sprintf("ID_%s", $i);
      $signature->addSignedDataObjectFormat($id, $file->getFileName(), $file->getMimeType(), $file->getBytes());
    }

    $spNode = $signature->getSignedPropertiesNode();
    $signature->addReference($spNode, C::DIGEST_SHA256, [C::C14N_INCLUSIVE_WITHOUT_COMMENTS], [
      //'prefix_ns' => C::XADESNS,
      'overwrite' => false,
      'type' => 'http://uri.etsi.org/01903#SignedProperties',
    ]);

    return $spNode;
  }

  /**
   * @param array $files
   *
   * @return array
   */
  private function dataObjectFormats(array $files) {
    $result = [];
    for ($i = 0; $i < sizeof($files); $i++) {
      $signatureElementIdReference = sprintf("ID_%s", $i);
      $objectFormat = new DataObjectFormat();
      $objectFormat
        ->setMimeType($files[$i]->getMimeType())
        //->setObjectIdentifier()
        ->setObjectReference($signatureElementIdReference);

      array_push($result, $objectFormat);
    }
    return $result;
  }

  /**
   * @param Document $document
   * @param String   $elementName
   * @param String   $property
   */
  public static function markAsIdProperty(
    Document $document,
    String $elementName,
    String $property
  ) {
    //$xPath = XPathFactory::newInstance()->newXPath();
    $xPath = new \DOMXPath($document);
    try {
      /** @var \DOMNodeList $idElement */
      $idElements = $xPath->evaluate(
        "//*[local-name()='" . $elementName . "']"
      );
      foreach ($idElements as $element) {
        /** @var \DOMElement $element */
        $element->setIdAttribute($property, TRUE);
      }
    } catch (\Exception $e) {
      throw new XmlConfigurationException("XPath on generated XML failed.", $e);
    }
  }
}
