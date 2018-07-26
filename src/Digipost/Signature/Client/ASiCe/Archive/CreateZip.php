<?php

namespace Digipost\Signature\Client\ASiCe\Archive;

use Digipost\Signature\Client\ASiCe\ASiCEAttachable;
use Digipost\Signature\Client\Core\Exceptions\RuntimeIOException;

class CreateZip {

  /**
   * @param ASiCEAttachable[] $files
   *
   * @return string Raw data of the created Zip file
   */
  public function zipIt(array $files) {
    try {
      $zipFileName = tempnam(
        '/tmp', 'ASiCe-' . hash('sha1', microtime(TRUE)) . '.zip'
      );

      $archive = new \ZipArchive();
      $archive->open(
        $zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE
      );
      foreach ($files as $file) {
        $archive->addFromString($file->getFileName(), $file->getBytes());
      }
      $archive->close();

      $zipFile = fopen($zipFileName, 'r');
      $zipData = fread($zipFile, filesize($zipFileName));
      fclose($zipFile);

      return $zipData;
    } catch (\Exception $e) {
      throw new RuntimeIOException($e);
    }
  }
}
