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

    if (class_exists('Xsd2PhpExtension')) {
      $container->registerExtension(new Xsd2PhpExtension());
      $container->addCompilerPass(new Xsd2PhpLoaderPass());
    } else {
      $container->registerExtension(new Xsd2PhpPolyfillExtension());
    }

    $root_dir = $container->getParameter(
        'kernel.project_dir'
      ) . '/app/Resources/config';
    $resource = new FileResource($root_dir);
    $container->addResource($resource);
  }
}