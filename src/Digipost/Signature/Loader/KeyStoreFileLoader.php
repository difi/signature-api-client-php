<?php

namespace Digipost\Signature\Loader;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class KeyStoreFileLoader {

  protected $container;

  protected $filename;

  protected $fullPath;

  public function __construct(String $fullPath) {
    $this->fullPath = $fullPath;
  }

  public static function loader(
    ContainerInterface $container,
    String $filename
  ) {
    $kernel = $container->get('kernel');
    $path = $filename;
    if (!empty($filename) && $filename[0] === '@') {
      $path = $kernel->locateResource($filename);
    }
    if (!file_exists($path)) {
      throw new FileNotFoundException(
        'KeyStore file "' . $path . '" not found'
      );
    }
    return new KeyStoreFileLoader($path);
  }

  public function load() {
    return file_get_contents($this->fullPath);
  }
}