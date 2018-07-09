<?php

namespace Digipost\Signature\Client\ASiCe\Archive;

//package no.digipost.signature.client.asice.archive;
//
//import no.digipost.signature.client.asice.ASiCEAttachable;
//import no.digipost.signature.client.core.exceptions.RuntimeIOException;
//
//import java.io.ByteArrayOutputStream;
//import java.io.IOException;
//import java.util.List;
//import java.util.zip.ZipEntry;
//import java.util.zip.ZipOutputStream;

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
      //$archive = new ByteArrayOutputStream();
      $zipFile = tmpfile();
      $zipFileMeta = stream_get_meta_data($zipFile);
      $zipFileName = $zipFileMeta['uri'];

      $archive = new \ZipArchive();
      $archive->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
      //$zipOutputStream = new ZipOutputStream($archive);
      foreach ($files as $file) {
        //$zipEntry = new ZipEntry($file->getFileName());
        //$zipEntry->setSize(sizeof($file->getBytes()));
        $archive->addFromString($file->getFileName(), $file->getBytes());
        //$zipOutputStream->putNextEntry($zipEntry);
        //$zipOutputStream->write($file->getBytes());
        //$zipOutputStream->closeEntry();
      }
      $archive->close();

      fseek($zipFile, 0);
      $zipData = fread($zipFile, filesize($zipFileName));
      fclose($zipFile);

      return $zipData;
    } catch (\Exception $e) {
      throw new RuntimeIOException($e);
    }
  }
}
