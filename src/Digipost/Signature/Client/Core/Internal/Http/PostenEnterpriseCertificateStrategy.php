<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

use Digipost\Signature\Client\Core\Exceptions\SecurityException;
use Digipost\Signature\Client\Core\Internal\Security\KeyStore;
use Sop\CryptoEncoding\PEM;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use X509\Certificate\Certificate;
use X509\Certificate\CertificateBundle;
use X509\Certificate\CertificateChain;
use X509\CertificationPath\Exception\PathBuildingException;
use X509\CertificationPath\PathBuilding\CertificationPathBuilder;
use X509\CertificationPath\PathValidation\PathValidationConfig;

class PostenEnterpriseCertificateStrategy {

  protected static $POSTEN_ORGANIZATION_NUMBER = '984661185';

  /**
   * Used by some obscure cases to embed Norwegian "organisasjonsnummer" in certificates.
   */
  protected static $COMMON_NAME_POSTEN;

  /**
   * Most common way to embed Norwegian "organisasjonsnummer" in certificates.
   */
  protected static $SERIALNUMBER_POSTEN;

  /**
   * @var KeyStore
   */
  private $keyStore;

  /**
   * @var EventDispatcherInterface
   */
  private $eventDispatcher;

  /**
   * @var CertificateBundle
   */
  private $trustedBundle;
  /**
   * @var CertificateBundle
   */
  private $intermediates;

  public static function __staticInit() {
    self::$COMMON_NAME_POSTEN = 'CN=' . self::$POSTEN_ORGANIZATION_NUMBER;
    self::$SERIALNUMBER_POSTEN = 'SERIALNUMBER=' . self::$POSTEN_ORGANIZATION_NUMBER;
  }

  public function __construct(
    KeyStore $keyStore, EventDispatcherInterface $eventDispatcher
  ) {
    $certificateChain =
      array_map(
        function (\Digipost\Signature\Client\Core\Internal\Security\X509Certificate $c) {
          return Certificate::fromPEM(PEM::fromString($c->getClearText()));
        }, $keyStore->getCertificateChain()
      );

    $this->keyStore = $keyStore;
    $this->eventDispatcher = $eventDispatcher;
    $this->trustedBundle = new CertificateBundle(
      ...array_filter(
           $certificateChain,
           function ($cert) {
             /** @var Certificate $cert */
             return $cert->isSelfIssued();
           }
         )
    );
    $this->intermediates = new CertificateBundle(
      ...array_filter(
           $certificateChain,
           function ($cert) {
             /** @var Certificate $cert */
             return !$this->trustedBundle->contains($cert);
           }
         )
    );

    $this->eventDispatcher->addListener(
      'client.guzzle.on_headers',
      function () {
        return call_user_func_array([$this, 'onClientHeaders'], func_get_args());
      }
    );
  }

  /**
   * Verify that the server certificate is issued to Posten Norge AS.
   *
   * @see \Digipost\Signature\Client\ClientConfigurationBuilder::setTrustStrategy
   *
   * @param CertificateChain $chain
   *
   * @return bool
   */
  public function isTrusted(CertificateChain $chain) {
    $cert = $chain->endEntityCertificate();

    $path_builder = new CertificationPathBuilder($this->trustedBundle);
    try {
      $certification_path = $path_builder->shortestPathToTarget($cert, $this->intermediates);
      $certification_path->validate(PathValidationConfig::defaultConfig());
    } catch (PathBuildingException $e) {
      throw $e;
    }

    $subjectDN = $cert->tbsCertificate()->subject()->toString();
    if (!$this->isPostenEnterpriseCertificate($subjectDN)) {
      throw new SecurityException(
        "Could not find correct organization number in server certificate. Make sure the server URI is correct.\n"
        . "Actual certificate: " . $subjectDN . ".\n"
        . "Expected certificate issued to organization number " . self::$POSTEN_ORGANIZATION_NUMBER . "\n"
        . "This could indicate a misconfiguration of the client or server, or potentially a man-in-the-middle attack."
      );
    }

    return FALSE;
  }

  protected function isPostenEnterpriseCertificate(String $subjectDN) {
    $lowerCaseSubjectDN = mb_strtolower($subjectDN);

    return strpos(
        $lowerCaseSubjectDN,
        mb_strtolower(self::$SERIALNUMBER_POSTEN)
      ) > -1
      || strpos(
        $lowerCaseSubjectDN,
        mb_strtolower(self::$COMMON_NAME_POSTEN)
      ) > -1;
  }
}

PostenEnterpriseCertificateStrategy::__staticInit();

