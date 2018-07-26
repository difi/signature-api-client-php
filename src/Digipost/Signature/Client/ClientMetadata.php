<?php

namespace Digipost\Signature\Client;

use Digipost\Signature\Client\Core\Exceptions\RuntimeIOException;

class ClientMetadata {

  static $VERSION;

  static function __initStatic() {
    $version = "unknown version";
    try {
      $version = findFileInParents('VERSION');
    } catch (\Exception $e) {
      trigger_error('Unable to resolve library version', E_USER_ERROR);
    } finally {
      self::$VERSION = $version;
    }
  }
}

ClientMetadata::__initStatic();

/**
 * @param string $filename
 * @param string $startDir
 * @param int    $maxIterations
 *
 * @return bool|null|string
 */
function findFileInParents(
  string $filename,
  $startDir = __DIR__,
  $maxIterations = 20
) {
  $path = $startDir;
  do {
    $path = realpath($path . implode(DIRECTORY_SEPARATOR, ['', '..', '']));
    $filePath = $path . DIRECTORY_SEPARATOR . $filename;
    $fileContents = file_exists($filePath) ? file_get_contents(
      $filePath
    ) : NULL;
  } while (--$maxIterations > 0 && !isset($fileContents) && $path !== DIRECTORY_SEPARATOR);

  if (!isset($fileContents)) {
    throw new RuntimeIOException(
      "Unable to resolve file '$filename' library version, starting from directory '$startDir'"
    );
  }
  return $fileContents;
}