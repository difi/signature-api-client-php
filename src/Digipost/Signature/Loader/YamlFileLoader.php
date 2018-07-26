<?php

namespace DigipostSignatureBundle\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

class YamlFileLoader extends FileLoader {

  /**
   * @inheritdoc
   */
  public function load($resource, $type = NULL) {
    $path = $this->locator->locate($resource);

    $config = Yaml::parse($path);

    // empty file
    if (NULL === $config) {
      $config = [];
    }

    // not an array
    if (!is_array($config)) {
      throw new \InvalidArgumentException(
        sprintf('The file "%s" must contain a YAML array.', $resource)
      );
    }

    return $config;
  }

  /**
   * @inheritdoc
   */
  public function supports($resource, $type = NULL) {
    return is_string($resource) && 'yml' === pathinfo(
        $resource, PATHINFO_EXTENSION
      ) && (!$type || 'yaml' === $type);
  }
}