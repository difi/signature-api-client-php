<?php

namespace Digipost\Signature\Client\Core\Internal\Security;

class CertificateRevocationList {

  /**
   * The URI to the CRL
   *
   * @var string
   */
  private $URI;

  /**
   * The path to the local copy of the CRL
   *
   * @var string
   */
  private $localPath;

  /**
   * Creates a new CRL. Fetches it from the URI if it does not exist as a
   * cached copy or the copy is stale.
   *
   * @param string $URI The URI to the revocation list.
   */
  public function __construct($URI) {
    $this->URI = $URI;
    $this->localPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . sha1(
        getenv('HOME') . $this->URI
      ) . '.crl';
  }

  public function __get($name) {
    switch ($name) {
      case 'URI':
        return $this->URI;
      case 'localPath':
        return $this->localPath;
      case 'localModified':
        if (file_exists($this->localPath)) {
          return new \DateTime('@' . filemtime($this->localPath));
        }
        return NULL;
      case 'nextUpdate':
        $this->populateFields();
        return $this->_nextUpdate;
      case 'lastUpdate':
        $this->populateFields();
        return $this->_lastUpdate;
      case 'hash':
        $this->populateFields();
        return $this->_hash;
      case 'fingerprint':
        $this->populateFields();
        return $this->_fingerprint;
      case 'crlNumber':
        $this->populateFields();
        return $this->_crlNumber;
      case 'issuer':
        $this->populateFields();
        return $this->_issuer;
      case 'pemText':
        $this->refresh();
        $pemText = base64_encode(file_get_contents($this->localPath));
        $pemText = wordwrap($pemText, 64, "\r\n", TRUE);
        $pemText = <<<End
-----BEGIN X509 CRL-----
$pemText
-----END X509 CRL-----
End;
        return $pemText;
      default:
        return NULL;
    }
  }

  public function toPEM() {
    $this->refresh();
    $pemText = base64_encode(file_get_contents($this->localPath));
    $pemText = wordwrap($pemText, 64, "\r\n", TRUE);
    $pemText = <<<End
-----BEGIN X509 CRL-----
$pemText
-----END X509 CRL-----
End;
    return $pemText;
  }

  private $_nextUpdate;

  private $_lastUpdate;

  private $_hash;

  private $_fingerprint;

  private $_crlNumber;

  private $_issuer;

  /**
   * Whether the local fields have been populated.
   *
   * @var boolean
   */
  private $fieldsPopulated = FALSE;

  private function populateFields() {
    if ($this->fieldsPopulated) {
      return;
    }
    if (!file_exists($this->localPath)) {
      $this->refresh();
    }
    $fields = ' -nextupdate -lastupdate -hash -fingerprint -crlnumber -issuer';
    exec("openssl crl -inform DER$fields -noout -in $this->localPath", $output);
    foreach ($output as $line) {
      if (preg_match('/^([^=]+)=(.*)/', $line, $matches) == 1) {
        switch ($matches[1]) {
          case 'nextUpdate':
            $this->_nextUpdate = new \DateTime($matches[2]);
            continue 2;
          case 'lastUpdate':
            $this->_lastUpdate = new \DateTime($matches[2]);
            continue 2;
          case 'SHA1 Fingerprint':
            $this->_fingerprint = $matches[2];
            continue 2;
          case 'crlNumber':
            $this->_crlNumber = $matches[2];
            continue 2;
          case 'issuer':
            $this->_issuer = $matches[2];
            continue 2;
        }
      }
      else {
        if (preg_match('/^([a-f0-9]{8})/', $line, $matches) == 1) {
          $this->_hash = $matches[1];
        }
      }
    }
    $this->fieldsPopulated = TRUE;
  }

  /**
   * Fetches the CRL from the URI if the local copy is stale.
   *
   * @property boolean $force Whether to force the refresh.
   * @return string
   * @throws CRLFetchException
   * @throws CRLWriteException
   */
  public function refresh($force = FALSE) {
    $now = new \DateTime();
    if ($force || !file_exists($this->localPath)) {
      // If the local copy of the CRL does not exist or we are forced to fetch the file, do it.
      $this->fetch();
    }
    else {
      if ($now > $this->nextUpdate) {
        // If the local copy of the CRL states that the next update has taken place, fetch the new CRL
        $this->fetch();
      }
    }
  }

  /**
   * @throws CRLFetchException
   * @throws CRLWriteException
   */
  private function fetch() {
    if (FALSE === $remoteContents = file_get_contents($this->URI)) {
      throw new CRLFetchException("Unable to fetch the CRL at $this->URI");
    }
    if (file_put_contents($this->localPath, $remoteContents) === FALSE) {
      throw new CRLWriteException(
        "Could not write the contents of the remote CRL to the local copy."
      );
    }
  }

  /**
   * Combines the list of CRLs to on PEM file.
   *
   * @param array $crls
   *
   * @return string
   */
  public static function combineToPEM(array $crls) {
    $pemFileName = '';
    foreach ($crls as $crl) {
      $pemFileName .= sha1($crl->localPath);
    }
    $pemFileName = sys_get_temp_dir() . DIRECTORY_SEPARATOR . sha1(
        $pemFileName
      ) . '.pem';
    /* If there already is a PEM file for those specific CRLs, check if it is stale.
     * Remove it if it is, otherwise just return that. */
    if (file_exists($pemFileName)) {
      $modified = new \DateTime('@' . filemtime($pemFileName));
      $stale = FALSE;
      foreach ($crls as $crl) {
        $crl->refresh();
        if ($modified < $crl->localModified) {
          $stale = TRUE;
          break;
        }
      }
      if (!$stale) {
        return $pemFileName;
      }
      unlink($pemFileName);
    }
    foreach ($crls as $crl) {
      file_put_contents($pemFileName, $crl->toPEM(), FILE_APPEND);
    }
    return $pemFileName;
  }
}