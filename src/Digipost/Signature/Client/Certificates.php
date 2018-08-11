<?php

namespace Digipost\Signature\Client;

use MyCLabs\Enum\Enum;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Certificates
 *
 * @package Digipost\Signature\Client
 *
 * @method static Certificates INIT
 * @method static Certificates TEST
 * @method static Certificates PRODUCTION
 */
class Certificates extends Enum {

  const INIT = [];

  const TEST = [
    "test/Buypass_Class_3_Test4_CA_3.cer",
    "test/Buypass_Class_3_Test4_Root_CA.cer",
    "test/commfides_test_ca.cer",
    "test/commfides_test_root_ca.cer",
  ];

  const PRODUCTION = [
    "prod/BPClass3CA3.cer",
    "prod/BPClass3RootCA.cer",
    "prod/commfides_ca.cer",
    "prod/commfides_root_ca.cer",
  ];

  public function certificatePaths() {
    $className = get_called_class();
    $basePath = '';
    if (isset(static::$cache[$className]) && isset(static::$cache[$className]['basePath'])) {
      $basePath = static::$cache[$className]['basePath'];
    }
    return array_map(
      function ($value) use ($basePath) {
        return $basePath . '/' . $value;
      },
      $this->value
    );
  }

  public function getCABundle() {
    $className = get_called_class();
    $bundlePath = '';
    if (isset(static::$cache[$className]) && isset(static::$cache[$className]['bundlePath'])) {
      $bundlePath = static::$cache[$className]['bundlePath'];
    }
    return $bundlePath . '/' . strtolower($this->getKey()) . '/ca-bundle.pem';
  }

  public function setRootDir(String $basePath) {
    $cache = &static::$cache;
    $cache[get_called_class()]['basePath'] = $basePath;
    return $cache;
  }
  public function setBundleDir(String $bundleDir) {
    $cache = &static::$cache;
    $cache[get_called_class()]['bundlePath'] = $bundleDir;
    return $cache;
  }

  public static function build(ContainerInterface $container, String $path) {
    $resolvedPath = $path;
    if (!empty($path) && $path[0] === '@') {
      $resolvedPath = $container->get('kernel')->locateResource($path);
    }
    $bundlePath = $container->getParameter('digipost_signature.ca_bundle.path');
    $self = Certificates::INIT();
    $self->setRootDir($resolvedPath);
    $self->setBundleDir($bundlePath);
    return $self;
  }
}
