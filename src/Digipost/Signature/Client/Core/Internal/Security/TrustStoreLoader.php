<?php

namespace Digipost\Signature\Client\Core\Internal\Security;

use Digipost\Signature\Client\Certificates;
use Digipost\Signature\Client\Core\Exceptions\ConfigurationException;
use Sop\CryptoEncoding\PEM;
use Symfony\Component\Config\FileLocator;
use X509\Certificate\Certificate;

class TrustStoreLoader {

  public static function build(ProvidesCertificateResourcePaths $hasCertificatePaths) {
    try {
      $trustStore = KeyStore::getInstance(KeyStore::getDefaultType());
      //$trustStore->load(NULL, NULL);

      foreach ($hasCertificatePaths->getCertificatePaths() as $certificateFolder) {
        self::loadCertificatesInto($certificateFolder, $trustStore);
      }

      return $trustStore;
    } catch (\Exception $e) {
      throw new ConfigurationException("Unable to load certificates into truststore", $e);
    }
  }

  private static function loadCertificatesInto(String $certificateFolder, KeyStore $trustStore) {
    $certificateLoader = NULL;
    if (strpos($certificateFolder, "classpath:") === 0) {
      $certificateLoader = new ClassPathFileLoader($certificateFolder);
    }
    else {
      $certificateLoader = new FileLoader($certificateFolder);
    }
    $certificateLoader->forEachFile(new class($trustStore) extends ForFile {
        function call(String $fileName, InputStream $contents) {
          try {
            $ca = Certificate::fromPEM(PEM::fromString($contents));
            $this->trustStore->setCertificateEntry($fileName, $ca);
          } catch (\Exception $e) {
            throw new ConfigurationException("Unable to load certificate in " . $fileName);
          }
        }
      }
    );

    //$tmf = TrustManagerFactory::getInstance(TrustManagerFactory::getDefaultAlgorithm());
    //$tmf->init($trustStore);
    //$context = SSLContext::getInstance("TLS");
    //$context->init(NULL, $tmf->getTrustManagers(), NULL);
  }
}

abstract class ForFile {
  protected $trustStore;
  function __construct(KeyStore $trustStore) {
    $this->trustStore = $trustStore;
  }
  abstract function call(String $fileName, InputStream $contents);
}

interface ResourceLoader {

  function forEachFile(ForFile $forEachFile);
}

class ClassPathFileLoader implements ResourceLoader {

  static $CLASSPATH_PATH_PREFIX = "classpath:";

  private $certificatePath;

  function __construct(String $certificateFolder) {
    $this->certificatePath = substr($certificateFolder, strlen(self::$CLASSPATH_PATH_PREFIX));
  }

  public function forEachFile(ForFile $forEachFile) {
    $contentsUrl = Certificates::getResource($this->certificatePath);

    $inputStream = $contentsUrl->openStream();
    $file = new File($contentsUrl->getFile());
    $forEachFile->call($file->getName(), $inputStream);
  }
}

class FileLoader implements ResourceLoader {

  private $path;

  function __construct(String $certificateFolder) {
    //$this->path = new File($certificateFolder);
    $this->path = new FileLocator($certificateFolder);
  }

  public function forEachFile(ForFile $forEachFile) {
    if (!is_dir($this->path)) {
      throw new ConfigurationException(
        "Certificate path '" . $this->path . "' is not a directory. " .
        "It should point to a directory containing certificates.");
    }
    $files = $this->path->listFiles();
    if ($files == NULL) {
      throw new ConfigurationException(
        "Unable to read certificates from '" . $this->path . "'. Make sure it's the correct path.");
    }

    foreach ($files as $file) {
      $contents = new FileInputStream($file);
      $forEachFile->call($file->getName(), $contents);
    }
  }
}