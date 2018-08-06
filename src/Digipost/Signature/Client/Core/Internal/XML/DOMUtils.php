<?php

namespace Digipost\Signature\Client\Core\Internal\XML;

class DOMUtils {

  public static function getNamespaces($dom, $recursive = FALSE) {
    $sxe = simplexml_import_dom($dom);

    return $sxe->getNamespaces($recursive);
  }

  public static function getDocNamespaces($dom, $recursive = FALSE, $from_root = TRUE) {
    $sxe = simplexml_import_dom($dom);

    return $sxe->getDocNamespaces($recursive, $from_root);
  }

  public static function removeDOMNamespace(\DOMDocument $doc, String $ns) {
    $finder = new \DOMXPath($doc);
    $nodes = $finder->query("//*[namespace::{$ns} and not(../namespace::{$ns})]");
    $ret = [];
    foreach ($nodes as $n) {
      /** @var \DOMElement $n */
      $ns_uri = $n->lookupNamespaceURI($ns);
      $ret[$ns] = $ns_uri;
      $ret[$n->prefix] = $ns;
      $n->removeAttributeNS($ns_uri, $ns);
    }

    return $ret;
  }

  public static function removeWhiteSpace(\DOMDocument $doc) {
    $xpath = new \DOMXPath($doc);
    foreach ($xpath->query('//text()') as $text) {
      $text->data = trim($text->data);
    }
  }

  /**
   * Renames a node in a DOM Document.
   *
   * @param \DOMElement $node
   * @param String      $name
   *
   * @return \DOMNode
   */
  public static function renameDOMElement(\DOMElement $node, String $name, $copyAttributes = NULL) {
    $renamed = $node->ownerDocument->createElement($name);

    foreach ($node->attributes as $attribute) {
      if (!isset($copyAttributes)) {
        continue;
      }
      $renamed->setAttribute($attribute->nodeName, $attribute->nodeValue);
    }

    while ($node->firstChild) {
      $renamed->appendChild($node->firstChild);
    }

    if (($old = $node->parentNode->replaceChild($renamed, $node)) !== FALSE) {
      return $renamed;
    }
    return $old;
  }

  public static function replaceDOMElement(\DOMElement $node, \DOMElement $newNode, $copyAttributes = NULL) {

  }

  /**
   * @param \DOMElement $node
   * @param String      $name
   *
   * @param string      $namespaceURI
   * @param null        $attributes
   *
   * @return \DOMNode
   */
  public static function renameDOMElementNS(
    \DOMElement $node, String $name, $namespaceURI = '', $attributes = NULL
  ) {
    $renamed = $node->ownerDocument->createElementNS($namespaceURI, $name);

    foreach ($node->attributes as $attribute) {
      /** @var \DOMAttr $attribute */
      if ($attributes === NULL) {
        break;
      }
      if ($attributes === TRUE
        || (is_array($attributes)
          && in_array(
            $attribute->localName, $attributes
          ))) {
        $renamed->setAttribute($attribute->nodeName, $attribute->nodeValue);
      }
    }

    while ($node->firstChild) {
      $renamed->appendChild($node->firstChild);
    }

    return $node->parentNode->replaceChild($renamed, $node);
  }

  public static function getNamespacePrefix(
    \DOMDocument $dom, String $needle, String $default = NULL
  ) {
    $namespaces = self::getDocNamespaces($dom, FALSE);
    foreach ($namespaces as $prefix => $namespace) {
      if ($namespace === $needle) {
        return $prefix;
      }
    }

    return $dom->lookupPrefix($needle);
  }
  public static function getDefaultNamespacePrefix(\DOMDocument $dom) {
    $namespaces = self::getDocNamespaces($dom, TRUE);
    foreach ($namespaces as $prefix => $namespace) {
      if ($dom->isDefaultNamespace($namespace)) {
        return $prefix;
      }
    }

    return NULL;
  }

  public static function getNSPrefix(\DOMDocument $doc, string $namespace) {
    return $doc !== NULL ?
      self::getNamespacePrefix(
        $doc, $namespace, self::getDefaultNamespacePrefix($doc)
      ) : NULL;
  }
}