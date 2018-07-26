<?php

namespace Digipost\Signature\Client\Core\Internal\XML;

/**
 * Class XMLUtils
 *
 * @package Digipost\Signature\Client\Core\Internal\XML
 */
class XMLUtils {

  private static $ignoreLineBreaks = FALSE;

  private static $dsPrefix = "ds";

  private static $ds11Prefix = "dsig11";

  private static $xencPrefix = "xenc";

  private static $xenc11Prefix = "xenc11";

  //private static final Logger log = Logger.getLogger(XMLUtils.class.getName());

  function __construct() {
  }

  public static function setDsPrefix(String $var0) {
    JavaUtils::checkRegisterPermission();
    self::$dsPrefix = $var0;
  }

  public static function setDs11Prefix(String $var0) {
    JavaUtils::checkRegisterPermission();
    self::$ds11Prefix = $var0;
  }

  public static function setXencPrefix(String $var0) {
    JavaUtils::checkRegisterPermission();
    self::$xencPrefix = $var0;
  }

  public static function setXenc11Prefix(String $var0) {
    JavaUtils::checkRegisterPermission();
    self::$xenc11Prefix = $var0;
  }

  public static function getNextElement(\DOMNode $var0) {
    $var1 = NULL;
    for ($var1 = $var0; $var1 !== NULL && $var1->nodeType !== XML_ELEMENT_NODE; $var1 = $var1->nextSibling) {
      ;
    }
    return $var1;
  }

  public static function getSet(\DOMNode $var0, array $var1, \DOMNode $var2,
                                bool $var3) {
    if (!isset($var2) || !self::isDescendantOrSelf($var2, $var0)) {
      self::getSetRec($var0, $var1, $var2, $var3);
    }
  }

  private static function getSetRec(\DOMNode $var0, array $var1, \DOMNode $var2,
                                    bool $var3) {
    if ($var0 !== $var2) {
      switch ($var0->nodeType) {
        case XML_ELEMENT_NODE:
          $var1[] = $var0;
          $var4 = $var0;
          if ($var4->hasAttributes()) {
            $var5 = $var4->attributes;

            for ($var6 = 0; $var6 < $var5->length; ++$var6) {
              $var1[] = $var5->item($var6);
            }
          }
        case XML_DOCUMENT_NODE:
          for ($var7 = $var0->firstChild; $var7 !== NULL; $var7 = $var7->nextSibling) {
            if ($var7->nodeType === XML_TEXT_NODE) {
              $var1[] = $var7;

              while ($var7 !== NULL && $var7->nodeType === XML_TEXT_NODE) {
                $var7 = $var7->nextSibling;
              }

              if ($var7 === NULL) {
                return;
              }
            }

            self::getSetRec($var7, $var1, $var2, $var3);
          }

          return;
        case XML_ATTRIBUTE_NODE:
        case XML_TEXT_NODE:
        case XML_CDATA_SECTION_NODE:
        case XML_ENTITY_REF_NODE:
        case XML_ENTITY_NODE:
        case XML_PI_NODE:
        default:
          $var1[] = $var0;
          return;
        case XML_COMMENT_NODE:
          if ($var3) {
            $var1[] = $var0;
          }

          return;
        case XML_DOCUMENT_TYPE_NODE:
      }
    }
  }

