<?php
namespace Digipost\Signature\Client\Core\Internal\Security;

use Digipost\Signature\Client\Core\Internal\Security\Constants as C;
use Digipost\Signature\Client\Core\Internal\XML\XPath as XP;
use SimpleSAML\XMLSec\Key\X509Certificate as XMLSecLibX509Certificate;
use SimpleSAML\XMLSec\Signature as XMLSecLibSignature;
use SimpleSAML\XMLSec\Utils\DOMDocumentFactory;
use SimpleSAML\XMLSec\Utils\Random;

class Signature extends XMLSecLibSignature {

  /** @var \DOMElement */
  private $qualifyingPropertiesNode;

  /** @var \DOMElement */
  private $signedPropertiesNode;

  /** @var \DOMElement */
  private $signedDataObjectPropertiesNode;

  /** @var \DOMElement */
  private $signedSignaturePropertiesNode;

  /** @var \DOMElement */
  private $signingCertNode;

  /** @var \DOMElement */
  private $signingTimeNode;

  public function addQualifyingPropertiesObject() {
    if ($this->objectNode === NULL) {
      $this->objectNode = $this->createElement('Object');
      $this->sigNode->appendChild($this->objectNode);
    }

    if (!$this->qualifyingPropertiesNode) {
      $this->qualifyingPropertiesNode =
        $this->createElement('QualifyingProperties', '', C::XADESNS, 'xades:');
      $this->objectNode->appendChild($this->qualifyingPropertiesNode);
      $this->qualifyingPropertiesNode->setAttribute('Target', '#Signature');
    }

    if (!$this->signedPropertiesNode) {
      $this->signedPropertiesNode =
        $this->createElement('SignedProperties', '', C::XADESNS, 'xades:');
      $this->signedPropertiesNode->setAttributeNS(C::XADESNS, 'Id', 'SignedProperties');
      $this->signedPropertiesNode->setIdAttributeNS(C::XADESNS, 'Id', TRUE);
      $this->qualifyingPropertiesNode->appendChild($this->signedPropertiesNode);
    }
    if (!$this->signedSignaturePropertiesNode) {
      $this->signedSignaturePropertiesNode =
        $this->createElement('SignedSignatureProperties', '', C::XADESNS, 'xades:');
      $this->signedPropertiesNode->appendChild($this->signedSignaturePropertiesNode);
    }

    if (!$this->signedDataObjectPropertiesNode) {
      $this->signedDataObjectPropertiesNode =
        $this->createElement('SignedDataObjectProperties', '', C::XADESNS, 'xades:');
      $this->signedPropertiesNode->appendChild($this->signedDataObjectPropertiesNode);
    }

    if (!$this->signingCertNode) {
      $this->signingCertNode = $this->createElement('SigningCertificate', '', C::XADESNS, 'xades:');
      $this->signedSignaturePropertiesNode->appendChild($this->signingCertNode);
    }

    return $this->qualifyingPropertiesNode;
  }

  public function getSignedPropertiesNode() {
    return $this->signedPropertiesNode;
  }

  public function addSignedDataObjectFormat($id, $fileName = NULL, $mimeType = NULL, $data = NULL) {
    if (!$this->signedDataObjectPropertiesNode) {
      $this->addQualifyingPropertiesObject();
    }

    $objectNode = $this->createElement('DataObjectFormat', '', C::XADESNS, 'xades:');
    if (isset($mimeType)) {
      $mimeTypeNode = $this->createElement('MimeType', $mimeType, C::XADESNS, 'xades:');
      $objectNode->appendChild($mimeTypeNode);
    }
    $objectNode->setAttribute('ObjectReference', '#' . $id);

    $this->signedDataObjectPropertiesNode->appendChild($objectNode);

    $this->addReference(
      $objectNode, C::DIGEST_SHA256, [], [
      'overwrite' => FALSE,
      'id_name'   => 'ObjectReference',
      'data'      => $data,
      'filename'  => $fileName,
      'inverse'   => TRUE,
    ]);
  }

