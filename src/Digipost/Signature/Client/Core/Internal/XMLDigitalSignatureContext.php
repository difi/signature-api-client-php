<?php

namespace Digipost\Signature\Client\Core\Internal;

use Digipost\Signature\API\XML\CustomBase64BinaryType;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\Reference;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureValue;
use Digipost\Signature\Client\ASiCe\ASiCEAttachable;
use Digipost\Signature\Client\Core\Internal\Security\PrivateKey;
use Digipost\Signature\Client\Core\Internal\XML\Marshalling;
use Psr\Container\ContainerInterface;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;
use SimpleSAML\XMLSec\Constants as C;
use SimpleSAML\XMLSec\Utils\XPath;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use function GuzzleHttp\Psr7\stream_for;

/**
 * @property \DOMDocument $doc
 */
class XMLDigitalSignatureContext extends XMLSecurityDSig {

  use ContainerAwareTrait;

  /** @var \DOMElement|null */
  public $sigNode = NULL;

  /** @var array */
  public $idKeys = [];

  /** @var array */
  public $idNS = [];

  /** @var string|null */
  private $signedInfo = NULL;

  /** @var \DomXPath|null */
  private $xPathCtx = NULL;

  /** @var string|null */
  private $canonicalMethod = NULL;

  /** @var string */
  private $prefix = '';

  /** @var string */
  private $searchpfx = 'secdsig';

  /**
   * This variable contains an associative array of validated nodes.
   *
   * @var array|null
   */
  private $validatedNodes = NULL;

  /** @var \DOMDocument */
  private $_document;
  private $_xmlService;

  /** @var PrivateKey */
  private $_privateKey;

  /** @var ASiCEAttachable[] */
  private $_referencedFiles;

  //  public function __construct(string $prefix = 'ds') {
  //    parent::__construct($prefix);
  //
  //    $doc = new \DOMDocument();
  //    $this->sigNode = $doc->documentElement;
  //  }

  function configure(PrivateKey $privateKey, \DOMDocument $document) {
    $document->substituteEntities = FALSE;
    $document->strictErrorChecking = FALSE;
    libxml_use_internal_errors(TRUE);

    $this->_privateKey = $privateKey;
    $this->_document = $document;

    //$this->_privateKey->getFormat()
    //$this->setNodeNsPrefix('');
    return $this;
  }

  public function getDocument() {
    return $this->_document;
  }

  public static function factory(ContainerInterface $container, Xml\Service $xmlService) {
    $self = new self();
    $self->setContainer($container);
    $self->setXmlService($xmlService);

    return $self;
  }

  public function setXmlService(Xml\Service $xmlService) {
    $this->_xmlService = $xmlService;
  }

  private function resetXPathObj() {
    $this->xPathCtx = NULL;
  }

  /**
   * @return \DOMXPath|null
   */
  private function getXPathObj() {
    if (empty($this->xPathCtx) && isset($this->sigNode)) {
      $xpath = new \DOMXPath($this->sigNode->ownerDocument);
      $xpath->registerNamespace('secdsig', C::XMLDSIGNS);
      $this->xPathCtx = $xpath;
    }

    return $this->xPathCtx;
  }

  /**
   * @param null|XMLSecurityKey $objKey
   * @param null|\DOMNode       $appendToNode
   */
  public function sign($objKey = NULL, $appendToNode = NULL) {
    // If we have a parent node append it now so C14N properly works
    if ($appendToNode != NULL) {
      $this->resetXPathObj();
      //$this->appendSignature($appendToNode);
      $this->sigNode = $appendToNode->lastChild;
    }
    if ($xpath = $this->getXPathObj()) {
      $query = "./secdsig:SignedInfo";
      $nodeSet = $xpath->query($query, $this->sigNode);

      if ($sInfo = $nodeSet->item(0)) {
        $query = "./secdsig:SignatureMethod";
        $nodeSet = $xpath->query($query, $sInfo);
        $sMethod = $nodeSet->item(0);
        $sMethod->setAttribute('Algorithm', $objKey->type);
        $data = $this->canonicalizeData($sInfo, $this->canonicalMethod);
        $sigValue = base64_encode($objKey->signData($data));
        $signatureValue = new SignatureValue(new CustomBase64BinaryType($sigValue));
        $sigValueNode = $this->createNewSignNode('SignatureValue');
        $sigValueNode->appendChild($this->sigNode->ownerDocument->createTextNode($signatureValue));
        if ($infoSibling = $sInfo->nextSibling) {
          $infoSibling->parentNode->insertBefore($sigValueNode, $infoSibling);
        }
        else {
          $this->sigNode->appendChild($sigValueNode);
        }
      }
    }
  }

