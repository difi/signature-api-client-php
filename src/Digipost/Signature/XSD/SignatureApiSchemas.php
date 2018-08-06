<?php

namespace Digipost\Signature\XSD;

// TODO: Move this to config/resource loading

use GoetasWebservices\XML\XSDReader\Schema\Exception\SchemaException;
use GoetasWebservices\XML\XSDReader\Schema\Schema;
use GoetasWebservices\XML\XSDReader\SchemaReader;
use GuzzleHttp\Psr7\AppendStream;
use MyCLabs\Enum\Enum;

define(
  'DIGIPOST_ROOT_PATH', realpath(
    __DIR__ . '/../../../../vendor/digipost/signature-api-specification/schema/xsd'
  )
);

/**
 * Class SignatureApiSchemas
 *
 * If depending on
 * [signature-api-specification](http://search.maven.org/#search%7Cga%7C1%7Cg%3Ano.digipost.signature%20a%3Asignature-api-specification),
 * these {@code String} constants can be used to resolve the schemas from classpath.
 * <p>
 * The {@code String} constants contains the resource names for the individual
 * schema files, but the sets
 * {@link #DIRECT_AND_PORTAL_API}, {@link #DIRECT_API}, and {@link #PORTAL_API}
 * compiles all relevant schemas for the possible API integration cases.
 *
 * @package Digipost\Signature\XSD
 *
 * @method static SignatureApiSchemas DIRECT_AND_PORTAL_SCHEMA()
 * @method static SignatureApiSchemas DIRECT_ONLY_SCHEMA()
 * @method static SignatureApiSchemas PORTAL_ONLY_SCHEMA()
 * @method static SignatureApiSchemas XMLDSIG_SCHEMA()
 * @method static SignatureApiSchemas XADES_SCHEMA()
 * @method static SignatureApiSchemas ASICE_SCHEMA()
 * @method static SignatureApiSchemas ASICE_AND_XADES_SCHEMA()
 * @method static SignatureApiSchemas DIRECT_AND_PORTAL_API()
 * @method static SignatureApiSchemas DIRECT_API()
 * @method static SignatureApiSchemas PORTAL_API()
 */
class SignatureApiSchemas extends Enum {

  static $stream_wrapper;

  const DIRECT_AND_PORTAL_SCHEMA = DIGIPOST_ROOT_PATH . '/direct-and-portal.xsd';
  const DIRECT_ONLY_SCHEMA       = DIGIPOST_ROOT_PATH . '/direct.xsd';
  const PORTAL_ONLY_SCHEMA       = DIGIPOST_ROOT_PATH . '/direct.xsd';
  const XMLDSIG_SCHEMA           = DIGIPOST_ROOT_PATH . '/thirdparty/xmldsig-core-schema.xsd';
  const XADES_SCHEMA             = DIGIPOST_ROOT_PATH . '/thirdparty/XAdES.xsd';
  const ASICE_SCHEMA             = DIGIPOST_ROOT_PATH . '/thirdparty/ts_102918v010201.xsd';

  const ASICE_AND_XADES_SCHEMA = [
    'ASICE_SCHEMA' => SignatureApiSchemas::ASICE_SCHEMA,
    'XADES_SCHEMA' => SignatureApiSchemas::XADES_SCHEMA,
  ];

  const DIRECT_AND_PORTAL_API    = [
    //    SignatureApiSchemas::DIRECT_AND_PORTAL_SCHEMA,
    'ASICE_SCHEMA' => SignatureApiSchemas::ASICE_SCHEMA,
    'XADES_SCHEMA' => SignatureApiSchemas::XADES_SCHEMA,
    'XMLDSIG_SCHEMA' => SignatureApiSchemas::XMLDSIG_SCHEMA,
  ];

  const DIRECT_API               = [
    'DIRECT_ONLY_SCHEMA' => SignatureApiSchemas::DIRECT_ONLY_SCHEMA,
    'ASICE_SCHEMA' => SignatureApiSchemas::ASICE_SCHEMA,
    'XADES_SCHEMA' => SignatureApiSchemas::XADES_SCHEMA,
    'XMLDSIG_SCHEMA' => SignatureApiSchemas::XMLDSIG_SCHEMA,
  ];

  const PORTAL_API               = [
    'DIRECT_AND_PORTAL_API' => SignatureApiSchemas::DIRECT_AND_PORTAL_API,
    'ASICE_SCHEMA' => SignatureApiSchemas::ASICE_SCHEMA,
    'XADES_SCHEMA' => SignatureApiSchemas::XADES_SCHEMA,
    'XMLDSIG_SCHEMA' => SignatureApiSchemas::XMLDSIG_SCHEMA,
  ];

  private $filename;

  public function __construct($value) {
    parent::__construct($value);
    if (is_array($value)) {
      $value = array_map(function($v) {
        return SignatureApiSchemas::$v();
      }, array_keys($value));
      $this->value = $value;
    } else {
      $this->filename = $value;
    }

//    if (is_array($value)) {
//      $this->filename = 'xsd://' . $this->getKey();
//    }
  }

  private static function create($value) {
    return new self($value);
  }

