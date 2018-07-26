<?php

namespace Digipost\Signature\Client\Core\Internal\Security;

use Digipost\Signature\Client\Core\Exceptions\DecryptionFailedException;
use Digipost\Signature\Client\Core\Exceptions\InvalidMessageDigestAlgorithmException;
use Digipost\Signature\Client\Core\Exceptions\OpenSSLExtensionNotLoadedException;

class PublicKey implements PublicKeyInterface {

  public $keyResource = NULL;

  /**
   * PublicKey constructor.
   *
   * @param $certificate
   *
   * @throws OpenSSLExtensionNotLoadedException
   */
  public function __construct($certificate) {
    if (!extension_loaded('openssl')) {
      throw new OpenSSLExtensionNotLoadedException('The openssl module is not loaded.');
    }
    $this->keyResource = openssl_pkey_get_public($certificate);
  }

  private function getDetails(): array {
    $keyData = openssl_pkey_get_details($this->keyResource);
    return $keyData;
  }

  public function getEncodedAsXML(): String {
    $keyData = $this->getDetails();
    return sprintf("<RSAKeyValue><Modulus>%s</Modulus><Exponent>%s</Exponent></RSAKeyValue>",
                   base64_encode($keyData['rsa']['n']),
                   base64_encode($keyData['rsa']['e']));
  }

  public function getAlgorithm(): String {
    $key = openssl_get_publickey($this->keyResource);
    return '';
  }

  /**
   * Verifies that the data and the signature belong to this public key.
   * Returns true on success, false on failure.
   *
   * @param mixed  $data      The data to be verified
   * @param mixed  $signature The signature of the data
   * @param string $algorithm Which algorithm to use for signing
   *
   * @return boolean
   * @throws InvalidMessageDigestAlgorithmException
   */
  public function verify($data, $signature, $algorithm = 'RSA-SHA256') {
    if (!in_array($algorithm, openssl_get_md_methods(TRUE))) {
      throw new InvalidMessageDigestAlgorithmException(
        "The digest algorithm '$algorithm' is not supported by this openssl implementation.");
    }
    return openssl_verify($data, $signature, $this->keyResource,
                          $algorithm) == 1;
  }

  /**
   * Decrypts $data using this public key.
   *
   * @param mixed $data
   *
   * @return string
   * @throws DecryptionFailedException
   */
  public function decrypt($data) {
    if (!openssl_public_decrypt($data, $decrypted, $this->keyResource)) {
      throw new DecryptionFailedException('Failed decrypting the data with this public key.');
    }
    return $decrypted;
  }

  public function __destruct() {
    if ($this->keyResource) {
      openssl_free_key($this->keyResource);
    }
  }

  /**
   * @inheritdoc
   */
  public function serialize() {
    return $this->getEncoded();
  }

  /**
   * @inheritdoc
   */
  public function unserialize($serialized) {
    // TODO: Implement unserialize() method.
  }

  function getFormat(): String {
    // TODO: Implement getFormat() method.
  }

  function getEncoded(): String {
    $details = $this->getDetails();
    return $details['key'];
  }
}