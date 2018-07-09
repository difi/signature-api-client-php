<?php

namespace Digipost\Signature\XSD;

define('DIGIPOST_ROOT_PATH', realpath(__DIR__ . '/../../../../vendor/digipost/signature-api-specification/schema/xsd'));

/**
 * Class SignatureApiSchemas
 *
 * If depending on
 * [signature-api-specification](http://search.maven.org/#search%7Cga%7C1%7Cg%3Ano.digipost.signature%20a%3Asignature-api-specification),
 * these {@code String} constants can be used to resolve the schemas from classpath.
 * <p>
 * The {@code String} constants contains the resource names for the individual schema files, but the sets
 * {@link #DIRECT_AND_PORTAL_API}, {@link #DIRECT_API}, and {@link #PORTAL_API} compiles all relevant schemas
 * for the possible API integration cases.
 *
 * @package Digipost\Signature\XSD
 */
final class SignatureApiSchemas {

  public static $DIRECT_AND_PORTAL_SCHEMA = DIGIPOST_ROOT_PATH . "/direct-and-portal.xsd";

  public static $DIRECT_ONLY_SCHEMA = DIGIPOST_ROOT_PATH . "/direct.xsd";

  public static $PORTAL_ONLY_SCHEMA = DIGIPOST_ROOT_PATH . "/direct.xsd";

  public static $XMLDSIG_SCHEMA = DIGIPOST_ROOT_PATH . "/thirdparty/xmldsig-core-schema.xsd";

  public static $XADES_SCHEMA = DIGIPOST_ROOT_PATH . "/thirdparty/XAdES.xsd";

  public static $ASICE_SCHEMA = DIGIPOST_ROOT_PATH . "/thirdparty/ts_102918v010201.xsd";

  public static $DIRECT_AND_PORTAL_API;

  public static $DIRECT_API;

  public static $PORTAL_API;

  public static function __staticInit() {


    self::$DIRECT_AND_PORTAL_API = [
      self::$DIRECT_AND_PORTAL_SCHEMA,
      self::$XMLDSIG_SCHEMA,
      self::$XADES_SCHEMA,
      self::$ASICE_SCHEMA,
    ];

    self::$DIRECT_API = [
      self::$DIRECT_ONLY_SCHEMA,
      self::$XMLDSIG_SCHEMA,
      self::$XADES_SCHEMA,
      self::$ASICE_SCHEMA,
    ];

    self::$PORTAL_API = [
      self::$PORTAL_ONLY_SCHEMA,
      self::$XMLDSIG_SCHEMA,
      self::$XADES_SCHEMA,
      self::$ASICE_SCHEMA,
    ];
  }
}

SignatureApiSchemas::__staticInit();