  /**
   * @inheritdoc
   */
  public function addReference(\DOMNode $node, $alg, array $transforms = [], array $options = []) {
    if (!in_array(get_class($node), ['DOMDocument', 'DOMElement'])) {
      throw new \InvalidArgumentException(
        'Only references to the DOM document or elements are allowed.');
    }

    $prefix = @$options['prefix'] ?: NULL;
    $prefixNS = @$options['prefix_ns'] ?: NULL;
    $idName = @$options['id_name'] ?: 'Id';
    $inverse = @$options['inverse'] ?: FALSE;
    $fileName = @$options['filename'] ?: NULL;
    $data = @$options['data'] ?: NULL;
    $localIdName = $inverse ? 'Id' : FALSE;

    $attrName = $prefix ? $prefix . ':' . $idName : $idName;
    $forceURI = TRUE;
    if (isset($options['force_uri'])) {
      $forceURI = $options['force_uri'];
    }
    $overwrite = TRUE;
    if (isset($options['overwrite'])) {
      $overwrite = $options['overwrite'];
    }

    $reference = $this->createElement('Reference');
    $this->sigInfoNode->appendChild($reference);

    if (isset($options['type'])) {
      $reference->setAttribute('Type', $options['type']);
    }

    // register reference
    $includeCommentNodes = FALSE;
    if ($node instanceof \DOMElement) {
      $uri = NULL;
      /** @var \DOMElement $node */
      if (!$overwrite) {
        $uri = $prefixNS ? $node->getAttributeNS($prefixNS, $idName) : $node->getAttribute($idName);
        if ($inverse && !empty($uri) && $uri[0] === '#') {
          $uri = substr($uri, 1);
        }
      }
      if (empty($uri)) {
        $uri = Random::generateGUID();
        $node->setAttribute($attrName, ($inverse ? '#' : '') . $uri);
      }

      if ($inverse) {
        $reference->setAttribute('Id', $uri);
        $reference->setIdAttribute('Id', TRUE);
      }

      if (in_array(C::C14N_EXCLUSIVE_WITH_COMMENTS, $transforms) ||
        in_array(C::C14N_INCLUSIVE_WITH_COMMENTS, $transforms)
      ) {
        $includeCommentNodes = TRUE;
        $reference->setAttribute('URI', "#xpointer($attrName('$uri'))");
      }
      else {
        if ($inverse) {
          $reference->setAttribute($localIdName, $uri);
        }
        else {
          $reference->setAttribute('URI', '#' . $uri);
        }
      }
      if (isset($fileName)) {
        $reference->setAttribute('URI', $fileName);
      }
    }
    else if ($forceURI) {
      // $node is a \DOMDocument, should add a reference to the root element (enveloped signature)
      if (in_array(
        $this->c14nMethod, [C::C14N_INCLUSIVE_WITH_COMMENTS, C::C14N_EXCLUSIVE_WITH_COMMENTS])) {
        // if we want to use a C14N method that includes comments, the URI must be an xpointer
        $reference->setAttribute('URI', '#xpointer(/)');
      }
      else {
        // C14N without comments, we can set an empty URI
        $reference->setAttribute('URI', '');
      }
    }

    if (isset($data)) {
      $canonicalData = $data;
    }
    else {

      // apply and register transforms
      $transformList = $this->createElement('Transforms', '', C::XMLDSIGNS);
      $reference->appendChild($transformList);

      if (!empty($transforms)) {
        foreach ($transforms as $transform) {
          $transformNode = $this->createElement('Transform', '', C::XMLDSIGNS);
          $transformList->appendChild($transformNode);

          if (is_array($transform) && !empty($transform[C::XPATH_URI]['query'])) {
            $transformNode->setAttribute('Algorithm', C::XPATH_URI);
            $xpNode = $this->createElement('XPath', $transform[C::XPATH_URI]['query']);
            $transformNode->appendChild($xpNode);
          }
          else {
            $transformNode->setAttribute('Algorithm', $transform);
          }
        }
      }
      else {
        if (!empty($this->c14nMethod) && !$data) {
          $transformNode = $this->createElement('Transform');
          $transformList->appendChild($transformNode);
          $transformNode->setAttribute('Algorithm', $this->c14nMethod);
        }
      }

      $canonicalData = $this->processTransforms($reference, $node, $includeCommentNodes);
    }
    $digest = $this->hash($alg, $canonicalData);

    $digestMethod = $this->createElement('DigestMethod');
    $reference->appendChild($digestMethod);
    $digestMethod->setAttribute('Algorithm', $alg);

    $digestValue = $this->createElement('DigestValue', $digest);
    $reference->appendChild($digestValue);

    if (!in_array($node, $this->references)) {
      $this->references[] = $node;
    }
  }

