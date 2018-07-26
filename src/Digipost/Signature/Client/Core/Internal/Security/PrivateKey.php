<?php

namespace Digipost\Signature\Client\Core\Internal\Security;

use Digipost\Signature\Client\Core\Exceptions\DecryptionFailedException;
use Digipost\Signature\Client\Core\Exceptions\InvalidMessageDigestAlgorithmException;
use Digipost\Signature\Client\Core\Exceptions\OpenSSLExtensionNotLoadedException;
use Digipost\Signature\Client\Core\Exceptions\PrivateKeyDecryptionFailedException;
use Digipost\Signature\Client\Core\Exceptions\RuntimeIOException;
use MyCLabs\Enum\Enum;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class PrivateKeyType
 *
 * @package Digipost\Signature\Client\Core\Internal\Security
 */
class PrivateKeyType extends Enum {
  const OPENSSL_KEYTYPE_RSA = 0;
}

/**
 * Class PrivateKey
 *
 * @package Digipost\Signature\Client\Core\Internal\Security
 */
class PrivateKey implements PrivateKeyInterface {

  private $keyResource = NULL;

  private $passphrase;

  /**
   * Holds a private key so you can sign or decrypt stuff with it, must be cleartext,
   * since we need the binary format as well.
   *
   * @param string $privateKey
   * @param string $passphrase
   *
   * @throws OpenSSLExtensionNotLoadedException
   * @throws PrivateKeyDecryptionFailedException
   */
  public function __construct($privateKey, $passphrase = '') {
    if (!extension_loaded('openssl')) {
      throw new OpenSSLExtensionNotLoadedException('The openssl module is not loaded.');
    }

    $this->keyResource = openssl_pkey_get_private($privateKey, $passphrase);
    if ($this->keyResource === FALSE) {
      throw new PrivateKeyDecryptionFailedException(
        'Could not decrypt the private key, the passphrase is incorrect, ' .
        'its contents are mangled or it is not a valid private key.');
    }
  }

  /**
   * Initialize the private key from a file.
   *
   * @param string $privatekeyLocation
   *
   * @param        $passphrase
   *
   * @return PrivateKey
   * @throws OpenSSLExtensionNotLoadedException
   * @throws PrivateKeyDecryptionFailedException
   */
  public static function initFromFile($privatekeyLocation, $passphrase) {
    if (!file_exists($privatekeyLocation)) {
      throw new FileNotFoundException("The private key file '$privatekeyLocation' does not exist.");
    }
    if (!is_readable($privatekeyLocation)) {
      throw new RuntimeIOException("The private key file '$privatekeyLocation' is not readable.");
    }
    return new self(file_get_contents($privatekeyLocation), $passphrase);
  }

  /**
   * Signs the data passed in the argument, returns the signature in binary format.
   *
   * @param mixed  $data The data to be signed
   * @param string $algorithm
   *
   * @return binary
   */
  public function sign($data, $algorithm = 'RSA-SHA256') {
    if (!in_array($algorithm, openssl_get_md_methods(TRUE))) {
      throw new InvalidMessageDigestAlgorithmException(
        "The digest algorithm '$algorithm' is not supported by this openssl implementation.");
    }
    openssl_sign($data, $signature, $this->keyResource, $algorithm);
    return $signature;
  }

  /**
   * Decrypts $data using this private key.
   *
   * @param mixed $data
   *
   * @return string
   * @throws DecryptionFailedException
   */
  public function decrypt($data) {
    if (!openssl_private_decrypt($data, $decrypted, $this->keyResource)) {
      throw new DecryptionFailedException('Failed decrypting the data with this private key.');
    }
    return $decrypted;
  }

  /**
   * Frees the resource associated with this private key.
   * This is automatically done on destruct.
   */
  private function free() {
    if ($this->keyResource) {
      openssl_pkey_free($this->keyResource);
    }
    $this->keyResource = NULL;
  }

  public function __destruct() {
    $this->free();
  }

  /**
   * String representation of object
   *
   * @link  http://php.net/manual/en/serializable.serialize.php
   * @return string the string representation of the object or null
   * @since 5.1.0
   */
  public function serialize() {
    openssl_pkey_export($this->keyResource, $keyValue, $this->passphrase);
    return $keyValue;
  }

  /**
   * Constructs the object
   *
   * @link  http://php.net/manual/en/serializable.unserialize.php
   *
   * @param string $serialized <p>
   *                           The string representation of the object.
   *                           </p>
   *
   * @return void
   * @since 5.1.0
   */
  public function unserialize($serialized) {
    // TODO: Implement unserialize() method.
  }

  function getAlgorithm(): String {
    // TODO: Implement getAlgorithm() method.
  }

  function getFormat(): String {
  }

  function getEncoded(): String {
    openssl_pkey_export($this->keyResource, $out);
    return $out;
  }

  function getDetails() {
    return $this->serialize();
    //return $this->getKeyInfo();
    //$details = openssl_pkey_get_details($this->keyResource);
    //return $details;
  }
  public function getPublicKey() {
    return openssl_pkey_get_public($this->keyResource);
  }

  public function getRaw() {
    return $this->keyResource;
  }
}