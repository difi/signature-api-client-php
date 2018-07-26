<?php

namespace Digipost\Signature\Client;

use Digipost\Signature\Client\Security\KeyStoreConfig;
use Symfony\Component\DependencyInjection\ContainerInterface;


class TestKonfigurasjon {

  static $CLIENT_KEYSTORE;

  public static function builder(ContainerInterface $container) {
    $keystoreFileName = $container->getParameter(
      'digipost_signature.keystore.filename'
    );
    self::$CLIENT_KEYSTORE = KeyStoreConfig::fromKeyStoreFile(
      $keystoreFileName, 'smt_test', 'qwerty123', 'qwerty321'
    );
    //$keystoreContents = file_get_contents($rootPath . '/Buypass_difitest_1646201040405302454751306-2017-09-05.p12');

    return self::$CLIENT_KEYSTORE;
  }
}
