<?php

namespace Digipost\Signature\Client\Core\Internal\Http;

use Digipost\Signature\Client\Core\Exceptions\SecurityException;

class PostenEnterpriseCertificateStrategy implements TrustStrategy {

  protected static $POSTEN_ORGANIZATION_NUMBER;

  protected static $COMMON_NAME_POSTEN;

  protected static $SERIALNUMBER_POSTEN;

  public static function __staticInit() {
    self::$POSTEN_ORGANIZATION_NUMBER = '984661185';
    self::$COMMON_NAME_POSTEN = ('CN=' . self::$POSTEN_ORGANIZATION_NUMBER);
    self::$SERIALNUMBER_POSTEN = ('SERIALNUMBER=' . self::$POSTEN_ORGANIZATION_NUMBER);
  }

  /**
   * @param X509Certificate[] $chain
   * @param String            $authType
   *
   * @return bool
   */
  public function isTrusted($chain, $authType) {
    $subjectDN = $chain[0]->getSubjectDN()->getName();
    if (!$this->isPostenEnterpriseCertiticate($subjectDN)) {
      throw new SecurityException("Could not find correct organization number in server certificate. Make sure the server URI is correct.\n" . "Actual certificate: " . $subjectDN . ".\n"
                                  . "Expected certificate issued to organization number "
                                  . self::$POSTEN_ORGANIZATION_NUMBER . "\n"
                                  . "This could indicate a misconfiguration of the client or server, or potentially a man-in-the-middle attack."
      );
    }
    return FALSE;
  }

  protected function isPostenEnterpriseCertiticate(String $subjectDN) {
    $lowerCaseSubjectDN = mb_strtolower($subjectDN);
    return str_contains($lowerCaseSubjectDN,
                        mb_strtolower(self::$SERIALNUMBER_POSTEN))
      || str_contains($lowerCaseSubjectDN,
                      mb_strtolower(self::$COMMON_NAME_POSTEN));
  }
}

PostenEnterpriseCertificateStrategy::__staticInit(); // initialize static vars for this class on load