  public function getValue() {
    return $this;
  }

  /**
   * @return \GoetasWebservices\XML\XSDReader\Schema\Schema
   */
  public function getSchema() {
    $reader = new SchemaReader();
    //$schema = $reader->getGlobalSchema();
    try {
      //foreach ($this->getFileNames() as $fileName) {
        //$schema->addSchema($reader->readFile($fileName));
      //}
      $schema = $reader->readFile($this->filename);
    } catch (SchemaException $e) {
      throw new \RuntimeException("An error occoured during merging of schemas", 0, $e);
    }

    return $schema;
  }

  public function __toString() {
    return $this->filename;
  }

  public function getFileNames() {
    return is_array($this->value) ? $this->value : [$this->value];
  }

  private function init() {
    if (!isset(static::$stream_wrapper)) {
      stream_wrapper_register('xsd', XsdSchemaFileWrapper::class);
      static::$stream_wrapper = TRUE;
    }
  }

  public function getXSD() {
    $values = is_array($this->value) ? $this->value : [$this->value];

    $imports = array_map(function($schema) {
      /** @var SignatureApiSchemas $schema */
      $ns = $schema->getSchema()->getTargetNamespace();
      return '<xsd:import namespace="' . $ns . '" schemaLocation="' . $schema->filename . '"/>' . "\n";
    }, $values);

    $xsd = '<?xml version="1.0" encoding="utf-8"?>'. "\n" .
    '<xsd:schema xmlns:xsd="http://www.w3.org/2001/XMLSchema">'.
      join("\n", $imports) .
    '</xsd:schema>';
    return $xsd;
  }
}

class XsdSchemaFileWrapper {

  /** @var int */
  var $position;

  /** @var string */
  var $varName;

  /** @var string */
  private $schemaName;

  /** @var SignatureApiSchemas */
  private $schema;

  /** @var AppendStream */
  private $stream;

  /** @var bool */
  private $start_tag_removed = FALSE;

  /** @var Schema[] */
  private $schemas;

  function stream_open($path, $mode, $options, &$opened_path) {
    $url = parse_url($path);
    $this->schemaName = $url['host'];
    $this->schema = call_user_func([SignatureApiSchemas::class, $this->schemaName]);

    $reader = new SchemaReader();

    $filenames = $this->schema->getFileNames();
    $this->schemas = array_map(
      function ($filename) use ($reader) {
        return $reader->readFile($filename);
      }, $filenames
    );

    return TRUE;
    //
    //    $schema = new Schema();
    //    foreach ($schemas as $s) {
    //      $schema->addSchema($s);
    //    }

    //    $this->stream = \GuzzleHttp\Psr7\stream_for($xsd);
    //    return TRUE;
    //    $streams = array_map(function($filename) {
    //      return \GuzzleHttp\Psr7\stream_for(file_get_contents($filename));
    //    }, $this->schema->getFileNames());
    //    $this->stream = new AppendStream($streams);
    //    $this->position = 0;
    //    return TRUE;
  }

  function stream_read($count) {
    return $this->schemas;
    //    return $this->stream->read($count);
    //    $str = \GuzzleHttp\Psr7\readline($this->stream, $count);
    //    $re = '/\<\?xml[^>]+>/im';
    //    $str = preg_replace($re, '', $str, -1, $count);
    //
    //    if ($count > 0 && !$this->start_tag_removed) {
    //      $this->start_tag_removed = TRUE;
    /*      $str = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $str;*/
    //    }
    //    if ($matches[0] && !empty($matches[0][0])) {
    //      $opening_tag = '';
    //      if (!$this->start_tag_removed) {
    //        $opening_tag = array_shift($matches[0]);
    //      }
    //      $str = preg_replace($re, "", $str, -1, $count);
    ////      foreach (array_keys($matches[0]) as $k) {
    ////        if (!$this->start_tag_removed) {
    ////          $len = mb_strlen($matches[0][$k]);
    ////          $this->start_tag_removed = TRUE;
    ////        }
    ////      }
    ////      if (!$this->start_tag_removed) {
    ////        $str = preg_replace($re, "\n", $str, 1, $count);
    ////      }
    //      if (!$this->start_tag_removed && $count > 0) {
    /*        $str = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $str;*/
    //        $this->start_tag_removed = TRUE;
    //      }
    //    }
    //    return $str;
  }

  function stream_tell() {
    return $this->stream->tell();
  }

  function stream_eof() {
    return $this->stream->eof();
  }

  function stream_seek($offset, $whence) {
    $this->stream->seek($offset, $whence);
  }

  function url_stat($path, $flags) {
    try {
      $url = parse_url($path);
      $schemaName = $url['host'];
      $schema = call_user_func([SignatureApiSchemas::class, $schemaName]);
    } catch (\Exception $e) {
      return FALSE;
    }

    return [
      'filename' => 'xsd://' . $path,
      'schema'   => $schemaName,
      'files'    => $schema->getFileNames(),
    ];
  }

  function stream_metadata($path, $option, $var) {
    if ($option == STREAM_META_TOUCH) {
      return TRUE;
    }

    return FALSE;
  }
}