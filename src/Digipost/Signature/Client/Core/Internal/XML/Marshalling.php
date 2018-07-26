<?php

namespace Digipost\Signature\Client\Core\Internal\XML;

use Digipost\Signature\JAXB\JAXBElement;
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
   * @param Object $object
   * @param \DOMDocument $output
   * @param Context $context
   * @param array $configParams
   *
   * @return mixed|string
   */
  public static function marshal(
    $object,
    &$output,
    Context $context = NULL,
    array $configParams = []
  ) {
    $self = Marshalling::factory();
    $self->setDirection(GraphNavigator::DIRECTION_SERIALIZATION);

    return $self->_marshal($object, $output, $context, $configParams);
  }

  /**
   * @param       $entityStream
   * @param       $responseType
   * @param array $configParams
   *
   * @return array|\JMS\Serializer\scalar|mixed|object
   */
  public static function unmarshal(
    $entityStream,
    $responseType,
    $configParams = []
  ) {
    $self = Marshalling::factory();
    $self->setDirection(GraphNavigator::DIRECTION_DESERIALIZATION);

    return $self->_unmarshal($entityStream, $responseType, $configParams);
  }

  /**
   * @param       $object
   * @param       $output
   * @param null  $context
   * @param array $configParams
   *
   * @return mixed|string
   */
  protected function _marshal(
    $object,
    &$output,
    $context = NULL,
    $configParams = []
  ) {

    // Make sure we've got a DOMNode instance
    if (!isset($output)) {
      $output = new \DOMDocument('1.0', 'UTF-8');
      $output->xmlStandalone = FALSE;
    }

    if (!isset($context)) {
      $context = SerializationContext::create();
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

    // Load the XML data in to a DOMDocument ..
    $docFragment = new \DOMDocument();
    $docFragment->loadXML($xmlData, LIBXML_NOCDATA | LIBXML_NOXMLDECL);

    // .. and append the XML body of that document to our output
    $newNode = $output->importNode($docFragment->documentElement, TRUE);
    $output->appendChild($newNode);

//    if (!($newOutput = $this->cleanNamespaces($output))) {
//      $output = $newOutput;
//    }

    // Return the raw XMLData for anyone who might want it.
    return $xmlData;
  }


  private function cleanNamespaces(\DOMDocument $dom, $cleanWhitespace = TRUE) {
    if ($cleanWhitespace) {
      DOMUtils::removeWhiteSpace($dom);
    }
    $namespaces = DOMUtils::getDocNamespaces($dom);
    $replacements = [];
    foreach ($namespaces as $ns => $uri) {
      if (empty($ns) || !strpos($ns, 'ns-') === -1) {
        continue;
      }
      DOMUtils::removeDOMNamespace($dom, $ns);
      $replacements["xmlns:$ns"] = 'xmlns';
      if ($uri === 'http://uri.etsi.org/01903/v1.3.2#') {
        //$element = $xmlOutput->documentElement->getElementsByTagName('QualifyingProperties')->item(0);
        //$element->removeAttributeNS($uri, $ns);
      }
      if ($uri === 'http://www.w3.org/2000/09/xmldsig#') {
        //$element = $xmlOutput->documentElement->getElementsByTagName('Signature')->item(0);
        //$element->removeAttributeNS($uri, $ns);
        //$element->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:dsig', $uri);
      }
    }

    // TODO: This won't work, because LIBXML reassembles the namespace
    // issue on load. Fix: Put the Signatures node in the XAdES wrapper by hand.
    $xmlData = $dom->saveXML();
    $xmlData = strtr($xmlData, $replacements);

    $newDom = new \DOMDocument();
    $newDom->xmlStandalone = FALSE;
    $newDom->formatOutput = FALSE;
    $newDom->loadXML($xmlData);
    //$newDom->normalizeDocument();
    return $newDom;
  }


  /**
   * @param       $entityStream
   * @param       $responseType
   * @param array $configParams
   *
   * @return array|\JMS\Serializer\scalar|mixed|object
   */
  protected function _unmarshal(
    $entityStream,
    $responseType,
    $configParams = []
  ) {

    ///$marshaller = Marshalling::createInstance();

    //$SignatureJaxb2Marshaller->ForResponsesOfAllApis->singleton()->unmarshal(new StreamSource($entityStream));
    //SignatureMarshalling::allApiResponseClasses()->
    //$objectConstructor = new S
    $cacheDir = '/tmp/JMS-serializer';
    if (!is_dir($cacheDir)) {
      mkdir($cacheDir);
    }
    $context = DeserializationContext::create()
                                     ->setAttribute(
                                       'target', new JAXBElement()
                                     );

    //    $serializerBuilder = SerializerBuilder::create();
    //    $serializer = $serializerBuilder
    //      ->configureHandlers(function (HandlerRegistryInterface $h) use (
    //        $serializerBuilder
    //      ) {
    //        $serializerBuilder->addDefaultHandlers();
    //        //$serializerBuilder->addDefaultDeserializationVisitors();
    //        $h->registerSubscribingHandler(new XmlSchemaKeyInfoHandler());
    //      })
    //      ->setObjectConstructor(SignatureObjectConstructor::fromClassSet(SignatureMarshalling::allApiResponseClasses())
    //                               ->setDocumentType($responseType))
    //      //->setCacheDir('/tmp/JMS-serializer')
    //      ->setDebug(TRUE)
    //      //->setAdvancedNamingStrategy(AdvancedNamingStrategyInterface::class)
    //      //->setPropertyNamingStrategy($naming_strategy)
    //      ->setAdvancedNamingStrategy($naming_strategy)
    //      ->build();
    //    $serializer = Marshalling::configure(SerializerBuilder::create(),
    //                                         $configParams)->build();
    $serializer = $this->_configure(SerializerBuilder::create(), $configParams)
                       ->setObjectConstructor(
                         SignatureObjectConstructor::fromClassSet(
                           SignatureMarshalling::allApiResponseClasses()
                         )
                                                   ->setDocumentType(
                                                     $responseType
                                                   )
                       )
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
