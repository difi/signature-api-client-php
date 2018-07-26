<?php

namespace Digipost\Signature\Client\Core\Internal\XML;

class DOMUtils
{
  public static function getNamespaces($dom, $recursive = false)
  {
    $sxe = simplexml_import_dom($dom);

    return $sxe->getNamespaces($recursive);
  }

  public static function getDocNamespaces($dom, $recursive = false, $from_root = true)
  {
    $sxe = simplexml_import_dom($dom);

    return $sxe->getDocNamespaces($recursive, $from_root);
  }

  public static function removeDOMNamespace(\DOMDocument $doc, String $ns)
  {
    $finder = new \DOMXPath($doc);
    $nodes = $finder->query("//*[namespace::{$ns} and not(../namespace::{$ns})]");
    foreach ($nodes as $n) {
      /** @var \DOMElement $n */
      $ns_uri = $n->lookupNamespaceURI($ns);
      print "$ns ($ns_uri)\n";
      $n->removeAttributeNS($ns_uri, $ns);
    }
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
   * @param String $name
   * @return \DOMNode
   */
  public static function renameDOMElement(\DOMElement $node, String $name)
  {
    $renamed = $node->ownerDocument->createElement($name);

    foreach ($node->attributes as $attribute) {
      $renamed->setAttribute($attribute->nodeName, $attribute->nodeValue);
    }

    while ($node->firstChild) {
      $renamed->appendChild($node->firstChild);
    }

    return $node->parentNode->replaceChild($renamed, $node);
  }
}