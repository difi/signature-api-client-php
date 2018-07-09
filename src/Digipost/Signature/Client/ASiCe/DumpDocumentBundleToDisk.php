<?php

namespace Digipost\Signature\Client\ASiCe;

use Digipost\Signature\Client\Core\Exceptions\RuntimeIOException;
use Digipost\Signature\Client\Core\SignatureJob;

class DumpDocumentBundleToDisk implements DocumentBundleProcessor {

  //private static $LOG = LoggerFactory.getLogger(DumpDocumentBundleToDisk.class);
  private static $LOG;

  static $TIMESTAMP_PATTERN = "%Y%m%d%H%M%S";

  private $directory;

  private $clock;

  public function __construct(string $directory, \DateTime $clock) {
    $this->directory = $directory;
    $this->clock = $clock;
  }


  public function process(SignatureJob $job, $documentBundle) {
    if (is_dir($this->directory)) {
      $timestampFormat = strftime(self::$TIMESTAMP_PATTERN,
                                  $this->clock->getTimestamp());
      $reference = str_replace(' ', '_', $job->getReference());
      $filename = $timestampFormat . '-' . $reference . '-' . 'asice.zip';
      //$target = directory.resolve(filename);
      $target = realpath($this->directory . DIRECTORY_SEPARATOR . $filename);
      //LOG.info("Dumping document bundle{}to {}", reference.map(ref -> format(" for job with reference '%s' ", ref)).orElse(" "), target);
      copy($documentBundle, $target);
    }
    else {
      throw new InvalidDirectoryException($this->directory);
    }
    //static final Function<String, String> referenceFilenamePart = reference -> reference.replace(' ', '_') + "-";
    //}
  }
}


class InvalidDirectoryException extends RuntimeIOException {

  function __construct($path) {
    parent::__construct("The path " . file_exists($path) ? " does not exist" : " is not a valid directory");
  }
}