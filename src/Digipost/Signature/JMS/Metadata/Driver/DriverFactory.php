<?php

namespace Digipost\Signature\JMS\Metadata\Driver;

use Doctrine\Common\Annotations\Reader;
use JMS\Serializer\Builder\DriverFactoryInterface;
use JMS\Serializer\Metadata\Driver\XmlDriver;
use JMS\Serializer\Metadata\Driver\YamlDriver;
use Metadata\Driver\DriverChain;
use Metadata\Driver\FileLocator;

class DriverFactory implements DriverFactoryInterface {

  public function createDriver(array $metadataDirs, Reader $annotationReader) {
    if (!empty($metadataDirs)) {
      $fileLocator = new FileLocator($metadataDirs);

      return new DriverChain(
        [
          new YamlDriver($fileLocator),
          new XmlDriver($fileLocator),
          new XmlElementRefsAnnotationDriver($annotationReader),
        ]
      );
    }

    return new XmlElementRefsAnnotationDriver($annotationReader);
  }
}
