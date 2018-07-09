<?php

namespace Digipost\Signature\API\XML;

use Digipost\Signature\JAXB\XMLDocument;
use Digipost\Signature\JAXB\XMLManifest;
use Digipost\Signature\JAXB\XMLSigner;
use JMS\Serializer\Annotation as Serializer;

/**
 * Contains metadata related to a document in a signature job<
 *
 * <p>Java class for anonymous complex type.
 *
 * <p>The following schema fragment specifies the expected content contained
 * within this class.
 *
 *
 * ```
 * <complexType>
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="signer" type="{http://signering.posten.no/schema/v1}direct-signer" maxOccurs="10"/>
 *         <element name="sender" type="{http://signering.posten.no/schema/v1}sender"/>
 *         <element name="document" type="{http://signering.posten.no/schema/v1}direct-document"/>
 *         <element name="required-authentication" type="{http://signering.posten.no/schema/v1}authentication-level" minOccurs="0"/>
 *         <element name="identifier-in-signed-documents" type="{http://signering.posten.no/schema/v1}identifier-in-signed-documents" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * ```
 *
 * @package Digipost\Signature\API\XML
 *
 * @Serializer\XmlRoot(name="direct-signature-job-manifest", namespace="http://signering.posten.no/schema/v1")
 * @Serializer\AccessorOrder("custom", custom = {
 *   "signers",
 *   "sender",
 *   "document",
 *   "requiredAuthentication",
 *   "identifierInSignedDocuments"
 * })
 */
class XMLDirectSignatureJobManifest implements XMLManifest {

  /**
   * @var XMLDirectSigner[]
   * @Serializer\Type("array<Digipost\Signature\API\XML\XMLDirectSigner>")
   * @Serializer\XmlList(entry="signer", inline=true)
   */
  protected $signers;

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\XMLSender")
   */
  protected $sender;

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\XMLDirectDocument")
   */
  protected $document;

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\XMLAuthenticationLevel")
   * @Serializer\XmlElement(cdata=false)
   */
  protected $requiredAuthentication;

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\XMLIdentifierInSignedDocuments")
   * @Serializer\XmlElement(cdata=false)
   */
  protected $identifierInSignedDocuments;

  /**
   * Fully-initialising value constructor
   *
   * @param XMLDirectSigner                $signers
   * @param XMLSender                      $sender
   * @param XMLDirectDocument              $document
   * @param XMLAuthenticationLevel         $requiredAuthentication
   * @param XMLIdentifierInSignedDocuments $identifierInSignedDocuments
   */
  public function __construct(XMLDirectSigner $signers = NULL,
                              XMLSender $sender = NULL,
                              XMLDirectDocument $document = NULL,
                              XMLAuthenticationLevel $requiredAuthentication = NULL,
                              XMLIdentifierInSignedDocuments $identifierInSignedDocuments = NULL) {
    $this->signers = $signers;
    $this->sender = $sender;
    $this->document = $document;
    $this->requiredAuthentication = $requiredAuthentication;
    $this->identifierInSignedDocuments = $identifierInSignedDocuments;
  }

  function getDocument(): XMLDocument {
    return $this->document;
  }

  function getRequiredAuthentication(): XMLAuthenticationLevel {
    return $this->requiredAuthentication;
  }

  function getSigners() {
    return $this->signers;
  }

  function setDocument($document) {
    $this->document = $document;
  }

  function withSigners($signers) {
    //$this->signers = is_array($signers) ? [$signers] : $signers;
    $this->setSigners($signers);
    return $this;
  }

  function withRequiredAuthentication($requiredAuthentication) {
    $this->requiredAuthentication = $requiredAuthentication;
    return $this;
  }

  function withSender($sender) {
    $this->sender = $sender;
    return $this;
  }

  function withDocument($document) {
    $this->document = $document;
    return $this;
  }

  public function withIdentifierInSignedDocuments($identifierInSignedDocuments) {
    $this->identifierInSignedDocuments = $identifierInSignedDocuments;
    return $this;
  }

  public function getIdentifierInSignedDocuments(): XMLIdentifierInSignedDocuments {
    return $this->identifierInSignedDocuments;
  }

  /**
   * @param XMLDirectSigner[] $signers
   */
  public function setSigners($signers) {
    if (!isset($this->signers)) {
      $this->signers = [];
    }
    if (is_array($signers)) {
      $this->signers = $signers;
    } else {
      $this->signers[] = $signers;
    }
  }
}
