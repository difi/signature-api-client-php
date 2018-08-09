<?php

namespace Digipost\Signature\Client\Core\Internal\Security;

use Digipost\Signature\Client\Core\Exceptions\CertificateParsingFailedException;
use Digipost\Signature\Client\Core\Exceptions\KeyException;
use Digipost\Signature\Client\Core\Exceptions\KeyStoreDecryptionFailedException;
use Digipost\Signature\Client\Core\Exceptions\OpenSSLExtensionNotLoadedException;
use Digipost\Signature\Client\Core\Exceptions\PrivateKeyDecryptionFailedException;
use Digipost\Signature\Client\Core\Exceptions\RuntimeIOException;
use Digipost\Signature\Loader\KeyStoreFileLoader;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;

/**
 * @property-read PublicKey publicKey
 * @property-read X509Certificate certificate
 */
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
    if (is_array($extraCerts)) {
      end($extraCerts);
      while ($cert = current($extraCerts)) {
        $this->chain[] = new X509Certificate($cert);
        prev($extraCerts);
      }
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

  /**
   * Convert a keystore file to PKCS#12 format using [Java Keytool](https://docs.oracle.com/javase/8/docs/technotes/tools/unix/keytool.html) cli command.
   *
   * @param string $filename  The source filename of the keystore to be converted.
   * @param string $password  The keystore password
   * @param string $storeType [optional] The store type, or (default) <em>auto</em> to autodetect from
   *                          file type.
   *
   * @return string The converted filename (same as $filename, but with .p12 file ending).
   *
   * @throws KeyException on invalid store type (or unable to detect from filename).
   * @throws KeyException on <em>keytool</em> command error.
   */
  public static function convertKeyStore($filename, $password, $storeType = 'auto') {
    if ($storeType === 'auto') {
      $fileInfo = new FileinfoMimeTypeGuesser();
      $mime = $fileInfo->guess($filename);
      switch ($mime) {
        case 'application/x-java-jce-keystore':
          $storeType = 'JCEKS';
          break;
        case 'application/x-java-keystore':
          $storeType = 'JKS';
          break;
        default:
          throw new KeyException('Unable to detect valid KeyStore file type: ' . $mime);
      }
    }

    $newFilename = substr($filename, 0, strrpos($filename, '.')) . '.p12';

    if (file_exists($newFilename)) {
      throw new KeyException("Can't convert keystore, because destination file already exists: $newFilename");
    }

    $args = [
      '-noprompt', '-importkeystore',
      '-srckeystore' => $filename,
      '-destkeystore' => $newFilename,
      '-srcstoretype' => $storeType,
      '-deststoretype' => 'PKCS12',
      '-srcstorepass' => $password,
      '-deststorepass' => $password,
    ];
    array_walk($args, function (&$v, $k) {
      if (!is_numeric($k)) {
        $v = $k . ' ' . escapeshellarg($v);
      }
    });
    $cmd = 'keytool ' . implode(' ', array_values($args)) . ' 2>&1';
    exec($cmd, $out, $ret);
    if ($ret === 0) {
      trigger_error(
        'Converted JCEKS keystore "' . basename($filename) . '" to PKCS#12 (saved as "' .
        realpath($newFilename) . '")', E_USER_NOTICE);
    }
    else {
      throw new KeyException(
        "Invalid keystore type (JCEKS). Was unable to convert to PKCS#12: \n[keytool] " .
        implode("\n[keytool] ", $out));
    }
    return $newFilename;
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
    return 'pkcs12';
  }

  public function getClientCertificate() {

  }

  public function getCertificateChain($alias = '') {
    return $this->chain;
  }

  // TODO: Fix lookup by alias
  public function getCertificate($alias) {
    return $this->X509Certificate;
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