  /**
   * @param \DOMNode $node
   *
   * @return \DOMNode
   * @throws \Exception
   */
  public function createXMLSignatureElement(\DOMNode $node): \DOMNode {
    //    $object = $doc->createDocumentFragment();
    //    $object->appendChild($doc->createElementNS('http://uri.etsi.org/01903/v1.3.2#', 'ds:Object'));
    //$signature = $this->_document->createElementNS(self::XML_DSIG_NS, $this->nodeNsPrefix . 'Signature');
    //return $this->_document->documentElement->appendChild($signature);
    $doc = $this->_document;
    $signature = $doc->createDocumentFragment();
    $signature->appendChild($doc->importNode($node, TRUE));
    $sigElem = $doc->documentElement->appendChild($signature);

    $doc->documentElement->parentNode->replaceChild($sigElem, $doc->documentElement);
    //
    //    print "\n----------------------------------------------------------\n";
    //    print $this->_document->saveXML($sigElem);
    //    print "\n----------------------------------------------------------\n";

    $this->sigNode = $sigElem;

    $this->digestReferences();

    //$this->signedInfo
    //$data = $this->canonicalizeSignedInfo();

    //print $data;

    return $sigElem;
  }

  /**
   * @param \DOMElement $refNode
   *
   * @return bool
   * @throws \Exception
   */
  public function processRefNode($refNode) {
    $dataObject = NULL;

    /*
     * Depending on the URI, we may not want to include comments in the result
     * See: http://www.w3.org/TR/xmldsig-core/#sec-ReferenceProcessingModel
     */
    $includeCommentNodes = TRUE;

    if ($uri = $refNode->getAttribute("URI")) {
      $arUrl = parse_url($uri);
      if (empty($arUrl['path'])) {
        if ($identifier = $arUrl['fragment']) {
          /* This reference identifies a node with the given id by using
           * a URI on the form "#identifier". This should not include comments.
           */
          $includeCommentNodes = FALSE;

          $xPath = new \DOMXPath($refNode->ownerDocument);
          if ($this->idNS && is_array($this->idNS)) {
            foreach ($this->idNS AS $nspf => $ns) {
              $xPath->registerNamespace($nspf, $ns);
            }
          }
          $iDlist = '@Id="' . XPath::filterAttrValue($identifier, XPath::DOUBLE_QUOTE) . '"';

          if (is_array($this->idKeys)) {
            foreach ($this->idKeys AS $idKey) {
              $iDlist .= " or @" . XPath::filterAttrName($idKey) . '="' .
                XPATH::filterAttrValue($identifier, XPAth::DOUBLE_QUOTE) . '"';
            }
          }
          $query = '//*[' . $iDlist . ']';
          $dataObject = $xPath->query($query)->item(0);
        }
        else {
          $dataObject = $refNode->ownerDocument;
        }
      }
      else {
        $dataObject = $this->readReferencedFileData($arUrl['path']);
      }
    }
    else {
      /* This reference identifies the root node with an empty URI. This should
       * not include comments.
       */
      $includeCommentNodes = FALSE;

      $dataObject = $refNode->ownerDocument;
    }
    $data = $this->processTransforms($refNode, $dataObject, $includeCommentNodes);

    if (!$this->validateDigest($refNode, $data)) {
      return FALSE;
    }

    if ($dataObject instanceof \DOMNode) {
      /* Add this node to the list of validated nodes. */
      if (!empty($identifier)) {
        $this->validatedNodes[$identifier] = $dataObject;
      }
      else {
        $this->validatedNodes[] = $dataObject;
      }
    }

    return TRUE;
  }

  /**
   * @param \DOMElement $refNode
   *
   * @return string|null
   */
  public function getRefNodeID($refNode) {
    if ($uri = $refNode->getAttribute("URI")) {
      $arUrl = parse_url($uri);
      if (empty($arUrl['path'])) {
        if ($identifier = $arUrl['fragment']) {
          return $identifier;
        }
      }
    }

    return NULL;
  }

  /**
   * @return array
   * @throws \Exception
   */
  public function getRefIDs() {
    $refIds = [];

    $xpath = $this->getXPathObj();
    $query = "./secdsig:SignedInfo/secdsig:Reference";
    $nodeSet = $xpath->query($query, $this->sigNode);
    if ($nodeSet->length == 0) {
      throw new \Exception("Reference nodes not found");
    }
    foreach ($nodeSet as $refNode) {
      $refIds[] = $this->getRefNodeID($refNode);
    }

    return $refIds;
  }

