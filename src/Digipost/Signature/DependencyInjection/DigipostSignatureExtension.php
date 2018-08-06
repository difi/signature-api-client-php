<?php

namespace DigipostSignatureBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class DigipostSignatureExtension extends Extension {

  public function load(array $configs, ContainerBuilder $container) {
    $yaml = new YamlFileLoader(
      $container,
      new FileLocator(__DIR__ . '/../Resources/config')
    );
    $yaml->load('services.yml');

    $configuration = new Configuration();
    $config = $this->processConfiguration($configuration, $configs);

    $recursive_remove = function (array $array) use (&$recursive_remove) {
      foreach ($array as $k => $v) {
        if (is_array($v)) {
          $array[$k] = $recursive_remove($v);
        }
        else {
          if ($array[$k] === NULL) {
            unset($array[$k]);
          }
        }
      }
      return $array;
    };

    $configs = $recursive_remove($configs);
    foreach ($configs as $subConfig) {
      $config = array_replace_recursive($config, $subConfig);
    }

    $container->setParameter(
      'digipost_signature.keystore.filename', $config['keystore']['filename']
    );
    $container->setParameter(
      'digipost_signature.keystore.password', $config['keystore']['password']
    );
    $container->setParameter(
      'digipost_signature.keystore.key.alias',
      $config['keystore']['key']['alias']
    );
    $container->setParameter(
      'digipost_signature.keystore.key.password',
      $config['keystore']['key']['password']
    );
    $container->setParameter(
      'digipost_signature.keystore.ca_path', $config['keystore']['ca_path']
    );
    $container->setParameter(
      'digipost_signature.keystore.client_cert',
      $config['keystore']['client_cert']
    );
  }

  protected static function sanitizePhp($ns) {
    return strtr($ns, '/', '\\');
  }

  public function getAlias() {
    return 'digipost_signature';
  }
}
