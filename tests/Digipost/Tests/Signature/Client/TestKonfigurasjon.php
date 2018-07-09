<?php
namespace Digipost\Signature\Client;

use Digipost\Signature\Client\Security\KeyStoreConfig;

class TestKonfigurasjon {

  static $CLIENT_KEYSTORE;

  public static function __staticInit() {
    $rootPath = realpath(__DIR__ . '/../../../../../');
    $keystoreContents = file_get_contents($rootPath . '/Buypass_difitest_1646201040405302454751306-2017-09-05.p12');

    self::$CLIENT_KEYSTORE = KeyStoreConfig::fromKeyStore($keystoreContents,
                                                          'smt_test',
                                                          'bvWsmJm8hbNxNj9L',
                                                          'bvWsmJm8hbNxNj9L');
  }
}

TestKonfigurasjon::__staticInit();