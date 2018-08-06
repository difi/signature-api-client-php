<?php
namespace DigipostSignatureBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Xsd2PhpConfiguration implements ConfigurationInterface {

  /** @inheritdoc */
  public function getConfigTreeBuilder() {
    $treeBuilder = new TreeBuilder();
    $rootNode = $treeBuilder->root('xsd2php');

    $rootNode
      ->children()
        ->scalarNode('naming_strategy')
          ->defaultValue('short')
        ->end()
        ->scalarNode('path_generator')
          ->defaultValue('psr4')
        ->end()
        ->arrayNode('namespaces')->fixXmlConfig('namespace')
          ->isRequired()
          ->requiresAtLeastOneElement()
          ->prototype('scalar')
          ->end()
        ->end()
        ->arrayNode('known_locations')->fixXmlConfig('known_location')
          ->prototype('scalar')
          ->end()
        ->end()
          ->arrayNode('destinations_php')->fixXmlConfig('destination')
          ->isRequired()
          ->requiresAtLeastOneElement()
          ->prototype('scalar')
          ->end()
        ->end()
        ->arrayNode('destinations_jms')->fixXmlConfig('destination')
          ->isRequired()
          ->requiresAtLeastOneElement()
          ->prototype('scalar')
          ->end()
        ->end()
          ->arrayNode('aliases')->fixXmlConfig('alias')
          ->prototype('array')
            ->prototype('scalar')
            ->end()
          ->end()
        ->end()
      ->end();
    return $treeBuilder;
  }
}