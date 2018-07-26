<?php

namespace Digipost\Signature\JAXB;

use Digipost\Signature\Client\Core\Internal\Util;

class QName implements \Serializable {

  private $namespaceURI;

  private $localPart;

  private $prefix;

  /**
   * QName constructor.
   *
   * @param String|NULL $namespaceURI
   * @param String      $localPart
   * @param String      $prefix
   */
  public function __construct(
    String $namespaceURI = "",
    String $localPart = NULL,
    String $prefix = ""
  ) {
    $namespaceURI = $namespaceURI === NULL ? '' : $namespaceURI;
    $this->namespaceURI = $namespaceURI;
    if ($localPart === NULL) {
      throw new \InvalidArgumentException(
        'local part cannot be "null" when creating a QName'
      );
    }
    $this->localPart = $localPart;
    if ($prefix === NULL) {
      throw new \InvalidArgumentException(
        'prefix cannot be "null" when creating a QName'
      );
    }
    $this->prefix = $prefix;
  }

  public function equals($objectToTest) {
    if ($objectToTest === $this) {
      return TRUE;
    }
    else {
      if ($objectToTest !== NULL && $objectToTest instanceof QName) {
        $qName = $objectToTest;
        return $this->localPart === $qName->localPart && $this->namespaceURI === $qName->namespaceURI;
      }
      else {
        return FALSE;
      }
    }
  }

  public function hashCode() {
    return Util::hashCode($this->namespaceURI) ^ Util::hashCode(
        $this->localPart
      );
  }

  public function __toString() {
    return empty($this->namespaceURI) ? $this->localPart : '{' . $this->namespaceURI . '}' . $this->localPart;
  }

  public static function valueOf(String $qNameAsString) {
    if ($qNameAsString === NULL) {
      throw new \InvalidArgumentException(
        'cannot create QName from "null" or "" String'
      );
    }
    else {
      if (strlen($qNameAsString) === 0) {
        return new QName('', $qNameAsString, '');
      }
      else {
        if (substr($qNameAsString, 0, 1) !== '{') {
          return new QName('', $qNameAsString, '');
        }
        else {
          if (substr($qNameAsString, 0, 2) === '{}') {
            throw new \InvalidArgumentException(
              'Namespace URI .equals(XMLConstants.NULL_NS_URI), .equals(""), only the local part, "' . substr(
                $qNameAsString,
                2
              ) . ', should be provided.'
            );
          }
          else {
            $endOfNamespaceURI = strpos($qNameAsString, chr(125));
            if ($endOfNamespaceURI === -1) {
              throw new \InvalidArgumentException(
                'cannot create QName from ' . $qNameAsString . ', missing closing "}"'
              );
            }
            else {
              return new QName(
                substr(
                  $qNameAsString, 1,
                  $endOfNamespaceURI - 1
                ),
                substr($qNameAsString, $endOfNamespaceURI + 1),
                ""
              );
            }
          }
        }
      }
    }
  }

  /**
   * @inheritdoc
   */
  public function serialize() {
    return $this->__toString();
  }

  /**
   * @inheritdoc
   */
  public function unserialize($serialized) {
    QName::valueOf($serialized);
  }
}