  public static function outputDOM(\DOMNode $var0, Stream $var1, bool $var2 = FALSE) {
    try {
      if ($var2) {
        $var1->write("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
      }

      $var1->write(Canonicalizer::getInstance("http://www.w3.org/TR/2001/REC-xml-c14n-20010315#WithComments")
                     ->canonicalizeSubtree($var0));
    } catch (\Exception $var4) {
      //    if (log.isLoggable(Level.FINE)) {
      //      log.log(Level.FINE, var4.getMessage(), var4);
      //    }
    } catch (InvalidCanonicalizerException $var5) {
      //    if (log.isLoggable(Level.FINE)) {
      //      log.log(Level.FINE, var5.getMessage(), var5);
      //    }
    } catch (CanonicalizationException $var6) {
      //    if (log.isLoggable(Level.FINE)) {
      //      log.log(Level.FINE, var6.getMessage(), var6);
      //    }
    }
  }

  public static function outputDOMc14nWithComments(\DOMNode $var0,
                                                   Stream $var1) {
    try {
      $var1->write(Canonicalizer::getInstance("http://www.w3.org/TR/2001/REC-xml-c14n-20010315#WithComments")
                     ->canonicalizeSubtree($var0));
    } catch (IOException $var3) {
      //    if (log.isLoggable(Level.FINE)) {
      //      log.log(Level.FINE, var3.getMessage(), var3);
      //    }
    } catch (InvalidCanonicalizerException $var4) {
      //    if (log.isLoggable(Level.FINE)) {
      //      log.log(Level.FINE, var4.getMessage(), var4);
      //    }
    } catch (CanonicalizationException $var5) {
      //    if (log.isLoggable(Level.FINE)) {
      //      log.log(Level.FINE, var5.getMessage(), var5);
      //    }
    }

  }

  public static function getFullTextChildrenFromElement(\DOMElement $var0) {
    $var1 = [];

    for ($var2 = $var0->firstChild; $var2 !== NULL; $var2 = $var2->nextSibling) {
      if ($var2->nodeType === XML_TEXT_NODE) {
        $var1[] = (string) $var2->nodeValue;
      }
    }

    return implode('', $var1);
  }

  public static function createElementInSignatureSpace(\DOMDocument $var0,
                                                       String $var1) {
    if (!isset($var0)) {
      throw new \RuntimeException("Document is null");
    }
    else {
      return self::$dsPrefix !== NULL && strlen(self::$dsPrefix) !== 0 ? $var0->createElementNS("http://www.w3.org/2000/09/xmldsig#",
                                                                                                self::$dsPrefix . ":" . $var1) : $var0->createElementNS("http://www.w3.org/2000/09/xmldsig#",
                                                                                                                                                        $var1);
    }
  }

  public static function createElementInSignature11Space(\DOMDocument $var0,
                                                         String $var1) {
    if (!isset($var0)) {
      throw new \RuntimeException("Document is null");
    }
    else {
      return self::$ds11Prefix !== NULL && strlen(self::$ds11Prefix) !== 0 ? $var0->createElementNS("http://www.w3.org/2009/xmldsig11#",
                                                                                                    self::$ds11Prefix . ":" . $var1) : $var0->createElementNS("http://www.w3.org/2009/xmldsig11#",
                                                                                                                                                              $var1);
    }
  }

  public static function createElementInEncryptionSpace(\DOMDocument $var0,
                                                        String $var1) {
    if (!isset($var0)) {
      throw new \RuntimeException("Document is null");
    }
    else {
      return self::$xencPrefix !== NULL && strlen(self::$xencPrefix) !== 0 ? $var0->createElementNS("http://www.w3.org/2001/04/xmlenc#",
                                                                                                    self::$xencPrefix . ":" . $var1) : $var0->createElementNS("http://www.w3.org/2001/04/xmlenc#",
                                                                                                                                                              $var1);
    }
  }

  public static function createElementInEncryption11Space(\DOMDocument $var0,
                                                          String $var1) {
    if (!isset($var0)) {
      throw new \RuntimeException("Document is null");
    }
    else {
      return self::$xenc11Prefix !== NULL && strlen(self::$xenc11Prefix) !== 0 ? $var0->createElementNS("http://www.w3.org/2009/xmlenc11#",
                                                                                                        self::$xenc11Prefix . ":" . $var1) : $var0->createElementNS("http://www.w3.org/2009/xmlenc11#",
                                                                                                                                                                    $var1);
    }
  }

  public static function elementIsInSignatureSpace(\DOMElement $var0,
                                                   String $var1) {

    if (!isset($var0)) {

      return FALSE;
    }

    else {
      return "http://www.w3.org/2000/09/xmldsig#" === $var0->namespaceURI && $var0->localName === $var1;
    }
  }

  public
  static function elementIsInSignature11Space(\DOMElement $var0, String $var1) {
    if (!isset($var0)) {
      return FALSE;
    }
    else {
      return "http://www.w3.org/2009/xmldsig11#" === $var0->namespaceURI && $var0->localName === $var1;
    }
  }

  public static function elementIsInEncryptionSpace(\DOMElement $var0,
                                                    String $var1) {
    if (!isset($var0)) {
      return FALSE;
    }
    else {
      return "http://www.w3.org/2001/04/xmlenc#" === $var0->namespaceURI && $var0->localName === $var1;
    }
  }

  public static function elementIsInEncryption11Space(\DOMElement $var0,
                                                      String $var1) {
    if (!isset($var0)) {
      return FALSE;
    }
    else {
      return "http://www.w3.org/2009/xmlenc11#" === $var0->namespaceURI && $var0->localName === $var1;
    }
  }

  private static function getOwnerDocument_Node(\DOMNode $var0) {
    if ($var0->nodeType === XML_DOCUMENT_NODE) {
      return $var0;
    }
    else {
      try {
        return $var0->ownerDocument;
      } catch (\Exception $var2) {
        throw new \Exception("Original message was \"" . $var2->getMessage() . "\"");
      }
    }
  }

  /**
   * @param \DomNode|\DOMNode[] $var0
   *
   * @return \DOMDocument
   * @throws \Exception
   */
  public static function getOwnerDocument($var0) {
    if (!is_array($var0)) {
      return self::getOwnerDocument_Node($var0);
    }

    $var1 = NULL;
    //$var2 = $var0->iterator;

    while (list(,$var3) = each($var0)) {
      /** @var \DOMNode $var3 */
      $var4 = $var3->nodeType;
      if ($var4 === XML_DOCUMENT_NODE) {
        return $var3;
      }

      try {
        if ($var4 === XML_ATTRIBUTE_NODE) {
          /** @var \DOMAttr $var3 */
          return $var3->ownerElement->ownerDocument;
        }

        return $var3->ownerDocument;
      } catch (\Exception $var6) {
        $var1 = $var6;
      }
    }

    throw new \Exception("Original message was \"" . ($var1 === NULL ? "" : $var1->getMessage()) . "\"");
  }

  public static function createDSctx(\DOMDocument $var0, String $var1,
                                     String $var2) {

    if ($var1 !== NULL && strlen(trim($var1)) !== 0) {

      $var3 = $var0->createElementNS((string) NULL, "namespaceContext");
      $var3->setAttributeNS("http://www.w3.org/2000/xmlns/",
                            "xmlns:" . trim($var1), $var2);
      return $var3;
    }

    else {
      throw new \InvalidArgumentException("You must supply a prefix");
    }
  }

  /**
   * @param \DOMElement|\DOMDocument $var0
   * @param HelperNodeList|null      $var1
   */
  public static function addReturnToElement($var0,
                                            HelperNodeList $var1 = NULL) {
    if (func_num_args() > 1) {
      self::addReturnToElement_Document($var0, $var1);
      return;
    }
    if (self::$ignoreLineBreaks) {
      $var1 = $var0->ownerDocument;
      $var0->appendChild($var1->createTextNode("\n"));
    }

  }

  public static function addReturnToElement_Document(\DOMDocument $var0,
                                                     HelperNodeList $var1) {
    if (!self::$ignoreLineBreaks) {
      $var1->appendChild($var0->createTextNode("\n"));
    }
  }

  public static function addReturnBeforeChild(\DOMElement $var0,
                                              \DOMNode $var1) {
    if (!self::$ignoreLineBreaks) {
      $var2 = $var0->ownerDocument;
      $var0->insertBefore($var2->createTextNode("\n"), $var1);
    }

  }

  public static function convertNodelistToSet(\DOMNodeList $var0) {
    if (!isset($var0)) {
      return new Set();
    }
    else {
      $var1 = $var0->length;
      $var2 = new Set();

      for ($var3 = 0; $var3 < $var1; ++$var3) {
        $var2->add($var0->item($var3));
      }

      return $var2;
    }
  }

  public static function circumventBug2650(\DOMDocument $var0) {
    $var1 = $var0->documentElement;
    $var2 = $var1->getAttributeNodeNS("http://www.w3.org/2000/xmlns/",
                                      "xmlns");
    if ($var2 === NULL) {
      $var1->setAttributeNS("http://www.w3.org/2000/xmlns/", "xmlns", "");
    }

    self::circumventBug2650internal($var0);
  }

  private static function circumventBug2650internal(\DOMNode $var0) {
    $var1 = NULL;
    $var2 = NULL;

    while (TRUE) {
      switch ($var0->nodeType) {
        case XML_ELEMENT_NODE:
          $var4 = $var0;
          if (!$var4->hasChildNodes()) {
            break;
          }

          if ($var4->hasAttributes()) {
            $var5 = $var4->attributes;
            $var6 = $var5->length;

            for ($var7 = $var4->firstChild; $var7 != NULL; $var7 = $var7->nextSibling) {
              if ($var7->nodeType === XML_ELEMENT_NODE) {
                $var8 = $var7;

                for ($var9 = 0; $var9 < $var6; ++$var9) {
                  $var10 = $var5->item($var9);
                  /** @var \DOMElement $var8 */
                  /** @var \DOMAttr $var10 */
                  if ("http://www.w3.org/2000/xmlns/" === $var10->namespaceURI && !$var8->hasAttributeNS("http://www.w3.org/2000/xmlns/",
                                                                                                         $var10->localName)) {
                    $var8->setAttributeNS("http://www.w3.org/2000/xmlns/",
                                          "test",
                                          "test");
                  }
                }
              }
            }
          }
        case
        5:
        case 9:
          $var1 = $var0;
          $var2 = $var0->firstChild;
      }

      while ($var2 === NULL && $var1 !== NULL) {

        $var2 = $var1->nextSibling;
        $var1 = $var1->parentNode;
      }

      if ($var2 === NULL) {
        return;
      }

      $var0 = $var2;
      $var2 = $var2->nextSibling;
    }
  }

  public static function selectDsNode(\DOMNode $var0, String $var1, int $var2) {
    for (; $var0 !== NULL; $var0 = $var0->nextSibling) {
      if ("http://www.w3.org/2000/09/xmldsig#" === $var0->namespaceURI && $var0->localName === $var1) {
        if ($var2 === 0) {
          return $var0;
        }

        --$var2;
      }
    }

    return NULL;
  }

  public static function selectDs11Node(\DOMNode $var0, String $var1,
                                        int $var2) {
    for (; $var0 != NULL; $var0 = $var0->nextSibling) {
      if ("http://www.w3.org/2009/xmldsig11#" === $var0->namespaceURI && $var0->localName === $var1) {
        if ($var2 === 0) {
          return $var0;
        }

        --$var2;
      }
    }

    return NULL;
  }

  public static function selectXencNode(\DOMNode $var0, String $var1,
                                        int $var2) {
    for (; $var0 != NULL; $var0 = $var0->nextSibling) {
      if ("http://www.w3.org/2001/04/xmlenc#" === $var0->namespaceURI && $var0->localName === $var1) {
        if ($var2 === 0) {
          return $var0;
        }

        --$var2;
      }
    }

    return NULL;
  }

  public static function selectDsNodeText(\DOMNode $var0, String $var1,
                                          int $var2) {
    $var3 = self::selectDsNode($var0, $var1, $var2);
    if ($var3 === NULL) {
      return NULL;
    }
    else {
      $var4 = NULL;
      for ($var4 = $var3->firstChild; $var4 !== NULL && $var4->nodeType !== XML_TEXT_NODE; $var4 = $var4->nextSibling) {
        ;
      }
      return $var4;
    }
  }

  public static function selectDs11NodeText(\DOMNode $var0, String $var1,
                                            int $var2) {
    $var3 = self::selectDs11Node($var0, $var1, $var2);
    if ($var3 === NULL) {
      return NULL;
    }
    else {
      $var4 = NULL;
      for ($var4 = $var3->firstChild; $var4 !== NULL && $var4->nodeType !== XML_TEXT_NODE; $var4 = $var4->nextSibling) {
        ;
      }

      return $var4;
    }
  }

  public static function selectNodeText(\DOMNode $var0, String $var1,
                                        String $var2, int $var3) {
    $var4 = self::selectNode($var0, $var1, $var2, $var3);
    if ($var4 === NULL) {
      return NULL;
    }
    else {
      $var5 = NULL;
      for ($var5 = $var4->firstChild; $var5 !== NULL && $var5->nodeType !== XML_TEXT_NODE; $var5 = $var5->nextSibling) {
        ;
      }

      return $var5;
    }
  }

  public static function selectNode(\DOMNode $var0, String $var1, String $var2,
                                    int $var3) {

    for (; $var0 !== NULL; $var0 = $var0->nextSibling) {

      if ($var0->namespaceURI !== NULL && $var0->namespaceURI === $var1 && $var0->localName === $var2) {

        if ($var3 === 0) {

          return $var0;
        }

        --$var3;
      }
    }

    return NULL;
  }

  public
  static function selectDsNodes(\DOMNode $var0, String $var1) {
    return self::selectNodes($var0, "http://www.w3.org/2000/09/xmldsig#",
                             $var1);
  }

  public static function selectDs11Nodes(\DOMNode $var0, String $var1) {
    return self::selectNodes($var0, "http://www.w3.org/2009/xmldsig11#", $var1);
  }

  public static function selectNodes(\DOMNode $var0, String $var1,
                                     String $var2) {
    $var3 = NULL;
    for ($var3 = []; $var0 !== NULL; $var0 = $var0->nextSibling) {
      if ($var0->namespaceURI !== NULL && $var0->namespaceURI === $var1 && $var0->localName === $var2) {
        $var3[] = $var0;
      }
    }

    return $var3;
  }

  public static function excludeNodeFromSet(\DOMNode $var0, array $var1) {
    $var2 = [];
    //Iterator $var3 = $var1->iterator();
    foreach ($var1 as $var4) {
      //Node $var4 = (Node)$var3->next();
      if (!self::isDescendantOrSelf($var0, $var4)) {
        $var2[] = $var4;
      }
    }

    return $var2;
  }

  public static function getStrFromNode(\DOMNode $var0) {
    if ($var0->nodeType === XML_TEXT_NODE) {
      $var1 = [];

      for ($var2 = $var0->parentNode->firstChild; $var2 !== NULL; $var2 = $var2->nextSibling) {
        if ($var2->nodeType === XML_TEXT_NODE) {
          /** @var \DOMText $var2 */
          $var1[] = $var2->data;
        }
      }

      return implode('', $var1);
    }
    else {
      if ($var0->nodeType === XML_ATTRIBUTE_NODE) {
        /** @var \DOMAttr $var0 */
        return $var0->nodeValue;
      }
      else {
        /** @var \DOMProcessingInstruction $var0 */
        return $var0->nodeType === XML_PI_NODE ? $var0->nodeValue : NULL;
      }
    }
  }

  public static function isDescendantOrSelf(\DOMNode $var0, \DOMNode $var1) {
    if ($var0 === $var1) {
      return TRUE;
    }
    else {
      $var2 = $var1;

      while ($var2 !== NULL) {
        if ($var2 === $var0) {
          return TRUE;
        }

        if ($var2->nodeType === XML_ATTRIBUTE_NODE) {
          /** @var \DOMAttr $var2 */
          $var2 = $var2->ownerElement;
        }
        else {
          $var2 = $var2->parentNode;
        }
      }

      return FALSE;
    }
  }

  public static function ignoreLineBreaks() {
    return self::$ignoreLineBreaks;
  }

  public static function getAttributeValue(\DOMElement $var0, String $var1) {
    $var2 = $var0->getAttributeNodeNS((String) NULL, $var1);
    return $var2 === NULL ? NULL : $var2->value;
  }

  /**
   * @param \DOMNode           $var0
   * @param String|\DOMElement $element
   * @param String|NULL        $var1
   *
   * @return bool
   */
  public static function protectAgainstWrappingAttack(\DOMNode $var0,
                                                      $element,
                                                      String $var1 = NULL) {
    if (!isset($var1) && is_string($element)) {
      $var1 = $element;
    }

    $var2 = $var0->parentNode;
    $var3 = NULL;
    $var4 = NULL;
    $var5 = trim($var1);
    if (!empty($var5) && substr($var5, 0, 1) === '#') {
      $var5 = substr($var5, 1);
    }

    while ($var0 !== NULL) {
      if ($var0->nodeType === XML_ELEMENT_NODE) {
        $var6 = $var0;
        $var7 = $var6->attributes;
        if ($var7 !== NULL) {
          for ($var8 = 0; $var8 < $var7->length; ++$var8) {
            /** @var \DOMAttr $var9 */
            $var9 = $var7->item($var8);
            if ($var9->isId() && $var5 === $var9->value && ($var6 !== $element || is_string($element))) {
              if ($var4 !== NULL) {
                //                log->log(Level->FINE,
                //                          "Multiple elements with the same 'Id' attribute value!");
                return FALSE;
              }

              $var4 = $var9->ownerElement;
            }
          }
        }
      }

      $var3 = $var0;
      $var0 = $var0->firstChild;
      if ($var0 === NULL) {
        $var0 = $var3->nextSibling;
      }

      while ($var0 === NULL) {
        $var3 = $var3->parentNode;
        if ($var3 === $var2) {
          return TRUE;
        }

        $var0 = $var3->nextSibling;
      }
    }

    return TRUE;
  }
}