  public static function LOG($str) {
  }

  /**
   * @throws \Exception
   */
  public function digestReferences() {
    $includeCommentNodes = FALSE;
    $xpath = $this->getXPathObj();
    $query = "./secdsig:SignedInfo/secdsig:Reference";
    /** @var \DOMNodeList $nodeSet */
    $nodeSet = $xpath->query($query, $this->sigNode);
    if ($nodeSet->length == 0) {
      throw new \Exception("Reference nodes not found");
    }
    foreach ($nodeSet as $refNode) {
      /** @var \DOMElement $refNode */
      //      dump($refNode->localName);
      $dataObject = NULL;
      if ($uri = $refNode->getAttribute("URI")) {
        $arUrl = parse_url($uri);
        //        dump("Got URI attribute", $arUrl);
        if (empty($arUrl['path'])) {
          if ($identifier = $arUrl['fragment']) {
            $includeCommentNodes = FALSE;
            $xPath = new \DOMXPath($refNode->ownerDocument);
            if ($this->idNS && is_array($this->idNS)) {
              foreach ($this->idNS as $nspf => $ns) {
                $xPath->registerNamespace($nspf, $ns);
              }
            }
            $iDlist = '@Id="' . XPath::filterAttrValue($identifier, XPath::DOUBLE_QUOTE) . '"';
            //            dump($iDlist);
            if (is_array($this->idKeys)) {
              foreach ($this->idKeys as $idKey) {
                $iDlist .= " or @" . XPath::filterAttrName($idKey) . '="' .
                  XPATH::filterAttrValue($identifier, XPAth::DOUBLE_QUOTE) . '"';
              }
            }
            $query = '//*[' . $iDlist . ']';
            $dataObject = $xPath->query($query)->item(0);
            //            dump('Trying to find "' . $query . '"');
          }
          else {
            $dataObject = $refNode->ownerDocument;
            //            dump('dataObject is ' . $refNode->ownerDocument);
          }
        }
        else {
          $dataObject = $this->readReferencedFileData($arUrl['path']);
          //          dump('Read referenced file by path');
        }
      }
      $digestValue = $refNode->getElementsByTagName('DigestValue')->item(0);
      $digestMethod = $refNode->getElementsByTagName('DigestMethod')->item(0);
      $algorithm = $digestMethod->getAttribute('Algorithm');

      $canonicalData = $this->processTransforms($refNode, $dataObject, $includeCommentNodes);
      $canonicalData = strtr(
        $canonicalData, [
          //          'xsd:'                                            => '',
          //          ' xmlns="http://www.w3.org/2000/09/xmldsig#"'     => '',
          //          ' xmlns:ns2="http://www.w3.org/2000/09/xmldsig#"' => '',
          //          ' xmlns:xsd="http://uri.etsi.org/01903/v1.3.2#"'  => '',
          //          '<Digest'                                         => '<ns2:Digest',
          //          '</Digest'                                        => '</ns2:Digest',
          //          '<X509'                                           => '<ns2:X509',
          //          '</X509'                                          => '</ns2:X509',
        ]
      );
      //      dump("CANONICALDATA:");
      //      dump($canonicalData);
      //      dump("DIGEST VALUE");

      $digValue = $this->calculateDigest($algorithm, $canonicalData);
      //$this->addReference($refNode, $digestMethod, $transforms);
      //$digestMethod = $this->createNewSignNode('DigestMethod');
      //$refNode->appendChild($digestMethod);
      $digestMethod->setAttribute('Algorithm', $algorithm);

      $digestValueNew = $this->createNewSignNode('DigestValue');
      $digestValueNew->appendChild($digestValueNew->ownerDocument->createTextNode($digValue));
      //$refNode->appendChild($digestValue);
      if (!$digestValue) {
        $digestMethod->parentNode->appendChild($digestValueNew);
      }
      else {
        $digestMethod->parentNode->replaceChild($digestValueNew, $digestValue);
      }
    }
  }

