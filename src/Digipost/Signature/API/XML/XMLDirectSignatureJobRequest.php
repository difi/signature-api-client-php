<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLDirectSignatureJobRequest
 *
 * <p>Contains metadata related to a signature job
 *
 * <p>The following schema fragment specifies the expected content contained
 * within this class.
 *
 * ```
 * <complexType>
 *   <complexContent>
 *     <restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       <sequence>
 *         <element name="reference" type="{http://signering.posten.no/schema/v1}signature-job-reference" minOccurs="0"/>
 *         <element name="exit-urls" type="{http://signering.posten.no/schema/v1}exit-urls"/>
 *         <element name="status-retrieval-method" type="{http://signering.posten.no/schema/v1}status-retrieval-method" minOccurs="0"/>
 *         <element name="polling-queue" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
 *       </sequence>
 *     </restriction>
 *   </complexContent>
 * </complexType>
 * ```
 *
 * @package Digipost\Signature\API\XML
 *
 * @Serializer\XmlRoot(name="direct-signature-job-request")
 * @Serializer\AccessorOrder("custom", custom={
 *   "reference",
 *   "exitUrls",
 *   "statusRetrievalMethod",
 *   "pollingQueue"
 * })
 */
class XMLDirectSignatureJobRequest {

  /**
   * @Serializer\XmlElement()
   */
  protected $reference;

  /**
   * @Serializer\Type("Digipost\Signature\API\XML\XMLExitUrls")
   * @Serializer\SerializedName("exit-urls")
   */
  protected $exitUrls;

  /**
   * Indicates the method of which the sender will retrieve a job's status upon a status change by specifying one of:
   *
   *     * WAIT_FOR_CALLBACK
   *         Querying the job's status explicitly using the query parameter appended
   *         to the exit-URL after e.g. a signer have completed the job
   *     * POLLING
   *         Continuously polling the service, receiving a response every time one of the
   *         sender's jobs has had its status changed.
   *
   * Defaults to WAIT_FOR_CALLBACK if omitted.
   *
   * @Serializer\Type("Digipost\Signature\API\XML\XMLStatusRetrievalMethod")
   * @Serializer\SerializedName("status-retrieval-method")
   * @Serializer\Exclude()
   */
  protected $statusRetrievalMethod;

  /**
   * Specifies the queue that status changes for this signature job will occur in. This is a feature aimed at organizations where
   * it makes sense to retrieve status changes from several queues. This may be if the organization has more than one division,
   * and each division has an application that create signature jobs through the API and want to retrieve status changes
   * independent of the other division's actions.
   *
   * For example, if the polling-queue element is set to 'custom-queue', status changes related to this signature job can only
   * be retrieved by setting the query parameter 'polling_queue' to 'custom-queue' on the request. If the polling-queue element is not
   * specified, the job status changes will be available on the default queue. No query parameter is required to obtain status changes
   * for the default queue.
   *
   * @Serializer\XmlElement()
   * @Serializer\SerializedName("polling-queue")
   */
  protected $pollingQueue;

  /**
   * XMLDirectSignatureJobRequest constructor.
   *
   * @param String $reference
   * @param XMLExitUrls $exitUrls
   * @param XMLStatusRetrievalMethod $statusRetrievalMethod
   * @param String $pollingQueue
   */
  function __construct(String $reference = NULL, XMLExitUrls $exitUrls = NULL,
                       XMLStatusRetrievalMethod $statusRetrievalMethod = NULL,
                       String $pollingQueue = NULL) {
    $this->reference = $reference;
    $this->exitUrls = $exitUrls;
    $this->statusRetrievalMethod = $statusRetrievalMethod;
    $this->pollingQueue = $pollingQueue;
  }

  public function getReference() {
    return $this->reference;
  }

  public function setReference($value) // [String value]
  {
    $this->reference = $value;
  }

  public function getExitUrls() {
    return $this->exitUrls;
  }

  public function setExitUrls($value) // [XMLExitUrls value]
  {
    $this->exitUrls = $value;
  }

  public function getStatusRetrievalMethod() {
    return $this->statusRetrievalMethod;
  }

  public function setStatusRetrievalMethod($value) // [XMLStatusRetrievalMethod value]
  {
    $this->statusRetrievalMethod = $value;
  }

  public function getPollingQueue() {
    return $this->pollingQueue;
  }

  public function setPollingQueue($value) {
    $this->pollingQueue = $value;
  }

  public function withReference($reference) {
    $this->reference = $reference;
    return $this;
  }

  public function withExitUrls($exitUrls) {
    $this->exitUrls = $exitUrls;
    return $this;
  }

  public function withStatusRetrievalMethod($value) {
    $this->statusRetrievalMethod = $value;
    return $this;
  }

  public function withPollingQueue($value) {
    $this->pollingQueue = $value;
    return $this;
  }
}

