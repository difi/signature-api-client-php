<?php

namespace Digipost\Signature\Client\ASiCe\Signature;

use Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType;
use Digipost\Signature\API\XML\Thirdparty\XAdES\DataObjectFormat;
use Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType;
use Digipost\Signature\API\XML\Thirdparty\XAdES\QualifyingProperties;
use Digipost\Signature\API\XML\Thirdparty\XAdES\SignedDataObjectProperties;
use Digipost\Signature\API\XML\Thirdparty\XAdES\SignedProperties;
use Digipost\Signature\API\XML\Thirdparty\XAdES\SignedSignatureProperties;
use Digipost\Signature\API\XML\Thirdparty\XAdES\SigningCertificate;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\X509IssuerSerialType;
use Digipost\Signature\Client\Core\Exceptions\CertificateException;
use Digipost\Signature\Client\Core\Exceptions\XmlConfigurationException;
use Digipost\Signature\Client\Core\Internal\Security\X509Certificate;
use \DOMDocument as Document;
use Digipost\Signature\Client\Core\Internal\XML\Marshalling;

/**
 * Class CreateXAdESProperties
 *
 * @package Digipost\Signature\Client\ASiCe\Signature
 */
class CreateXAdESProperties {

  private $sha1DigestMethod; //  = new DigestMethod(emptyList(), SHA1)

  private $clock;

  private static $marshaller;

  //    static {
//          marshaller = new Jaxb2Marshaller();
  //        marshaller.setClassesToBeBound(QualifyingProperties.class);
  //    }

  function __staticInit() {
    self::$marshaller = new Marshalling();
  }

  /**
   * CreateXAdESProperties constructor.
   *
   * @param \DateTime $clock
   */
  function __construct(\DateTime $clock) {
    $this->clock = $clock;
  }

  /**
   * @param $value
   *
   * @return array
   */
  private function singletonList($value) {
    $list = [];
    $list[] = $value;
    return $list;
  }

  /**
   * @param array           $files
   * @param X509Certificate $certificate
   *
   * @return Document
   */
  function createPropertiesToSign(array $files, X509Certificate $certificate) {
    $certificateDigestValue = NULL;
    try {
      $certificateEncoded = $certificate->getClearText();
      $certificateDigestValue = sha1($certificateEncoded);
    } catch (CertificateEncodingException $e) {
      throw new CertificateException("Unable to get encoded from of certificate",
                                     $e);
    }

    $certificateDigest = new DigestAlgAndValueType($this->sha1DigestMethod,
                                                   $certificateDigestValue);


    $certificateIssuer = new X509IssuerSerialType($certificate->getIssuer()->getCommonName(),
                                                  $certificate->getSerialNumber());
    $signingCertificate = new SigningCertificate($this->singletonList(new CertIDType($certificateDigest,
                                                                              $certificateIssuer,
                                                                              NULL)));

    $now = $this->clock;
    //$now = ZonedDateTime.now(clock);
    $signedSignatureProperties = new SignedSignatureProperties($now,
                                                               $signingCertificate,
                                                               NULL, NULL, NULL,
                                                               NULL);
    $signedDataObjectProperties = new SignedDataObjectProperties($this->dataObjectFormats($files),
                                                                 NULL, NULL,
                                                                 NULL, NULL);
    $signedProperties = new SignedProperties($signedSignatureProperties,
                                             $signedDataObjectProperties,
                                             "SignedProperties");
    $qualifyingProperties = new QualifyingProperties($signedProperties, NULL,
                                                     "#Signature", NULL);

    //$domResult = new \DOMDocument();
    //$this->marshaller->marshal($qualifyingProperties, $domResult);
    $domResult = NULL;
    Marshalling::marshal($qualifyingProperties, $domResult);
    $document = clone $domResult;
    /** @var \DOMDocument $domResult */
    //$document = new Document();
    //$document->appendChild($domResult->firstChild);

    // Explicitly mark the SignedProperties Id as an Document ID attribute, so that it will be eligble as a reference for signature.
    // If not, it will not be treated as something to sign.
    $this->markAsIdProperty($document, "SignedProperties", "Id");

    return $document;
  }

  /**
   * @param array $files
   *
   * @return array
   */
  private function dataObjectFormats(array $files) {
    $result = [];
    for ($i = 0; $i < sizeof($files); $i++) {
      $signatureElementIdReference = sprintf("#ID_%s", $i);
      array_push($result,
                 new DataObjectFormat(NULL, NULL, $files[$i]->getMimeType(),
                                      NULL, $signatureElementIdReference));
    }
    return $result;
  }

  /**
   * @param Document $document
   * @param String   $elementName
   * @param String   $property
   */
  private function markAsIdProperty(Document $document, String $elementName,
                                    String $property) {
    //$xPath = XPathFactory::newInstance()->newXPath();
    $xPath = new \DOMXPath($document);
    try {
      //
      /** @var \DOMNodeList $idElement */
      $idElements = $xPath->evaluate("//*[local-name()='" . $elementName . "']");
      foreach ($idElements as $element) {
        /** @var \DOMElement $element */
        $element->setIdAttribute($property, TRUE);
      }
    } catch (\Exception $e) {
      throw new XmlConfigurationException("XPath on generated XML failed.", $e);
    }
  }
}
