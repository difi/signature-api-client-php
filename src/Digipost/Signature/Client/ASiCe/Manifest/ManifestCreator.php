<?php

namespace Digipost\Signature\Client\ASiCe\Manifest;

use Digipost\Signature\Client\Core\Exceptions\RuntimeIOException;
use Digipost\Signature\Client\Core\Exceptions\XmlValidationException;
use Digipost\Signature\Client\Core\Internal\XML\DOMUtils;
use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use Digipost\Signature\Client\Core\Sender;
use Digipost\Signature\Client\Core\SignatureJob;
use Digipost\Signature\Client\Direct\DirectJob;
use Digipost\Signature\Client\Portal\PortalJob;
use JMS\Serializer\Exception\UnsupportedFormatException;
use function GuzzleHttp\Psr7\stream_for;

/**
 * Class ManifestCreator
 *
 * @package Digipost\Signature\Client\ASiCe\Manifest
 */
abstract class ManifestCreator {

  /**
   * @param PortalJob|DirectJob|SignatureJob $job
   * @param Sender                           $sender
   *
   * @return Manifest
   */
  public function createManifest($job, Sender $sender) {
    $xmlManifest = $this->buildXmlManifest($job, $sender);

    try {
//      $xmlNode = new \DOMDocument('1.0', 'UTF-8');
//      $xmlNode->xmlStandalone = FALSE;
      Marshalling::marshal(
        $xmlManifest, $xmlNode, NULL, ['snake-case' => TRUE]
      );
      /** @var \DOMDocument $xmlNode */
      $xmlNode->xmlStandalone = TRUE;
      DOMUtils::removeWhiteSpace($xmlNode);
      $xmlData = $xmlNode->saveXML($xmlNode->documentElement, LIBXML_NOCDATA);
      $xmlData = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "" . $xmlData;
      return new Manifest($xmlData);
      //$manifestBytes = unpack('C*', $manifestStream);
      //return new Manifest($manifestBytes);
    } catch (UnsupportedFormatException $e) {
      throw new XmlValidationException(
        "Unable to validate generated Manifest XML. " .
        "This typically happens if one or more values are not in accordance with the XSD. " .
        "You may inspect the cause (by calling getCause()) to see which constraint has been violated.",
        $e
      );
    } catch (\Exception $e) {
      throw new RuntimeIOException($e);
    }
  }

  abstract function buildXmlManifest($job, Sender $sender);
}