  /**
   * @param 509Certificate|X509Certificate[] $certs
   * @param bool $addSubject
   * @param bool $digest
   * @param bool $addIssuerSerial
   */
  public function addX509Certificates($certs, $addSubject = FALSE, $digest = FALSE, $addIssuerSerial = FALSE) {
    if (!is_array($certs)) {
      $certs = [$certs];
    }

    foreach ($certs as $key => $cert) {
      if ($cert instanceof X509Certificate) {
        $certs[$key] = $cert->toXmlSecLibCertificate();
      } else if (!($cert instanceof XMLSecLibX509Certificate)) {
        throw new \InvalidArgumentException(
          'Passed certificates must be either an X509Certificate or a list of them'
        );
      }
    }

    $keyInfoNode = $this->createElement('KeyInfo');
    $certDataNode = $this->createElement('X509Data');
    $keyInfoNode->appendChild($certDataNode);

    if ($this->objectNode === NULL) {
      $this->sigNode->appendChild($keyInfoNode);
    }
    else {
      $this->sigNode->insertBefore($keyInfoNode, $this->objectNode);
    }

    foreach ($certs as $cert) {
      if (!$cert instanceof XMLSecLibX509Certificate) {
        throw new \InvalidArgumentException(
          'The $certs array can only contain X509Certificate objects'
        );
      }
      $details = $cert->getCertificateDetails();
      $certNode = $this->createElement('Cert', '', C::XADESNS, '');

      if ($this->signingCertNode) {
        $certDigestNode = $this->createElement('CertDigest', '', C::XADESNS, 'xades:');
        $issuerSerialNode = $this->createElement('IssuerSerial', '', C::XADESNS, 'xades:');
      }

      if ($addSubject && isset($details['subject'])) {
        // add subject
        $subjectNameValue = $details['issuer'];
        if (is_array($details['subject'])) {
          $parts = [];
          foreach ($details['subject'] as $key => $value) {
            if (is_array($value)) {
              foreach ($value as $valueElement) {
                array_unshift($parts, $key . '=' . $valueElement);
              }
            }
            else {
              array_unshift($parts, $key . '=' . $value);
            }
          }
          $subjectNameValue = implode(',', $parts);
        }
        $x509SubjectNode = $this->createElement('X509SubjectName', $subjectNameValue);

        if ($this->signingCertNode && isset($issuerSerialNode)) {
          $issuerSerialNode->appendChild($x509SubjectNode);
        }
        else {
          $certDataNode->appendChild($x509SubjectNode);
        }
      }

      if ($digest !== FALSE) {
        // add certificate digest
        $fingerprint = base64_encode(hex2bin($cert->getRawThumbprint($digest)));
        if ($this->signingCertNode && isset($certDigestNode)) {
          $certDigestMethodNode = $this->createElement('DigestMethod', '');
          $certDigestMethodNode->setAttribute('Algorithm', $digest);
          $certDigestValueNode = $this->createElement('DigestValue', $fingerprint);

          $certDigestNode->appendChild($certDigestMethodNode);
          $certDigestNode->appendChild($certDigestValueNode);
          $certNode->appendChild($certDigestNode);
        }
        else {
          $x509DigestNode =
            $this->createElement('X509Digest', $fingerprint, C::XMLDSIG11NS, 'dsig11');
          $x509DigestNode->setAttribute('Algorithm', $digest);
          $certDataNode->appendChild($x509DigestNode);
        }
      }

      if ($addIssuerSerial && isset($details['issuer']) && isset($details['serialNumber'])) {
        if (is_array($details['issuer'])) {
          $parts = [];
          foreach ($details['issuer'] as $key => $value) {
            array_unshift($parts, $key . '=' . $value);
          }
          $issuerName = implode(',', $parts);
        }
        else {
          $issuerName = $details['issuer'];
        }

        if ($this->signedSignaturePropertiesNode) {
          $x509IssuerNode = $this->createElement('IssuerSerial', '', C::XADESNS, '');
          $x509IssuerNameNode = $this->createElement('X509IssuerName', $issuerName);
          $x509SerialNumberNode =
            $this->createElement('X509SerialNumber', $details['serialNumber']);
          $certNode->appendChild($x509IssuerNode);
        }
        else {
          $x509IssuerNode = $this->createElement('X509IssuerSerial');
          $certDataNode->appendChild($x509IssuerNode);
          $x509IssuerNameNode = $this->createElement('X509IssuerName', $issuerName);
          $x509SerialNumberNode =
            $this->createElement('X509SerialNumber', $details['serialNumber']);
        }
        $x509IssuerNode->appendChild($x509IssuerNameNode);
        $x509IssuerNode->appendChild($x509SerialNumberNode);
      }

      $pem_lines = explode("\n", trim($cert->getCertificate()));
      array_shift($pem_lines);
      array_pop($pem_lines);
      $pem = join($pem_lines);
      $x509CertNode = $this->createElement('X509Certificate', $pem);
      $certDataNode->appendChild($x509CertNode);

      if ($this->signedSignaturePropertiesNode) {
        $this->signingCertNode->appendChild($certNode);
      }
    }

    if ($this->signedSignaturePropertiesNode) {
      $this->signedSignaturePropertiesNode->appendChild($this->signingCertNode);
    }
  }

