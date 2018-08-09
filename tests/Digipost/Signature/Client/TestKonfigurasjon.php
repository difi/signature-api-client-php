<?php

namespace Tests\DigipostSignatureBundle\Client;

use Digipost\Signature\Client\Security\KeyStoreConfig;
use Symfony\Component\Config\FileLocator;

/**
 * Class TestKonfigurasjon
 *
 * @method static KeyStoreConfig CLIENT_KEYSTORE()
 *
 * @package Digipost\Signature\Client
 */
class TestKonfigurasjon {

  private static $CLIENT_KEYSTORE;

  public static function __callStatic($name, $arguments) {
    if ($name !== 'CLIENT_KEYSTORE') {
      throw new \RuntimeException('Called unknown static "' . $name . '"');
    }
    if (!isset(static::$CLIENT_KEYSTORE)) {
      static::$CLIENT_KEYSTORE = self::init();
    }
    return static::$CLIENT_KEYSTORE;
  }

  private static function init() {
    $fileLocator = new FileLocator([
      __DIR__ . '/../../../Resources/config',
    ]);
    $keystoreFileName = $fileLocator->locate('selfsigned-keystore.p12');

    self::$CLIENT_KEYSTORE = KeyStoreConfig::fromKeyStoreFile(
      $keystoreFileName, 'avsender', 'password1234', 'password1234'
    );

    return self::$CLIENT_KEYSTORE;
  }
}
