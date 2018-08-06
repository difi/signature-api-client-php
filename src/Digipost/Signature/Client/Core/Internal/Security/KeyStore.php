<?php

namespace Digipost\Signature\Client\Core\Internal\Security;

use Digipost\Signature\Client\Core\Exceptions\CertificateParsingFailedException;
use Digipost\Signature\Client\Core\Exceptions\KeyStoreDecryptionFailedException;
use Digipost\Signature\Client\Core\Exceptions\OpenSSLExtensionNotLoadedException;
use Digipost\Signature\Client\Core\Exceptions\PrivateKeyDecryptionFailedException;
use Digipost\Signature\Client\Core\Exceptions\RuntimeIOException;
use Digipost\Signature\Loader\KeyStoreFileLoader;
use Sop\CryptoEncoding\PEM;
use Sop\CryptoEncoding\PEMBundle;

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
   * @var Certificate[]
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
   * @param String $contents
   * @param String $passphrase
   * @param String $privatekeyPassword
   *
   * @throws KeyStoreDecryptionFailedException
   * @throws OpenSSLExtensionNotLoadedException
   * @throws PrivateKeyDecryptionFailedException
     * @throws CertificateParsingFailedException
   */
  public function load(String $contents, String $passphrase, String $privatekeyPassword) {
    if (!openssl_pkcs12_read($contents, $this->keystore, $passphrase)) {
      $err = openssl_error_string();
      throw new KeyStoreDecryptionFailedException(
        "Could not decrypt the certificate, the passphrase is incorrect, " .
        "its contents are mangled or it is not a valid PKCS #12 keystore:\n'$err'");
    }
    $this->X509Certificate = new X509Certificate($this->keystore['cert']);
    $this->privateKey = new PrivateKey($this->keystore['pkey'], $privatekeyPassword);

    $this->chain = [];
    $extraCerts =& $this->keystore['extracerts'];
    end($extraCerts);
    while ($cert = current($extraCerts)) {
      $this->chain[] = new X509Certificate($cert);
      prev($extraCerts);
    }
    $this->chain[] = $this->X509Certificate;
    krsort($this->chain);
    X509Certificate::buildChain($this->chain);
//    asort($this->chain);
//    X509Certificate::buildChain($this->chain);
  }

  /**
   * Initialize the PKCS12 keystore from a file.
   *
   * @param $keystoreLocation
   * @param $passphrase
   *
   * @return KeyStore
   * @throws CertificateParsingFailedException
   * @throws KeyStoreDecryptionFailedException
   * @throws OpenSSLExtensionNotLoadedException
   * @throws PrivateKeyDecryptionFailedException
   */
  public static function initFromFile($keystoreLocation, $passphrase) {
    if ($keystoreLocation instanceof KeyStoreFileLoader) {
      $self = new KeyStore();
      $self->load($keystoreLocation->load(), $passphrase, $passphrase);
      return $self;
    }
    if (!file_exists($keystoreLocation)) {
      throw new \RuntimeException("The keystore file '$keystoreLocation' does not exist.");
    }
    if (!is_readable($keystoreLocation)) {
      throw new RuntimeIOException("The keystore file '$keystoreLocation' is not readable.");
    }
    $self = new KeyStore();
    $self->load(file_get_contents($keystoreLocation), $passphrase, $passphrase);
    return $self;
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

  public function getClientCertificate() {

  }

  public function getCertificateChain($alias = '') {
    //print_r($this->keystore);
    return $this->chain;
    //return $this->X509Certificate->;
  }

  // TODO: Fix lookup by alias
  public function getCertificate($alias) {
    return $this->X509Certificate;
//    $chain = \X509\Certificate\CertificateChain::fromPEMs(...PEMBundle::fromString($this->X509Certificate->getClearText()));
//    $cert = $chain->endEntityCertificate();
//    $x509 = new X509Certificate($cert->toPEM()->string());
//    $x509->setIssuer($this->X509Certificate->getIssuer());
//    return $x509;
  }

  public function getKey(String $alias, String $passphrase): PrivateKey {
    return $this->privateKey;
  }

  // TODO: Fix lookup by alias
  public function getCertificateAlias(Certificate $certificate) {
    /** @var X509Certificate $certificate */
    return $certificate->getCrlUri();
  }
}
