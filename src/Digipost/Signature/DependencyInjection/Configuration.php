<?php

namespace DigipostSignatureBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

  public function getConfigTreeBuilder() {
    $treeBuilder = new TreeBuilder();

    $ca_path = '@DigipostSignatureBundle/Resources/certificates';
    $client_cert_path = 'app/Resources/config/client.pem';

    $rootNode = $treeBuilder->root('digipost_signature');
    $rootNode
      ->children()
        ->arrayNode('keystore')
          ->children()
            ->scalarNode('filename')->isRequired()->end()
            ->scalarNode('password')->isRequired()->end()
            ->arrayNode('key')
              ->children()
                ->scalarNode('alias')->isRequired()->end()
                ->scalarNode('password')->isRequired()->end()
              ->end()
            ->end()
            ->scalarNode('ca_path')->defaultValue($ca_path)->treatNullLike($ca_path)->end()
            ->scalarNode('client_cert')->defaultValue($client_cert_path)->isRequired()->end()
          ->end()
        ->end()
        ->arrayNode('client')
          ->children()
            ->scalarNode('organisation_number')->isRequired()->end()
          ->end()
        ->end()
      ->end()
    ;
    return $treeBuilder;
  }
}
