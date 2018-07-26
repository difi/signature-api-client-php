<?php

namespace Digipost\Signature\Client\ASiCe;

use Digipost\Signature\Client\Core\Exceptions\RuntimeIOException;
use Digipost\Signature\Client\Core\SignatureJob;
use GuzzleHttp\Psr7\Stream;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DumpDocumentBundleToDisk implements DocumentBundleProcessor {

  use ContainerAwareTrait;

  //private static $LOG = LoggerFactory.getLogger(DumpDocumentBundleToDisk.class);
  private static $LOG;

  static $TIMESTAMP_PATTERN = "%Y%m%d%H%M%S";

  private $directory;

  private $clock;

  function __construct(ContainerInterface $container) {
    $this->setContainer($container);
  }

  public function setup(string $directory, \DateTime $clock) {
    $this->directory = $directory;
    $this->clock = $clock;
    return $this;
  }

  public static function factory(ContainerInterface $container) {
    return new self($container);
  }

  public function process(SignatureJob $job, Stream $documentBundle) {
    if (is_dir($this->directory)) {
      $timestampFormat = strftime(
        self::$TIMESTAMP_PATTERN,
        $this->clock->getTimestamp()
      );
      $filename = $timestampFormat . '-' . self::referenceFilenamePart(
          $job->getReference()
        ) . 'asice.zip';
      //$target = directory.resolve(filename);
      $target = $this->directory . DIRECTORY_SEPARATOR . $filename;
      //LOG.info("Dumping document bundle{}to {}", reference.map(ref -> format(" for job with reference '%s' ", ref)).orElse(" "), target);
      //copy($documentBundle, $target);
      $fp = fopen($target, 'w');
      fwrite($fp, $documentBundle->getContents());
      fclose($fp);
    }
    else {
      throw new InvalidDirectoryException($this->directory);
    }
    //static final Function<String, String> referenceFilenamePart = reference -> reference.replace(' ', '_') + "-";
    //}
  }

  static final function referenceFilenamePart(String $reference) {
    return str_replace(' ', '_', $reference) . '-';
  }
}


class InvalidDirectoryException extends RuntimeIOException {

  function __construct($path) {
    parent::__construct(
      "The path " . $path . (file_exists(
        $path
      ) ? " does not exist" : " is not a valid directory")
    );
  }
}