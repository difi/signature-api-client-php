<?php

namespace Digipost\Signature\Client\Core\Internal\XML;

use Digipost\Signature\JAXB\SignatureMarshalling;
use Digipost\Signature\JAXB\SignatureObjectConstructor;
use Digipost\Signature\JMS\Handler\Base64BinaryTypeHandler;
use Digipost\Signature\JMS\Handler\CustomAnyTypeHandler;
use Digipost\Signature\JMS\Handler\CustomSimpleTypeHandler;
use Digipost\Signature\JMS\Handler\XmlDateFormatHandler;
use Digipost\Signature\JMS\Handler\XmldSigObjectTypeHandler;
use Digipost\Signature\JMS\Metadata\Driver\DriverFactory;
use Digipost\Signature\JMS\Naming\SigningXMLNamingStrategy;
use Digipost\Signature\JMS\Visitor\ListOfAnyElementDeserialize;
use Digipost\Signature\JMS\Visitor\ListOfAnyElementSerialize;
use Doctrine\Common\Annotations\Reader;
use GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\BaseTypesHandler;
use JMS\Serializer\Builder\CallbackDriverFactory;
use JMS\Serializer\Context;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\HandlerRegistryInterface;
use JMS\Serializer\Naming\CamelCaseNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Marshalling
 *
 * @package Digipost\Signature\Client\Core\Internal\XML
 */
class Marshalling {

  const LIBXML_OPTIONS = LIBXML_DTDATTR | LIBXML_SCHEMA_CREATE | LIBXML_NSCLEAN | LIBXML_NOENT | LIBXML_NOCDATA;

  /** @var ContainerInterface */
  protected $container;

  /** @var \Digipost\Signature\Client\Core\Internal\XML\Marshalling */
  static $INSTANCE;

  /** @var int */
  private $direction;

