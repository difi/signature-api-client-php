<?php

namespace Digipost\Signature\Client\ASiCe\Signature;

use Digipost\Signature\API\XML\CustomBase64BinaryType;
use Digipost\Signature\API\XML\Thirdparty\XAdES\CertIDType;
use Digipost\Signature\API\XML\Thirdparty\XAdES\DataObjectFormat;
use Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType;
use Digipost\Signature\API\XML\Thirdparty\XAdES\QualifyingProperties;
use Digipost\Signature\API\XML\Thirdparty\XAdES\SignedDataObjectProperties;
use Digipost\Signature\API\XML\Thirdparty\XAdES\SignedProperties;
use Digipost\Signature\API\XML\Thirdparty\XAdES\SignedSignatureProperties;
use Digipost\Signature\API\XML\Thirdparty\XAdES\SigningCertificate;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\X509IssuerSerialType;
use Digipost\Signature\Client\Core\Exceptions\CertificateException;
use Digipost\Signature\Client\Core\Exceptions\XmlConfigurationException;
use Digipost\Signature\Client\Core\Internal\Security\X509Certificate;
use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use DOMDocument as Document;
use RobRichards\XMLSecLibs\XMLSecurityDSig;

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
    } catch (CertificateException $e) {
      throw new CertificateException(
        "Unable to get encoded from of certificate",
        $e
      );
    }

    $certificateDigest = new DigestAlgAndValueType();
    $certificateDigest
      ->setDigestValue(new CustomBase64BinaryType($certificateDigestValue))
      ->setDigestMethod($this->sha1DigestMethod);
    try {
      $issuerNameString = sprintf(
        "CN=%s, O=%s, C=%s",
        $certificate->getIssuer()
                    ->getSubjectPart('CN'),
        $certificate->getIssuer()
                    ->getSubjectPart('O'),
        $certificate->getIssuer()->getSubjectPart('C')
      );
    } catch (\Exception $e) {
      throw new CertificateException("Unable to get certificate issuer", $e);
    }
    $certificateIssuer = new X509IssuerSerialType();
    $certificateIssuer
      ->setX509IssuerName($issuerNameString)
      ->setX509SerialNumber($certificate->getSerialNumber());
    $certIDType = new CertIDType();
    $signingCertificate = new SigningCertificate();
    $signingCertificate
      ->addToCert(
        $certIDType
          ->setCertDigest($certificateDigest)
          ->setIssuerSerial($certificateIssuer)
      );

    $now = $this->clock;
    //$now = ZonedDateTime.now(clock);
    $signedSignatureProperties = new SignedSignatureProperties();
    $signedSignatureProperties
      ->setSigningTime($now)
      ->setSigningCertificate($signingCertificate->getCert());;
    $signedDataObjectProperties = new SignedDataObjectProperties();
    $signedDataObjectProperties->setDataObjectFormat(
      $this->dataObjectFormats($files)
    );

    $signedProperties = new SignedProperties();
    $signedProperties
      ->setSignedSignatureProperties($signedSignatureProperties)
      ->setSignedDataObjectProperties($signedDataObjectProperties)
      ->setId("SignedProperties");
    $qualifyingProperties = new QualifyingProperties();
    $qualifyingProperties
      ->setSignedProperties($signedProperties)
      ->setTarget('#Signature');

    //$domResult = new \DOMDocument();
    //$this->marshaller->marshal($qualifyingProperties, $domResult);
    /** @var \DOMDocument $domResult */
    Marshalling::marshal($qualifyingProperties, $domResult);
    //$document = $domResult->firstChild;
    //$domResult->parentNode;
    //    $xPath = new \DOMXPath($domResult);
    //    $query2 = $xPath->evaluate("//*[local-name()='QualifyingProperties']")->item(0);
    $document = new Document();
    $domResultXML = $domResult->saveXML();
    //print "\$domResultXML:\n---------------\n" . $domResultXML . "\n\n";
    $document->loadXML($domResultXML, LIBXML_NSCLEAN | LIBXML_NOCDATA);
    //$document->appendChild($domResult->firstChild);

    // Explicitly mark the SignedProperties Id as an Document ID attribute, so that
    // it will be eligble as a reference for signature. If not, it will not be treated as something to sign.
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
  private function markAsIdProperty(
    Document $document,
    String $elementName,
    String $property
  ) {
    //$xPath = XPathFactory::newInstance()->newXPath();
    $xPath = new \DOMXPath($document);
    try {
      //
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
