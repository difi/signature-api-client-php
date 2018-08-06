<?php
namespace DigipostSignatureBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class Xsd2PhpPolyfillExtension extends Extension {

  /** @inheritdoc */
  public function load(array $configs, ContainerBuilder $container) {
    $configuration = new Xsd2PhpConfiguration();
    $config = $this->processConfiguration($configuration, $configs);
    foreach ($configs as $subConfig) {
      $config = array_merge($config, $subConfig);
    }

    $container->setParameter('goetas_webservices.xsd2php.config', $config);
  }

  /** @inheritdoc */
  public function getAlias() {
    return 'xsd2php';
  }
}