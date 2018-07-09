<?php

namespace Digipost\Signature\Client\Core\Internal\Security;

use Digipost\Signature\Client\Core\Exceptions\KeyStoreDecryptionFailedException;
use Digipost\Signature\Client\Core\Exceptions\OpenSSLExtensionNotLoadedException;
use Digipost\Signature\Client\Core\Exceptions\PrivateKeyDecryptionFailedException;

class KeyStore {

  /**
   * @var X509Certificate
   */
  private $X509Certificate = NULL;

  /**
   * @var PrivateKey
   */
  private $privateKey = NULL;

  /**
   * @var array
   */
  private $keystore = [];

  /**
   * @var array
   */
  private $chain = [];

  /**
   * Represents a PKCS12 keystore.
   *
   * @param null $type
   *
   * @throws OpenSSLExtensionNotLoadedException
   */
  public function __construct($type = NULL) {
    if (!extension_loaded('openssl')) {
      throw new OpenSSLExtensionNotLoadedException('The openssl module is not loaded.');
    }
  }

  /**
   * @param $contents
   * @param $passphrase
   * @param $privatekeyPassword
   *
   * @throws KeyStoreDecryptionFailedException
   * @throws OpenSSLExtensionNotLoadedException
   * @throws PrivateKeyDecryptionFailedException
   * @throws \Digipost\Signature\Client\Core\Exceptions\CertificateParsingFailedException
   */
  public function load($contents, $passphrase, $privatekeyPassword) {
    if (!openssl_pkcs12_read($contents, $this->keystore, $passphrase)) {
      throw new KeyStoreDecryptionFailedException(
        'Could not decrypt the certificate, the passphrase is incorrect, ' .
        'its contents are mangled or it is not a valid PKCS #12 keystore.');
    }
    $this->X509Certificate = new X509Certificate($this->keystore['cert']);
    $this->privateKey = new PrivateKey($this->keystore['pkey'], $privatekeyPassword);

    $this->chain = [];
    foreach ($this->keystore['extracerts'] as $cert) {
      $this->chain[] = new X509Certificate($cert);
    }
    $this->chain[] = $this->X509Certificate;
    //
    X509Certificate::buildChain($this->chain);
    //X509Certificate::buildChain($this->keystore['extracerts']);
  }
  /**
   * Initialize the PKCS12 keystore from a file.
   *
   * @param string $keystoreLocation
   * @param string $passphrase
   *
   * @return KeyStore
   * @throws KeyStoreDecryptionFailedException
   * @throws OpenSSLExtensionNotLoadedException
   * @throws PrivateKeyDecryptionFailedException
   * @throws \Digipost\Signature\Client\Core\Exceptions\CertificateParsingFailedException
   */
  public static function initFromFile($keystoreLocation, $passphrase) {
    if (!file_exists($keystoreLocation)) {
      throw new FileNotFoundException("The keystore file '$keystoreLocation' does not exist.");
    }
    if (!is_readable($keystoreLocation)) {
      throw new FileNotReadableException("The keystore file '$keystoreLocation' is not readable.");
    }
    $me = new self();
    $me->load(file_get_contents($keystoreLocation), $passphrase);
    return $me;
  }

  public function __get($name) {
    switch ($name) {
      case 'publicKey':
        return $this->X509Certificate->publicKey;
      case 'privateKey':
        return $this->privateKey;
      case 'certificate':
        return $this->X509Certificate;
      default:
        return NULL;
    }
  }


  private static $KEYSTORE_TYPE = "keystore.type";

  private $type;

  private $provider;

  private $keyStoreSpi;

  private $initialized;


  /**
   * @param String $s
   *
   * @return KeyStore
   * @throws OpenSSLExtensionNotLoadedException
   */
  public static function getInstance(String $s) {
    return new KeyStore($s);
  }

  public static function getDefaultType() {

  }

  public function getCertificateChain($alias) {
    //print_r($this->keystore);
    return $this->chain;
    //return $this->X509Certificate->;
  }

  public function getCertificate($alias) {
    return $this->X509Certificate;
  }

  public function getKey(): PrivateKey {
    return $this->privateKey;
  }

  public function getCertificateAlias(Certificate $certificate) {

  }
}
