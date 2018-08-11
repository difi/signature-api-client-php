<?php

namespace DigipostSignatureBundle;

use DigipostSignatureBundle\DependencyInjection\Compiler\Xsd2PhpLoaderPass;
use DigipostSignatureBundle\DependencyInjection\Xsd2PhpPolyfillExtension;
use GoetasWebservices\Xsd\XsdToPhp\DependencyInjection\Xsd2PhpExtension;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DigipostSignatureBundle extends Bundle {

  /**
   * @inheritdoc
   */
  public function build(ContainerBuilder $container) {
    parent::build($container);

    $serializer_dir = __DIR__ . '/Resources/config/serializer';
    $serializer_php_dir = __DIR__ . '/API/XML';
    $container->setParameter('digipost_signature.serializer_config_dir', $serializer_dir);
    $container->setParameter('digipost_signature.serializer_php_dir', $serializer_php_dir);

    try {
      $container->registerExtension(new Xsd2PhpExtension());
      $container->addCompilerPass(new Xsd2PhpLoaderPass());
    } catch (\Exception $e) {
      $container->registerExtension(new Xsd2PhpPolyfillExtension());
    }

    $root_dir = $container->getParameter(
        'kernel.project_dir'
      ) . '/app/Resources/config';
    if (file_exists($root_dir)) {
      $resource = new FileResource($root_dir);
      $container->addResource($resource);
    }
  }
}
