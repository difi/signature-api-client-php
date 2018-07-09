<?php

namespace Digipost\Signature\Client\Security;

use Digipost\Signature\Client\Core\Exceptions\CertificateException;
use Digipost\Signature\Client\Core\Exceptions\InvalidMessageDigestAlgorithmException;
use Digipost\Signature\Client\Core\Exceptions\KeyException;
use Digipost\Signature\Client\Core\Internal\Security\Certificate;
use Digipost\Signature\Client\Core\Internal\Security\KeyStore;
use Digipost\Signature\Client\Core\Internal\Security\PrivateKey;
use Digipost\Signature\Client\Core\Internal\Security\PrivateKeyInterface;
use Digipost\Signature\Client\Core\Internal\Security\X509Certificate;
use GuzzleHttp\Psr7\Stream;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Exception\IOException;

/**
 * Class KeyStoreConfig
 *
 * @package Digipost\Signature\Client\Security
 */
class KeyStoreConfig {

  public $keyStore;

  public $alias;

  public $keystorePassword;

  public $privatekeyPassword;

  public function __construct(KeyStore $keyStore,
                              String $alias,
                              String $keystorePassword,
                              String $privatekeyPassword) {
    $this->keyStore = $keyStore;
    $this->alias = $alias;
    $this->keystorePassword = $keystorePassword;
    $this->privatekeyPassword = $privatekeyPassword;
  }

  public function getCertificateChain() {
    try {
      return $this->keyStore->getCertificateChain($this->alias);
    } catch (KeyStoreException $e) {
      throw new KeyException("Failed to retrieve certificate chain from key store. Is key store initialized?",
                             $e);
    }
  }

  public function getCertificate() {
    //Certificate certificate;
    $certificate = NULL;
    try {
      $certificate = $this->keyStore->getCertificate($this->alias);
    } catch (KeyStoreException $e) {
      throw new CertificateException("Failed to retrieve certificate from key store. Is key store initialized?",
                                     $e);
    }
    if ($certificate === NULL) {
      throw new CertificateException("Failed to find certificate in key store. Are you sure a key store with a certificate is supplied and that you've given the right alias?");
    }

    if (!($certificate instanceof X509Certificate)) {
      throw new CertificateException("Only X509 certificates are supported. Got a certificate with type " . get_class($certificate));
    }

    $this->verifyCorrectAliasCasing($certificate);

    return $certificate;
  }

  /**
   * @return PrivateKey|null
   */
  public function getPrivateKey() {
    try {
      $key = $this->keyStore->getKey($this->alias, $this->privatekeyPassword);
      if (!($key instanceof PrivateKeyInterface)) {
        throw new KeyException("Failed to retrieve private key from key store. Expected a PriveteKey, got " . get_class($key));
      }
      return $key;
    } catch (KeyStoreException $e) {
      throw new KeyException("Failed to retrieve private key from key store. Is key store initialized?",
                             $e);
    } catch (NoSuchAlgorithmException $e) {
      throw new KeyException("Failed to retrieve private key from key store. Verify that the key is supported on the platform.",
                             $e);
    } catch (UnrecoverableKeyException $e) {
      throw new KeyException("Failed to retrieve private key from key store. Verify that the password is correct.",
                             $e);
    }
  }

  public static function fromKeyStore($keyStore, String $alias,
                                      String $keyStorePassword,
                                      String $privatekeyPassword) {
    try {
      $ks = KeyStore::getInstance("JCEKS");
      $ks->load($keyStore, $keyStorePassword, $privatekeyPassword);
      return new KeyStoreConfig($ks, $alias, $keyStorePassword,
                                $privatekeyPassword);
    } catch (FileNotFoundException $e) {
      throw new KeyException("Failed to initialize key store. Are you sure the file exists?",
                             $e);
    } catch (KeyStoreException $e) {
    } catch (InvalidMessageDigestAlgorithmException $e) {
    } catch (IOException $e) {
    } catch (CertificateException $e) {
      throw new KeyException("Failed to initialize key store", $e);
    }
  }

  private function verifyCorrectAliasCasing(Certificate $certificate) {
    try {
      $aliasFromKeystore = $this->keyStore->getCertificateAlias($certificate);
      if (!$aliasFromKeystore === $this->alias) {
        throw new CertificateException("Certificate alias in keystore was not same as provided alias. Probably different casing. In keystore: " . $aliasFromKeystore . ", from config: " . $this->alias);
      }
    } catch (KeyStoreException $e) {
      throw new CertificateException("Unable to get certificate alias based on certificate. This should never happen, as we just read the certificate from the same keystore.",
                                     $e);
    }
  }

  /**
   * @return String
   */
  public function getPrivatekeyPassword(): String {
    return $this->privatekeyPassword;
  }

}
