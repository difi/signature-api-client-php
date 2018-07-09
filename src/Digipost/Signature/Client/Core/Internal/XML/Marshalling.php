<?php

namespace Digipost\Signature\Client\Core\Internal\XML;

use GuzzleHttp\Psr7\AppendStream;
use JMS\Serializer\SerializerBuilder;
use phpDocumentor\Reflection\Types\Resource_;

/**
 * Class Marshalling
 *
 * @package Digipost\Signature\Client\Core\Internal\XML
 */
final class Marshalling {

  function __construct() {
  }

  public static function marshal($object, &$output, $context = NULL, $naming_strategy = NULL) {
    // Make sure we've got a DOMNode instance
    if (!isset($output)) {
      $output = new \DOMDocument();
    }
    if (!isset($naming_strategy)) {
      $naming_strategy = new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(
        new \JMS\Serializer\Naming\CamelCaseNamingStrategy('', FALSE)
      );
    }

    // Set up our serializer
    $serializer = SerializerBuilder::create()
      ->setPropertyNamingStrategy($naming_strategy)
      ->build();

    // Serialize the object to a XML string
    $xmlData = $serializer->serialize($object, 'xml', $context);

    // Load the XML data in to a DOMDocument ..
    $docFragment = new \DOMDocument();
    $docFragment->loadXML($xmlData, LIBXML_NOCDATA | LIBXML_NOXMLDECL);

    // .. and append the XML body of that document to our output
    $newNode = $output->importNode($docFragment->documentElement, TRUE);
    $output->appendChild($newNode);

    // Return the raw XMLData for anyone who might want it.
    return $xmlData;
  }

  public static function unmarshal($entityStream) // [InputStream entityStream]
  {
    //$SignatureJaxb2Marshaller->ForResponsesOfAllApis->singleton()->unmarshal(new StreamSource($entityStream));
  }
}

