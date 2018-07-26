<?php

namespace Digipost\Signature\Client\Core\Internal;

use Digipost\Signature\Client\Core\Exceptions\ConfigurationException;
use Digipost\Signature\Client\Core\Exceptions\ProcessingException;
use Digipost\Signature\Client\Core\Exceptions\SignatureException;
use Digipost\Signature\Client\Core\Exceptions\SSLException;
use Digipost\Signature\Client\Core\Exceptions\SSLHandshakeException;

class ClientExceptionMapper {

  function doWithMappedClientException(callable $action) {
    return $this->doWithMappedClientException__Supplier(
      function () use ($action) {
        return $action();
      }
    );
  }

  private function doWithMappedClientException__Supplier($produceResult) {
    try {
      return $produceResult();
    } catch (ProcessingException $e) {
      throw $this->map($e);
    }
  }

  private function map(ProcessingException $e) {
    if ($e instanceof SSLException) {
      $sslExceptionMessage = $e->getMessage();
      if ($sslExceptionMessage !== NULL && stristr(
          $sslExceptionMessage, "protocol_version"
        )) {
        return new ConfigurationException(
          "Invalid TLS protocol version. This will typically happen if you're running on an older Java version, which doesn't support TLS 1.2. " .
          "Java 7 needs to be explicitly configured to support TLS 1.2. See 'JSSE tuning parameters' at " .
          "https://blogs.oracle.com/java-platform-group/entry/diagnosing_tls_ssl_and_https.",
          $e
        );
      }
    }

    if ($e instanceof SSLHandshakeException) {
      return new SignatureException(
        "Unable to perform SSL handshake with remote server. Some possible causes (could be others, see underlying error): \n" .
        "* A certificate with the wrong KeyUsage was used. The keyUsage should be DigitalSignature\n" .
        "* Erroneous configuration of the trust store\n" .
        "* Intermediate network devices interfering with traffic (e.g. proxies)\n" .
        "* An attacker impersonating the server (man in the middle)\n" .
        "* Wrong TLS version. For Java 7, see 'JSSE tuning parameters' at https://blogs.oracle.com/java-platform-group/entry/diagnosing_tls_ssl_and_https for information about enabling the latest TLS versions",
        $e
      );
    }

    return $e;
  }
}