  /**
   * @return bool
   * @throws \Exception
   */
  public function validateReference() {
    /** @var \DOMElement $docElem */
    $docElem = $this->sigNode->ownerDocument->documentElement;
    if (!$docElem->isSameNode($this->sigNode)) {
      if ($this->sigNode->parentNode != NULL) {
        $this->sigNode->parentNode->removeChild($this->sigNode);
      }
    }
    $xpath = $this->getXPathObj();
    $query = "./secdsig:SignedInfo/secdsig:Reference";
    $nodeSet = $xpath->query($query, $this->sigNode);
    if ($nodeSet->length == 0) {
      throw new \Exception("Reference nodes not found");
    }

    /* Initialize/reset the list of validated nodes. */
    $this->validatedNodes = [];

    foreach ($nodeSet as $refNode) {
      if (!$this->processRefNode($refNode)) {
        /* Clear the list of validated nodes. */
        $this->validatedNodes = NULL;
        throw new \Exception("Reference validation failed");
      }
    }

    return TRUE;
  }

  /**
   * @param \DOMElement $refNode
   * @param string      $data
   *
   * @return bool
   * @throws \Exception
   */
  public function validateDigest($refNode, $data) {
    $xpath = new \DOMXPath($refNode->ownerDocument);
    $xpath->registerNamespace('secdsig', C::XMLDSIGNS);
    $query = 'string(./secdsig:DigestMethod/@Algorithm)';
    $digestAlgorithm = $xpath->evaluate($query, $refNode);
    $digValue = $this->calculateDigest($digestAlgorithm, $data, FALSE);
    $query = 'string(./secdsig:DigestValue)';
    $digestValue = $xpath->evaluate($query, $refNode);

    return ($digValue === base64_decode($digestValue));
  }

  public function processTransforms($refNode, $objData, $includeCommentNodes = TRUE) {
    $data = $objData;
    $xpath = new \DOMXPath($refNode->ownerDocument);
    $xpath->registerNamespace('secdsig', 'http://www.w3.org/2000/09/xmldsig#');
    $query = './secdsig:Transforms/secdsig:Transform';
    $nodeList = $xpath->query($query, $refNode);
    /** @var \DOMNodeList $nodeList */
    $canonicalMethod = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315';
    $arXPath = NULL;
    $prefixList = NULL;
    foreach ($nodeList as $transform) {
      /** @var \DOMElement $transform */
      $algorithm = $transform->getAttribute("Algorithm");
      switch ($algorithm) {
        case 'http://www.w3.org/2001/10/xml-exc-c14n#':
        case 'http://www.w3.org/2001/10/xml-exc-c14n#WithComments':

          if (!$includeCommentNodes) {
            /* We remove comment nodes by forcing it to use a canonicalization
             * without comments.
             */
            $canonicalMethod = 'http://www.w3.org/2001/10/xml-exc-c14n#';
          }
          else {
            $canonicalMethod = $algorithm;
          }

          $node = $transform->firstChild;
          while ($node) {
            if ($node->localName == 'InclusiveNamespaces') {
              if ($pfx = $node->getAttribute('PrefixList')) {
                $arpfx = [];
                $pfxlist = explode(" ", $pfx);
                foreach ($pfxlist as $pfx) {
                  $val = trim($pfx);
                  if (!empty($val)) {
                    $arpfx[] = $val;
                  }
                }
                if (count($arpfx) > 0) {
                  $prefixList = $arpfx;
                }
              }
              break;
            }
            $node = $node->nextSibling;
          }
          break;
        case 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315':
        case 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315#WithComments':
          if (!$includeCommentNodes) {
            /* We remove comment nodes by forcing it to use a canonicalization
             * without comments.
             */
            $canonicalMethod = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315';
          }
          else {
            $canonicalMethod = $algorithm;
          }

          break;
        case 'http://www.w3.org/TR/1999/REC-xpath-19991116':
          $node = $transform->firstChild;
          while ($node) {
            if ($node->localName == 'XPath') {
              $arXPath = [];
              $arXPath['query'] = '(.//. | .//@* | .//namespace::*)[' . $node->nodeValue . ']';
              $arXpath['namespaces'] = [];
              $nslist = $xpath->query('./namespace::*', $node);
              foreach ($nslist AS $nsnode) {
                if ($nsnode->localName != "xml") {
                  $arXPath['namespaces'][$nsnode->localName] = $nsnode->nodeValue;
                }
              }
              break;
            }
            $node = $node->nextSibling;
          }
          break;
      }
    }
    if ($data instanceof \DOMNode) {
      $data = $this->canonicalizeData($objData, $canonicalMethod, $arXPath, $prefixList);
    }

    return $data;
  }

