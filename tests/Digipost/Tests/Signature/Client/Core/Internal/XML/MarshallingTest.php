<?php
/**
 * Created by PhpStorm.
 * User: bendik
 * Date: 10.07.18
 * Time: 10:13
 */

namespace Digipost\Signature\Client\Core\Internal\XML;

use PHPUnit\Framework\TestCase;

class MarshallingTest extends TestCase {

  static $VENDOR_DIR = 'vendor';

  function setUp() {
    self::$VENDOR_DIR = dirname(realpath(PHPUNIT_COMPOSER_INSTALL));
  }

  function testUnmarshallingOfDirectResponse() {
    $schema_dir = self::$VENDOR_DIR . '/digipost/signature-api-specification/schema';
    $this->assertDirectoryExists($schema_dir);

    $direct_response_example = file_get_contents($schema_dir . '/examples/direct/response.xml');
    print $direct_response_example;
    print "\n---\n";

    $object = Marshalling::unmarshal($direct_response_example);
//    var_dump($object);

    $xml = Marshalling::marshal($object, $outputXML);
    print $outputXML->saveXML();
  }
}
