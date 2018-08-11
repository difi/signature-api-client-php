<?php

namespace Digipost\Signature\API\XML;

/**
 * Class representing PortalSignatureJobStatusChangeResponse
 */
class PortalSignatureJobStatusChangeResponse
{

    /**
     * @property integer $signatureJobId
     */
    private $signatureJobId = null;

    /**
     * @property XMLPortalSignatureJobStatus $status
     */
    private $status = null;

    /**
     * For every received response, the client is required to POST an empty request to this url to confirm
     * that proper actions has been taken by the client as a result of the particular status.
     * A typical example being when the client gets a 'signed' status, the client should download
     * the signed documents, and finally confirm the received status using this url. Failing to confirm the
     * received response may cause subsequent statuses for the same job to be reported as "changed", even
     * though the status has not changed.
     *
     * @property string $confirmationUrl
     */
    private $confirmationUrl = null;

    /**
     * @property string $cancellationUrl
     */
    private $cancellationUrl = null;

    /**
     * @property string $deleteDocumentsUrl
     */
    private $deleteDocumentsUrl = null;

    /**
     * @property XMLSignatures $signatures
     */
    private $signatures = null;

    /**
     * Gets as signatureJobId
     *
     * @return integer
     */
    public function getSignatureJobId()
    {
        return $this->signatureJobId;
    }

    /**
     * Sets a new signatureJobId
     *
     * @param integer $signatureJobId
     * @return self
     */
    public function setSignatureJobId($signatureJobId)
    {
        $this->signatureJobId = $signatureJobId;
        return $this;
    }

    /**
     * Gets as status
     *
     * @return XMLPortalSignatureJobStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets a new status
     *
     * @param XMLPortalSignatureJobStatus $status
     *
     * @return self
     */
    public function setStatus(XMLPortalSignatureJobStatus $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Gets as confirmationUrl
     *
     * For every received response, the client is required to POST an empty request to this url to confirm
     * that proper actions has been taken by the client as a result of the particular status.
     * A typical example being when the client gets a 'signed' status, the client should download
     * the signed documents, and finally confirm the received status using this url. Failing to confirm the
     * received response may cause subsequent statuses for the same job to be reported as "changed", even
     * though the status has not changed.
     *
     * @return string
     */
    public function getConfirmationUrl()
    {
        return $this->confirmationUrl;
    }

    /**
     * Sets a new confirmationUrl
     *
     * For every received response, the client is required to POST an empty request to this url to confirm
     * that proper actions has been taken by the client as a result of the particular status.
     * A typical example being when the client gets a 'signed' status, the client should download
     * the signed documents, and finally confirm the received status using this url. Failing to confirm the
     * received response may cause subsequent statuses for the same job to be reported as "changed", even
     * though the status has not changed.
     *
     * @param string $confirmationUrl
     * @return self
     */
    public function setConfirmationUrl($confirmationUrl)
    {
        $this->confirmationUrl = $confirmationUrl;
        return $this;
    }

    /**
     * Gets as cancellationUrl
     *
     * @return string
     */
    public function getCancellationUrl()
    {
        return $this->cancellationUrl;
    }

    /**
     * Sets a new cancellationUrl
     *
     * @param string $cancellationUrl
     * @return self
     */
    public function setCancellationUrl($cancellationUrl)
    {
        $this->cancellationUrl = $cancellationUrl;
        return $this;
    }

    /**
     * Gets as deleteDocumentsUrl
     *
     * @return string
     */
    public function getDeleteDocumentsUrl()
    {
        return $this->deleteDocumentsUrl;
    }

    /**
     * Sets a new deleteDocumentsUrl
     *
     * @param string $deleteDocumentsUrl
     * @return self
     */
    public function setDeleteDocumentsUrl($deleteDocumentsUrl)
    {
        $this->deleteDocumentsUrl = $deleteDocumentsUrl;
        return $this;
    }

    /**
     * Gets as signatures
     *
     * @return XMLSignatures
     */
    public function getSignatures()
    {
        return $this->signatures;
    }

    /**
     * Sets a new signatures
     *
     * @param XMLSignatures $signatures
     *
     * @return self
     */
    public function setSignatures(XMLSignatures $signatures)
    {
        $this->signatures = $signatures;
        return $this;
    }


}