  public function createNewSignNode($name, $value = NULL) {
    /** @var \DOMDocument $doc */
    $doc = $this->sigNode->ownerDocument;
    if (!is_null($value)) {
      $node = $doc->createElementNS(C::XMLDSIGNS, $this->prefix . $name, $value);
    }
    else {
      $node = $doc->createElementNS(C::XMLDSIGNS, $this->prefix . $name);
    }

    return $node;
  }

  /**
   * @param string $method
   *
   * @throws \Exception
   */
  public function setCanonicalMethod($method) {
    switch ($method) {
      case 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315':
      case 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315#WithComments':
      case 'http://www.w3.org/2001/10/xml-exc-c14n#':
      case 'http://www.w3.org/2001/10/xml-exc-c14n#WithComments':
        $this->canonicalMethod = $method;
        break;
      default:
        throw new \Exception('Invalid Canonical Method');
    }
    if ($xpath = $this->getXPathObj()) {
      $query = './' . $this->searchpfx . ':SignedInfo';
      $nodeSet = $xpath->query($query, $this->sigNode);
      if ($sinfo = $nodeSet->item(0)) {
        $query = './' . $this->searchpfx . 'CanonicalizationMethod';
        $nodeSet = $xpath->query($query, $sinfo);
        if (!($canonNode = $nodeSet->item(0))) {
          $canonNode = $this->createNewSignNode('CanonicalizationMethod');
          $sinfo->insertBefore($canonNode, $sinfo->firstChild);
        }
        $canonNode->setAttribute('Algorithm', $this->canonicalMethod);
      }
    }
  }

  private function canonicalizeData($node, $canonicalMethod, $arXPath = NULL, $prefixList = NULL) {

    $exclusive = FALSE;
    $withComments = FALSE;
    switch ($canonicalMethod) {
      case 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315':
        $exclusive = FALSE;
        $withComments = FALSE;
        break;
      case 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315#WithComments':
        $withComments = TRUE;
        break;
      case 'http://www.w3.org/2001/10/xml-exc-c14n#':
        $exclusive = TRUE;
        break;
      case 'http://www.w3.org/2001/10/xml-exc-c14n#WithComments':
        $exclusive = TRUE;
        $withComments = TRUE;
        break;
    }

    if (is_null(
        $arXPath
      )
      && ($node instanceof \DOMNode)
      && ($node->ownerDocument !== NULL)
      && $node->isSameNode($node->ownerDocument->documentElement)) {
      /* Check for any PI or comments as they would have been excluded */
      $element = $node;
      while ($refnode = $element->previousSibling) {
        if ($refnode->nodeType == XML_PI_NODE ||
          (($refnode->nodeType == XML_COMMENT_NODE) && $withComments)) {
          break;
        }
        $element = $refnode;
      }
      if ($refnode == NULL) {
        $node = $node->ownerDocument;
      }
    }

    return $node->C14N($exclusive, $withComments, $arXPath, $prefixList);
  }

  public function calculateDigest($digestAlgorithm, $data, $encode = TRUE) {
    switch ($digestAlgorithm) {
      case C::DIGEST_SHA1:
        $alg = 'sha1';
        break;
      case C::DIGEST_SHA256:
        $alg = 'sha256';
        break;
      case C::DIGEST_SHA384:
        $alg = 'sha384';
        break;
      case C::DIGEST_SHA512:
        $alg = 'sha512';
        break;
      case C::DIGEST_RIPEMD160:
        $alg = 'ripemd160';
        break;
      default:
        throw new \Exception("Cannot validate digest: Unsupported Algorithm <$digestAlgorithm>");
    }

    $digest = hash($alg, $data, TRUE);
    if ($encode) {
      $digest = base64_encode($digest);
    }

    return $digest;
  }

  /**
   * @param Reference[] $references
   */
  public function addReferenceObjects(Reference ...$references) {
    foreach ($references as $reference) {
      $node = Marshalling::toDOMElement($reference);
      $this->addReference(
        $node->ownerDocument, C::DIGEST_SHA256, [], [
      ]);
    }
  }

  /**
   * @param Reference $reference
   */
  public function addReferenceObject(Reference $reference) {
  }

  private function readReferencedFileData($path) {
    foreach ($this->_referencedFiles as $file) {
      if ($file->getFileName() === $path) {
        return stream_for($file->getBytes());
      }
    }

    return NULL;
  }

  public function addReferencedFiles($attachedFiles) {
    $this->_referencedFiles =& $attachedFiles;
  }
}

