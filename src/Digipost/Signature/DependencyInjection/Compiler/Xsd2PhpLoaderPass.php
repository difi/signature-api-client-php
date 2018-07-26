<?php

namespace DigipostSignatureBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Xsd2PhpLoaderPass implements CompilerPassInterface {

  /**
   * @inheritdoc
   */
  public function process(ContainerBuilder $container) {
    //$config = $container->getExtensionConfig('xsd2php');

  }
}