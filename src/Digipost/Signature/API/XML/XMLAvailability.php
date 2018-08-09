<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLAvailability
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="availability">
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="activation-time" type="{http://www.w3.org/2001/XMLSchema}dateTime" minOccurs="0"/>
 *         <element name="available-seconds" type="{http://signering.posten.no/schema/v1}nonNegativeLong" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML
 *
 * @Serializer\AccessorOrder("custom", custom={
 *   "activationTime",
 *   "availableSeconds"
 * })
 */
class XMLAvailability {

  /**
   * Specifies the earliest time the documents should be activated, i.e. made available to the signer(s) to sign.
   * Omitting this, or using a time before now makes the documents available for signing immediately.
   *
   * @var \DateTime
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("DateTime")
   * @Serializer\SerializedName("activation-time")
   */
  protected $activationTime;

  /**
   * Specifies how many seconds after activation (i.e. seconds after activation-time if set, creation time if not) the document can be signed.
   * Omitting this will set a default availability length for the job.
   *
   * Please refer to the documentation to determine the default availability length, as well as the limit for
   * how far in the future a job can be set to expire.
   *
   * @var int
   * @Serializer\XmlElement(cdata=false)
   * @Serializer\Type("int")
   * @Serializer\SerializedName("available-seconds")
   */
  protected $availableSeconds;

  public function __construct(\DateTime $activationTime = NULL,
                              int $availableSeconds = NULL) {
    $this->activationTime = $activationTime;
    $this->availableSeconds = $availableSeconds;
  }

  public function getActivationTime() {
    return $this->activationTime;
  }

  public function setActivationTime($value)
  {
    $this->activationTime = $value;
  }

  public function getAvailableSeconds() {
    return $this->availableSeconds;
  }

  public function setAvailableSeconds($value)
  {
    $this->availableSeconds = $value;
  }

  public function withActivationTime($value)
  {
    $this->setActivationTime($value);
    return $this;
  }

  public function withAvailableSeconds($value)
  {
    $this->setAvailableSeconds($value);
    return $this;
  }
}