  /** @inheritdoc */
  public static function fromXML(\DOMNode $node)
  {
    if (!in_array(get_class($node), ['DOMElement', 'DOMDocument'])) {
      throw new \InvalidArgumentException('Signatures can only be created from DOM documents or elements');
    }

    $signature = self::findSignature($node);
    if ($node instanceof \DOMDocument) {
      $node = $node->documentElement;
    }
    $dsig = new self($node);
    $dsig->setSignatureElement($signature);
    return $dsig;
  }

  /** @inheritdoc */
  public function setEncoding($encoding) {
    if (!$this->enveloping) {
      throw new \RuntimeException('Cannot set the encoding for non-enveloping signatures.');
    }
    $this->root->setAttribute('Encoding', $encoding);
  }

  /** @inheritdoc */
  public function setSignatureElement(\DOMElement $element) {
    if ($element->localName !== 'Signature' || $element->namespaceURI !== C::XMLDSIGNS) {
      throw new \RuntimeException('Node is not an XML signature');
    }
    $this->sigNode = $element;

    $xp = XP::getXPath($this->sigNode->ownerDocument);

    $signedInfoNodes = $xp->query('./ds:SignedInfo', $this->sigNode);
    if (count($signedInfoNodes) < 1) {
      throw new \RuntimeException('There is no SignedInfo element in the signature');
    }
    $this->sigInfoNode = $signedInfoNodes->item(0);

    $this->sigAlg =
      $xp->evaluate('string(./ds:SignedInfo/ds:SignatureMethod/@Algorithm)', $this->sigNode);
    if (empty($this->sigAlg)) {
      throw new \RuntimeException('Unable to determine SignatureMethod');
    }

    $c14nMethodNodes = $xp->query('./ds:CanonicalizationMethod', $this->sigInfoNode);
    if (count($c14nMethodNodes) < 1) {
      throw new \RuntimeException('There is no CanonicalizationMethod in the signature');
    }

    $this->c14nMethodNode = $c14nMethodNodes->item(0);
    if (!$this->c14nMethodNode->hasAttribute('Algorithm')) {
      throw new \RuntimeException('CanonicalizationMethod missing required Algorithm attribute');
    }
    $this->c14nMethod = $this->c14nMethodNode->getAttribute('Algorithm');

    $objectNodes = $xp->query('./ds:Object', $this->sigNode);
    if ($objectNodes) {
      $this->objectNode = $objectNodes->item(0);
    }

    $qualifyingPropertiesNodes =
      $xp->query('./ds:Object/xades:QualifyingProperties', $this->sigNode);
    if ($qualifyingPropertiesNodes->length > 0) {
      $this->qualifyingPropertiesNode = $qualifyingPropertiesNodes->item(0);

      $signedPropertiesNodes =
        $xp->query('./xades:SignedProperties', $this->qualifyingPropertiesNode);
      if ($signedPropertiesNodes) {
        $this->signedPropertiesNode = $signedPropertiesNodes->item(0);
        $this->signedSignaturePropertiesNode =
          $xp->query('./xades:SignedSignatureProperties', $this->signedPropertiesNode)->item(0);
        $this->signingCertNode =
          $xp->query('./xades:SigningCertificate', $this->signedSignaturePropertiesNode)->item(0);

        $this->signedDataObjectPropertiesNode =
          $xp->query('./xades:SignedDataObjectPropertiesNode', $this->signedPropertiesNode)->item(
            0);
      }
    }

    if ($this->signedSignaturePropertiesNode) {
      $this->signingTimeNode =
        $xp->query('./xades:SigningTime', $this->signedSignaturePropertiesNode)->item(0);
    }

    //        if ($this->qualifyingPropertiesNode) {
    //          $target = $xp->evaluate('string(./@Target)', $this->qualifyingPropertiesNode);
    //          $targetPath = parse_url($target);
    //          $targetedNode = $xp->query('//*[@Id="' . $targetPath['fragment'] . '"]');
    //          $targetedNode = $xp->query('//*[@Id="SignedProperties"]');
    //        }
  }

