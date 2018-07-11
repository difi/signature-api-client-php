<?php

namespace Digipost\Signature\API\XML;

use Doctrine\Common\Annotations\Annotation\Required;
use Ds\Set;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLDirectSignatureJobResponse
 *
 * <p>The following schema fragment specifies the expected content contained
 * within this class.
 *
 * ```
 * <complexType>
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="signature-job-id" type="{http://signering.posten.no/schema/v1}signature-job-id"/>
 *         <element name="redirect-url" type="{http://signering.posten.no/schema/v1}signer-specific-url" maxOccurs="10"/>
 *         <element name="status-url" type="{http://signering.posten.no/schema/v1}url" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * ```
 *
 * @package Digipost\Signature\API\XML
 *
 * @Serializer\XmlRoot(name="direct-signature-job-response", namespace="http://signering.posten.no/schema/v1")
 * @Serializer\AccessorOrder("custom", custom={
 *   "signatureJobId",
 *   "redirectUrls",
 *   "statusUrl"
 * })
 */
class XMLDirectSignatureJobResponse {

  /**
   * @var int
   * @Serializer\Type("int")
   * @Serializer\XmlElement()
   * @Serializer\SerializedName("signature-job-id")
   */
  protected $signatureJobId;

  /**
   * @Serializer\Type("array<Digipost\Signature\API\XML\XMLSignerSpecificUrl>")
   * @Serializer\XmlList(inline=true, entry="redirect-url")
   */
  protected $redirectUrls;

  /**
   * @var String
   * @Serializer\Type("string")
   * @Serializer\XmlElement()
   * @Serializer\SerializedName("status-url")
   */
  protected $statusUrl;

  function __construct(int $signatureJobId = NULL,
                       array $redirectUrls = NULL,
                       String $statusUrl = NULL) {
    $this->signatureJobId = $signatureJobId;
    $this->redirectUrls = $redirectUrls;
    $this->statusUrl = $statusUrl;
  }

  public function getSignatureJobId() {
    return $this->signatureJobId;
  }

  public function setSignatureJobId($value) {
    $this->signatureJobId = $value;
  }

  public function getRedirectUrls() {
    if (($this->redirectUrls === NULL)) {
      $this->redirectUrls = [];
    }
    //return new Set($this->redirectUrls);
    //return new \ArrayObject($this->redirectUrls);
    return $this->redirectUrls;
  }

  public function getStatusUrl() {
    return $this->statusUrl;
  }

  public function setStatusUrl($value) {
    $this->statusUrl = $value;
  }
}

