<?php

namespace Digipost\Signature\Client;

use MyCLabs\Enum\Enum;

/**
 * Class Certificates
 *
 * @package Digipost\Signature\Client
 *
 * @method static Certificates TEST
 * @method static Certificates PRODUCTION
 */
class Certificates extends Enum {

  const TEST = [
    "test/Buypass_Class_3_Test4_CA_3.cer",
    "test/Buypass_Class_3_Test4_Root_CA.cer",
    "test/commfides_test_ca.cer",
    "test/commfides_test_root_ca.cer",
    "test/digipost_test_root_ca.pem",
  ];

  const PRODUCTION = [
    "prod/BPClass3CA3.cer",
    "prod/BPClass3RootCA.cer",
    "prod/commfides_ca.cer",
    "prod/commfides_root_ca.cer",
  ];

  public function certificatePaths() {
    return $this->value;
  }
}

class FullCertificateClassPathUri {

  protected static $instance;  // FullCertificateClassPathUri

  protected static $root;  // String

  public static function __staticinit() { // static class members
    self::$instance = new FullCertificateClassPathUri();
    self::$root = "/" . Certificates::class . "/certificates/";
  }

  public function apply($resourceName) // [String resourceName]
  {
    return (("classpath:" . self::$root) . $resourceName);
  }
}

FullCertificateClassPathUri::__staticinit(); // initialize static vars for this class on load