  public function setContainer(ContainerInterface $container) {
    $this->container = $container;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface|NULL $container
   *
   * @return \Digipost\Signature\Client\Core\Internal\XML\Marshalling
   */
  public static function factory(ContainerInterface $container = NULL) {
    if (!isset(static::$INSTANCE)) {
      static::$INSTANCE = new self();
      static::$INSTANCE->setContainer($container);
    }

    return static::$INSTANCE;
  }

  /**
   * @param SerializerBuilder $builder
   * @param array|NULL        $params
   *
   * @return SerializerBuilder
   */
  public static function configure(
    SerializerBuilder $builder,
    array $params = NULL
  ) {
    $me = Marshalling::factory();

    return $me->_configure($builder, $params);
  }

  /**
   * @param SerializerBuilder $builder
   * @param array|NULL        $params
   *
   * @return SerializerBuilder
   */
  protected function _configure(
    SerializerBuilder $builder,
    array $params = NULL
  ) {
    $config = self::defaultSerializerConfig($params);
    $xsdConfig = $this->container->getParameter(
      'goetas_webservices.xsd2php.config'
    );

    $naming_strategy = new SigningXMLNamingStrategy(
      new SerializedNameAnnotationStrategy(
        new CamelCaseNamingStrategy(
          $config['snake-case'] ? '-' : '',
          !!$config['snake-case']
        )
      )
    );

    $builder
      ->configureHandlers(
      /**
       * @param HandlerRegistryInterface $handler
       */
        function (HandlerRegistryInterface $handler) use ($builder) {
          $builder->addDefaultHandlers();
          $handler->registerSubscribingHandler(new BaseTypesHandler());
          $handler->registerSubscribingHandler(new XmlDateFormatHandler());
          $handler->registerSubscribingHandler(new CustomAnyTypeHandler());
          $handler->registerSubscribingHandler(new CustomSimpleTypeHandler());
          $handler->registerSubscribingHandler(new Base64BinaryTypeHandler());
          $handler->registerSubscribingHandler(new XmldSigObjectTypeHandler());
        }
      )
      ->setAdvancedNamingStrategy($naming_strategy)
      ->addMetadataDirs($xsdConfig['destinations_jms'])
      ->setMetadataDriverFactory(
        new CallbackDriverFactory(
          function (
            array $metaDataDirs,
            Reader $annotationReader
          ) {
            $defaultFactory = new DriverFactory();

            return $defaultFactory->createDriver(
              $metaDataDirs,
              $annotationReader
            );
          }
        )
      );

    if ($this->direction === GraphNavigator::DIRECTION_SERIALIZATION) {
      $builder->setSerializationVisitor(
        'xml',
        new ListOfAnyElementSerialize($naming_strategy)
      );
    }
    if ($this->direction === GraphNavigator::DIRECTION_DESERIALIZATION) {
      $builder->setDeSerializationVisitor(
        'xml',
        new ListOfAnyElementDeserialize($naming_strategy)
      );
    }

    return $builder;
  }

  /**
   * @param Object       $object
   * @param \DOMDocument $output
   * @param Context      $context
   * @param array        $configParams
   *
   * @return mixed|string
   */
  public static function marshal(
    $object,
    \DOMDocument &$output = NULL,
    Context $context = NULL,
    array $configParams = []
  ) {
    $self = Marshalling::factory();
    $self->setDirection(GraphNavigator::DIRECTION_SERIALIZATION);

    /** @var \DOMDocument $output */
    return $self->_marshal($object, $output, $context, $configParams);
  }

  /**
   * @param String $entityStream
   * @param String $responseType
   * @param array  $configParams
   *
   * @return object
   * @throws \JMS\Serializer\Exception\XmlErrorException
   * @throws \JMS\Serializer\Exception\UnsupportedFormatException
   * @throws \JMS\Serializer\Exception\ObjectConstructionException
   */
  public static function unmarshal(
    String $entityStream,
    String $responseType,
    $configParams = []
  ) {
    $self = Marshalling::factory();
    $self->setDirection(GraphNavigator::DIRECTION_DESERIALIZATION);

    return $self->_unmarshal($entityStream, $responseType, $configParams);
  }

  /**
   * @param object       $object
   * @param \DOMDocument $output
   * @param null         $context
   * @param array        $configParams
   *
   * @return mixed|string
   */
  protected function _marshal(
    $object,
    \DOMDocument &$output = NULL,
    $context = NULL,
    $configParams = []
  ) {
    if (!isset($context)) {
      $context = SerializationContext::create();
    }

    $responseClasses = SignatureMarshalling::allApiResponseClasses();

    // All responses from Digipost are snake-cased
    if ($responseClasses->contains(get_class($object)) && !isset($configParams['snake-case'])) {
      $configParams['snake-case'] = TRUE;
    }

    $serializer = $this->_configure(SerializerBuilder::create(), $configParams)
                       ->build();

    // Serialize the object to a XML string
    try {
      $xmlData = $serializer->serialize($object, 'xml', $context);
    } catch (\Symfony\Component\Serializer\Exception\RuntimeException $e) {
      throw $e;
      //throw new \RuntimeException("Serialization error", 0, $e);
    }

    // Make sure we've got a DOMNode instance
    //if (!isset($output)) {
    $output = new \DOMDocument('1.0', 'UTF-8');
    $output->formatOutput = FALSE;
    $output->xmlStandalone = FALSE;
    $output->preserveWhiteSpace = FALSE;

    $output->loadXML($xmlData, self::LIBXML_OPTIONS);
    //DOMUtils::removeWhiteSpace($output);

    //$output->C14N()
    //    DOMUtils::removeWhiteSpace($output);
    //    $output = DOMDocumentFactory::fromString($xmlData);
    //    $output->formatOutput = FALSE;
    //    $output->xmlStandalone = FALSE;

    //    $re = '/(?:(xmlns\:(ns-[a-z0-9]+)))="([^"]+)"/m';
    //    preg_match_all($re, $xmlData, $matches);
    //    if (!empty($matches) && !empty($matches[0])) {
    //      $nsPrefix = $matches[2][0];
    //      $nsUri = $matches[3][0];
    //      $xmlData = strtr($xmlData, ["xmlns:$nsPrefix" => "xmlns", "$nsPrefix:" => ""]);
    //      print "Removed $nsPrefix\n\n";
    //    }
    // Load the XML data in to a DOMDocument ..
    //    $docFragment = new \DOMDocument('1.0', 'UTF-8');
    //    $docFragment->formatOutput = FALSE;
    //    $docFragment->loadXML($xmlData, LIBXML_NOCDATA | LIBXML_NOXMLDECL);

    // .. and append the XML body of that document to our output
    //    $newNode = $output->importNode($docFragment->documentElement, TRUE);
    //    $output->appendChild($newNode);

    //    if (($newOutputXML = $this->cleanNamespaces($output)) !== FALSE) {
    //      //$output = $newOutput;
    //      if ($newOutputXML instanceof \DOMDocument) {
    //        $output = $newOutputXML;
    //      }
    //      else {
    //        $xmlData = $newOutputXML;
    //      }
    //    }

    // Return the raw XMLData for anyone who might want it.
    return $xmlData;
  }

  /**
   * @param $object
   *
   * @return \DOMElement
   */
  public static function toDOMElement($object) {
    /** @var \DOMDocument $domDoc */
    self::marshal($object, $domDoc);

    return $domDoc->documentElement;
  }

  private function cleanNamespaces(
    \DOMDocument $dom,
    $cleanWhitespace = TRUE,
    $object_type = NULL
  ) {
    if ($cleanWhitespace) {
      DOMUtils::removeWhiteSpace($dom);
    }
    $localName = $dom->documentElement->localName;
    if (!in_array($localName, ['Signature'])) {
      return FALSE;
    }

    //$signature = $dom->documentElement->childNodes;
    //DOMUtils::renameDOMElement($dom->documentElement, 'Signature');
    //$dom->documentElement->removeAttributeNS('')
    //DOMUtils::removeDOMNamespace($dom, 'ns2');
    //DOMUtils::removeDOMNamespace($dom, 'default');

    DOMUtils::getDocNamespaces($dom->documentElement);
    //DOMUtils::removeDOMNamespace($dom, 'xsd');
    //$dom->saveXML($dom->documentElement);

    DOMUtils::renameDOMElementNS(
      $dom->documentElement, 'Signature', 'http://www.w3.org/2000/09/xmldsig#', ['Id']
    );

    //$object = DOMUtils::renameDOMElementNS($dom->documentElement->getElementsByTagName('Object')->item(0), 'Object');
    //$dom->documentElement->setAttributeNS('')
    //    $dom->documentElement->setAttributeNS(
    //        'http://www.w3.org/2000/xmlns/',
    //        'xmlns:ns1',
    //        'http://uri.etsi.org/01903/v1.3.2#'
    //      );
    //$dom->saveXML();

    //
    //DOMUtils::removeDOMNamespace($dom, 'xsd');
    $obj = $dom->getElementsByTagName('Object')->item(0);
    DOMUtils::renameDOMElement($obj, 'Object', FALSE);

    //$dom->createElementNS('http://www.w3.org/2000/xmlns/', 'xmlns:')
    //$element = $dom->documentElement->getElementsByTagName('QualifyingProperties')->item(0);
    //$element->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:ns1', 'http://uri.etsi.org/01903/v1.3.2#');
    //$element->setAttribute('xmlns', 'http://uri.etsi.org/01903/v1.3.2#');
    //    DOMUtils::renameDOMElementNS($element, 'QualifyingProperties', 'http://uri.etsi.org/01903/v1.3.2#', TRUE);
    $el = $dom->documentElement->getElementsByTagName('QualifyingProperties')->item(0);
    $el
      ->setAttributeNS(
        'http://www.w3.org/2000/xmlns/', 'xmlns:ns2', 'http://www.w3.org/2000/09/xmldsig#'
      );
    $el
      ->setAttributeNS(
        'http://www.w3.org/2000/xmlns/', 'xmlns', 'http://uri.etsi.org/01903/v1.3.2#'
      );

    //$el = $dom->documentElement->getElementsByTagName('SigningCertificate')->item(0);
    //DOMUtils::renameDOMElement($el, 'SigningCertificate', FALSE);

    //$dom->documentElement->setAttribute('xmlns', 'http://uri.etsi.org/01903/v1.3.2#');
    DOMUtils::removeDOMNamespace($dom, 'xsd');

    //DOMUtils::removeDOMNamespace($dom, 'default');
    return $dom->saveXML($dom->documentElement);

    $namespaces = DOMUtils::getDocNamespaces($dom->documentElement, TRUE);
    $replacements = [];
    foreach ($namespaces as $ns => $uri) {
      if (empty($ns) || !strpos($ns, 'ns-') === -1 || $ns === 'ns2') {
        continue;
      }
      $ret = DOMUtils::removeDOMNamespace($dom, $ns);
      if ($uri === 'http://uri.etsi.org/01903/v1.3.2#') {
        $element = $dom->getElementsByTagName('QualifyingProperties')->item(0);
        $element->removeAttributeNS($uri, $ns);
      }
      if ($uri === 'http://www.w3.org/2000/09/xmldsig#') {
        $element = $dom->getElementsByTagName('Signature')->item(0);
        $element->removeAttributeNS($uri, $ns);
        $element->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:dsig', $uri);
      }
      $replacements["$ns:"] = '';
      $replacements["xmlns:$ns=\""] = 'xmlns="';
    }

    // TODO: This won't work, because LIBXML reassembles the namespace
    // issue on load. Fix: Put the Signatures node in the XAdES wrapper by hand.
    $dom->formatOutput = FALSE;
    $xmlData = strval($dom->saveXML($dom->documentElement));
    array_filter(
      $replacements, function ($k) {
      return !empty($k);
    }, ARRAY_FILTER_USE_KEY
    );
    $xmlData = strtr($xmlData, $replacements);

    if ($localName === 'QualifyingProperties') {
      $newDom = new \DOMDocument();
      $newDom->xmlStandalone = FALSE;
      $newDom->formatOutput = FALSE;
      $newDom->loadXML($xmlData);

      return $newDom;
    }
    $xmlData = str_replace(
      ' xmlns="http://uri.etsi.org/01903/v1.3.2#" Id="Signature"', ' Id="Signature"', $xmlData
    );
    //    $newDom = new \DOMDocument();
    //    $newDom->xmlStandalone = FALSE;
    //    $newDom->formatOutput = FALSE;
    //    $newDom->loadXML($xmlData);

    //$newDom->normalizeDocument();
    return $xmlData;
  }

  /**
   * @param string $entityStream
   * @param string $responseType
   * @param array  $configParams
   *
   * @return object
   *
   * @throws \JMS\Serializer\Exception\XmlErrorException
   * @throws \JMS\Serializer\Exception\UnsupportedFormatException
   * @throws \JMS\Serializer\Exception\ObjectConstructionException
   */
  protected function _unmarshal(
    String $entityStream,
    String $responseType,
    array $configParams = []
  ) {
    $cacheDir = '/tmp/JMS-serializer';
    if (!is_dir($cacheDir)) {
      mkdir($cacheDir);
    }
    $context = DeserializationContext::create();
    //->setAttribute('target', new JAXBElement());

    $objectConstructor = SignatureObjectConstructor::fromClassSet(
      SignatureMarshalling::allApiResponseClasses()
    )->setDocumentType($responseType);

    // All responses from Digipost are snake-cased
    if ($objectConstructor->getSetClasses()->contains($responseType)) {
      $configParams['snake-case'] = TRUE;
    }

    $serializer = $this->_configure(SerializerBuilder::create(), $configParams)
                       ->setObjectConstructor($objectConstructor)
                       ->build();
    $object = $serializer->deserialize(
      $entityStream,
      $responseType,
      'xml',
      $context
    );

    return $object;
  }

  /**
   * @param array $merge
   *
   * @return array
   */
  private static function defaultSerializerConfig(array $merge = []) {
    $merge = isset($merge) ? $merge : [];
    $conf = [
      'snake-case' => FALSE,
    ];

    return array_merge([], $conf, $merge);
  }

  private function setDirection(int $direction) {
    $this->direction = $direction;
  }
}
