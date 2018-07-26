<?php

namespace Digipost\Signature\Client\Security;

use Digipost\Signature\Client\Core\Exceptions\CertificateException;
use Digipost\Signature\Client\Core\Exceptions\KeyException;
use Digipost\Signature\Client\Core\Internal\Security\Certificate;
use Digipost\Signature\Client\Core\Internal\Security\KeyStore;
use Digipost\Signature\Client\Core\Internal\Security\PrivateKey;
use Digipost\Signature\Client\Core\Internal\Security\PrivateKeyInterface;
use Digipost\Signature\Client\Core\Internal\Security\X509Certificate;
use Digipost\Signature\Loader\KeyStoreFileLoader;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class KeyStoreConfig
 *
 * @package \Digipost\Signature\Client\Security\KeyStoreConfig
 */
class KeyStoreConfig {

  public $keyStore;

  public $alias;

  public $keystorePassword;

  public $privateKeyPassword;

  public function __construct(
    KeyStore $keyStore,
    String $alias,
    String $keystorePassword,
    String $privateKeyPassword
  ) {
    $this->keyStore = $keyStore;
    $this->alias = $alias;
    $this->keystorePassword = $keystorePassword;
    $this->privateKeyPassword = $privateKeyPassword;
  }

  public function getCertificateChain() {
    return $this->keyStore->getCertificateChain($this->alias);
  }

  public function getCertificate() {
    $certificate = NULL;
    try {
      $certificate = $this->keyStore->getCertificate($this->alias);
    } catch (KeyException $e) {
      throw new CertificateException(
        "Failed to retrieve certificate from key store. Is key store initialized?",
        $e
      );
    }
    if ($certificate === NULL) {
      throw new CertificateException(
        "Failed to find certificate in key store. Are you sure a key store with a certificate is supplied and that you've given the right alias?"
      );
    }

    if (!($certificate instanceof X509Certificate)) {
      throw new CertificateException(
        "Only X509 certificates are supported. Got a certificate with type " . get_class(
          $certificate
        )
      );
    }

    $this->verifyCorrectAliasCasing($certificate);

    return $certificate;
  }

  /**
   * @return PrivateKey|null
   */
  public function getPrivateKey() {
    try {
      $key = $this->keyStore->getKey($this->alias, $this->privateKeyPassword);
      if (!($key instanceof PrivateKeyInterface)) {
        throw new KeyException(
          "Failed to retrieve private key from key store. Expected a PriveteKey, got " . get_class(
            $key
          )
        );
      }
      return $key;
    } catch (KeyException $e) {
      throw new KeyException(
        "Failed to retrieve private key from key store. Is key store initialized?",
        $e
      );
    } catch (\Exception $e) {
      throw new KeyException(
        "Failed to retrieve private key from key store. Verify that the key is supported on the platform.",
        $e
      );
    }
  }

  public function getPublicKey() {
    $pkey = $this->getPrivateKey();
    $public = $pkey->getPublicKey();

    return $public;
  }

  public static function fromKeyStoreFileLoader(
    KeyStoreFileLoader $fileLoader,
    String $alias,
    String $keyStorePassword,
    String $privateKeyPassword
  ) {
    return KeyStoreConfig::fromKeyStore(
      $fileLoader->load(), $alias, $keyStorePassword, $privateKeyPassword
    );
  }

  public static function fromKeyStoreFile(
    String $filename,
    String $alias,
    String $keyStorePassword,
    String $privateKeyPassword
  ) {
    if (!file_exists($filename)) {
      throw new FileNotFoundException(
        "Failed to initialize key store from '$filename'. Are you sure the file exists?"
      );
    }
    $data = file_get_contents($filename);
    return KeyStoreConfig::fromKeyStore(
      $data,
      $alias,
      $keyStorePassword,
      $privateKeyPassword
    );
  }

  public static function fromKeyStore(
    $keyStore,
    String $alias,
    String $keyStorePassword,
    String $privateKeyPassword
  ) {
    $keyStoreConfig = NULL;
    try {
      $ks = KeyStore::getInstance("JCEKS");
      $ks->load($keyStore, $keyStorePassword, $privateKeyPassword);
      $keyStoreConfig = new KeyStoreConfig(
        $ks, $alias, $keyStorePassword,
        $privateKeyPassword
      );
    } catch (\Exception $e) {
      throw new KeyException("Failed to initialize key store", $e);
    }
    return $keyStoreConfig;
  }

  private function verifyCorrectAliasCasing(Certificate $certificate) {
    try {
      $aliasFromKeystore = $this->keyStore->getCertificateAlias($certificate);
      if (!$aliasFromKeystore === $this->alias) {
        throw new CertificateException(
          "Certificate alias in keystore was not same as provided alias. Probably different casing. In keystore: " . $aliasFromKeystore . ", from config: " . $this->alias
        );
      }
    } catch (KeyException $e) {
      throw new CertificateException(
        "Unable to get certificate alias based on certificate. This should never happen, as we just read the certificate from the same keystore.",
        $e
      );
    }
  }

  /**
   * @return String
   */
  public function getPrivatekeyPassword(): String {
    return $this->privateKeyPassword;
  }

  public function getClientCertificate() {
    return '';
  }

}
