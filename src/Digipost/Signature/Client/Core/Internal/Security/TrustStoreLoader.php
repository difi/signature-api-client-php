<?php

namespace Digipost\Signature\Client\Core\Internal\Security;

//import javax.net.ssl.SSLContext;
//import javax.net.ssl.TrustManagerFactory;
//
//import java.security.KeyManagementException;
//import java.security.KeyStore;
//import java.security.KeyStoreException;
//import java.security.NoSuchAlgorithmException;
//import java.security.cert.CertificateException;
//import java.security.cert.CertificateFactory;
//import java.security.cert.X509Certificate;

use Digipost\Signature\Client\Certificates;
use Digipost\Signature\Client\Core\Exceptions\ConfigurationException;

class TrustStoreLoader {

  public static function build(ProvidesCertificateResourcePaths $hasCertificatePaths) {
    try {
      $trustStore = KeyStore::getInstance(KeyStore::getDefaultType());
      $trustStore->load(NULL, NULL);

      foreach ($hasCertificatePaths->getCertificatePaths() as $certificateFolder) {
        self::loadCertificatesInto($certificateFolder, $trustStore);
      }
      return $trustStore;
    } catch (KeyStoreException $e) {
    } catch (CertificateException $e) {
    } catch (NoSuchAlgorithmException $e) {
    } catch (IOException $e) {
    } catch (KeyManagementException $e) {
      throw new ConfigurationException("Unable to load certificates into truststore",
                                       $e);
    }
  }

  private static function loadCertificatesInto(String $certificateFolder,
                                               KeyStore $trustStore) {
    /** @var ResourceLoader $certificateLoader */
    $certificateLoader = NULL;

    if (strpos($certificateFolder, "classpath:") === 0) {
      $certificateLoader = new ClassPathFileLoader($certificateFolder);
    }
    else {
      $certificateLoader = new FileLoader($certificateFolder);
    }

    $certificateLoader->forEachFile(
      function ($fileName, $contents) use ($trustStore) {
        //void call(String $fileName, InputStream $contents) {
        try {
          /** @var X509Certificate $ca */
          $ca = CertificateFactory::getInstance("X.509")
            ->generateCertificate($contents);
          $trustStore->setCertificateEntry($fileName, $ca);
        } catch (CertificateException $e) {
        } catch (KeyStoreException $e) {
          throw new ConfigurationException("Unable to load certificate in " + $fileName);
        }
        //}
      });

    /** @var TrustManagerFactory $tmf */
    $tmf = TrustManagerFactory::getInstance(TrustManagerFactory::getDefaultAlgorithm());
    $tmf->init($trustStore);

    /** @var SSLContext $context */
    $context = SSLContext::getInstance("TLS");
    $context->init(NULL, $tmf->getTrustManagers(), NULL);
  }
}


abstract class ForFile {
  abstract function call(String $fileName, InputStream $contents);
}

interface ResourceLoader {

  function forEachFile(ForFile $forEachFile);
}

class FileLoader implements ResourceLoader {

  /** @var File $path */
  private $path;

  function __construct(String $certificateFolder) {

    $this->path = new File($certificateFolder);
  }

  public function forEachFile(ForFile $forEachFile) {
    if (!$this->path->isDirectory()) {
      throw new ConfigurationException("Certificate path '" . $this->path . "' is not a directory. " .
                                       "It should point to a directory containing certificates.");
    }
    /** @var File[] $files */
    $files = $this->path->listFiles();
    if ($files === NULL) {
      throw new ConfigurationException("Unable to read certificates from '" . $this->path . "'. Make sure it's the correct path.");
    }

    foreach ($files as $file) {
      try {
        $contents = new FileInputStream($file);
        $forEachFile->call($file->getName(), $contents);
      } catch (IOException $e) {
        throw $e;
      }
    }
  }
}

class ClassPathFileLoader implements ResourceLoader {

  static $CLASSPATH_PATH_PREFIX = "classpath:";

  private $certificatePath;

  function __construct(String $certificateFolder) {

    $this->certificatePath = substr($certificateFolder,
                                    strlen(self::$CLASSPATH_PATH_PREFIX));
  }

  public function forEachFile(ForFile $forEachFile) {
    $contentsUrl = Certificates::getResource($this->certificatePath);

    try {
      $inputStream = $contentsUrl->openStream();
      $forEachFile->call(new File($contentsUrl->getFile()), $inputStream);
  } catch (IOException $e) {
      throw $e;
    }
  }
}