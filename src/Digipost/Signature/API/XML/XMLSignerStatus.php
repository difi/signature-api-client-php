<?php

namespace Digipost\Signature\API\XML;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class XMLSignerStatus
 *
 * Textual field which describes the signer status. Note that this field might contain new, unknown statuses in the future.
 * Clients should use the direct-signature-job-status element for getting the status of the entire job. Unknown signer status should be logged for later review and ignored at runtime.
 *
 * Currently known values:
 *     * WAITING
 *         The signer has not yet signed the document.
 *     * REJECTED
 *         The user decided to reject to sign the document, and has been redirected to the rejection-url provided in the direct-signature-job-request's exit-urls.
 *     * EXPIRED
 *         The user didn't sign the document before the job expired.
 *     * FAILED
 *         An unexpected error occured during the signing ceremony, and the user has been redirected to the error-url provided in the direct-signature-job-request's exit-urls.
 *     * SIGNED
 *         The document has been signed, and the signer has been redirected to the completion-url provided in the direct-signature-job-request's exit-urls.
 *         The signed document artifacts can be downloaded by following the appropriate urls in the direct-signature-job-status-response.
 *     * SIGNERS_NAME_NOT_AVAILABLE
 *         Indicates that the service was unable to retrieve the signer's name. This might happen because the lookup service is unavailable at the time of signing,
 *         but the name can also be unavailable permanently. Senders may choose to try re-creating this signature job.
 *         Only applicable for authenticated signatures where the sender requires signed documents to contain name as the signer's identifier.
 *     * NOT_APPLICABLE
 *         The job has reached a state where the status of this signature is not applicable.
 *         This includes (but is not limited to) the case where a signer rejects to sign, and thus ending the job in a failed state.
 *         Any remaining (previously WAITING) signatures are marked as NOT_APPLICABLE.
 *
 *
 * <p>Java class for signer-status complex type.
 *
 * <p>The following schema fragment specifies the expected content contained within this class.
 *
 * <pre>
 * <complexType name="signer-status">
 *   <simpleContent>
 *     <extension base="<http://www.w3.org/2001/XMLSchema>string">
 *       <attribute name="signer" type="{http://www.w3.org/2001/XMLSchema}string" />
 *       <attribute name="since" use="required" type="{http://www.w3.org/2001/XMLSchema}dateTime" />
 *     </extension>
 *   </simpleContent>
 * </complexType>
 * </pre>
 *
 * @package Digipost\Signature\API\XML
 *
 * @Serializer\XmlRoot("signer-status")
 */
class XMLSignerStatus {

  /**
   * @Serializer\XmlValue()
   * @Serializer\Type("string")
   */
  protected $value;

  /**
   * @Serializer\Type("string")
   * @Serializer\XmlAttribute()
   */
  protected $signer;

  /**
   * @Serializer\Type("DateTime")
   * @Serializer\XmlAttribute()
   */
  protected $since;

  function __construct(String $value = NULL, String $signer = NULL,
                       \DateTime $since = NULL) {
    $this->value = $value;
    $this->signer = $signer;
    $this->since = $since;
  }

  public function getValue() {
    return $this->value;
  }

  public function setValue($value) {
    $this->value = $value;
  }

  public function getSigner() {
    return $this->signer;
  }

  public function setSigner($value) {
    $this->signer = $value;
  }

  public function getSince() {
    return $this->since;
  }

  public function setSince($value) {
    $this->since = $value;
  }
}