  /**
   * Set the SigningTime value in xades:SignedSignatureProperties
   *
   * @param \DateTime $date
   * @param string    $format [optional] Format accepted by date().
   *
   * @return \DOMElement
   */
  public function setSigningTime(\DateTime $date, $format = \DateTime::RFC3339_EXTENDED) {
    $value = $date->format(\DateTime::RFC3339_EXTENDED);

    $newSigningTimeNode = $this->createElement('SigningTime', $value, C::XADESNS, 'xades:');
    if ($this->signingTimeNode) {
      $this->signedSignaturePropertiesNode->replaceChild(
        $newSigningTimeNode, $this->signingTimeNode);
      $this->signingCertNode = $newSigningTimeNode;
    }
    else {
      $this->signingCertNode = $this->signedSignaturePropertiesNode->insertBefore(
        $newSigningTimeNode, $this->signingCertNode);
    }

    return $this->signingCertNode;
  }

  /** @inheritdoc */
  protected function processReference(\DOMElement $ref) {
    /*
     * Depending on the URI, we may need to remove comments during canonicalization.
     * See: http://www.w3.org/TR/xmldsig-core/#sec-ReferenceProcessingModel
     */
    $includeCommentNodes = TRUE;
    $dataObject = $ref->ownerDocument;
    $dataIsXML = TRUE;

    if ($ref->hasAttribute("URI")) {
      $uri = $ref->getAttribute('URI');
      if (empty($uri)) {
        // this reference identifies the enclosing XML, it should not include comments
        $includeCommentNodes = FALSE;
      }
      $arUrl = parse_url($uri);
      if (empty($arUrl['path'])) {
        if ($identifier = @$arUrl['fragment']) {
          /*
           * This reference identifies a node with the given ID by using a URI on the form '#identifier'.
           * This should not include comments.
           */
          $includeCommentNodes = FALSE;

          $xp = XP::getXPath($ref->ownerDocument);
          if ($this->idNS && is_array($this->idNS)) {
            foreach ($this->idNS as $nspf => $ns) {
              $xp->registerNamespace($nspf, $ns);
            }
          }
          $iDlist = '@Id="' . $identifier . '"';
          if (is_array($this->idKeys)) {
            foreach ($this->idKeys as $idKey) {
              $iDlist .= " or @$idKey='$identifier'";
            }
          }
          $query = '//*[' . $iDlist . ']';
          $dataObject = $xp->query($query)->item(0);
          if ($dataObject === NULL) {
            $xp2 = XP::getXPath($this->sigNode->ownerDocument);
            $query = '//*[@Id="SignedProperties"]';
            $dataObject = $xp2->query($query)->item(0);
          }
          if ($dataObject === NULL) {
            throw new \RuntimeException('Reference not found: ' . $query);
          }
        }
      }
      else {
        $filename = $arUrl['path'];
        if (file_exists($filename)) {
          $dataObject = file_get_contents($filename);
          $dataIsXML = FALSE;
          $includeCommentNodes = FALSE;
        }
        else {
          throw new \RuntimeException('External document not found (URI: ' . $arUrl['path'] . ')');
        }
      }
    }
    else {
      // this reference identifies the root node with an empty URI, it should not include comments
      $includeCommentNodes = FALSE;
    }

    $data = $this->processTransforms($ref, $dataObject, $includeCommentNodes);
    if (!$this->validateDigest($ref, $data)) {
      return FALSE;
    }

    // parse the canonicalized reference...
    if ($dataIsXML) {
      $doc = DOMDocumentFactory::create();
      $doc->loadXML($data);
      $dataObject = $doc->documentElement;
    }

    // ... and add it to the list of verified elements
    if (!empty($identifier)) {
      $this->verifiedElements[$identifier] = $dataObject;
    }
    else {
      $this->verifiedElements[] = $dataObject;
    }

    return TRUE;
  }
}