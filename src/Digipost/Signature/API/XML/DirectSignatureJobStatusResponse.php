<?php

namespace Digipost\Signature\API\XML;

/**
 * Class representing DirectSignatureJobStatusResponse
 */
class DirectSignatureJobStatusResponse
{

    /**
     * @property integer $signatureJobId
     */
    private $signatureJobId = null;

    /**
     * @property \Digipost\Signature\API\XML\XMLDirectSignatureJobStatus $signatureJobStatus
     */
    private $signatureJobStatus = null;

    /**
     * @property \Digipost\Signature\API\XML\XMLSignerStatus[] $status
     */
    private $status = array(
        
    );

    /**
     * If a confirmation url is included in the response, the client is required to POST an empty
     * request to this url to confirm that the status has been received, and proper actions has been
     * taken by the client as a result of the particular status. A typical example being when the client
     * gets a 'signed' status, the client should download the signed documents, and finally confirm the
     * received status using this url.
     *
     * If the status is retrieved using the POLLING method, failing to confirm the
     * received response may cause subsequent statuses for the same job to be reported as "changed", even
     * though the status has not changed.
     *
     * @property string $confirmationUrl
     */
    private $confirmationUrl = null;

    /**
     * @property string $deleteDocumentsUrl
     */
    private $deleteDocumentsUrl = null;

    /**
     * @property \Digipost\Signature\API\XML\XMLSignerSpecificUrl[] $xadesUrl
     */
    private $xadesUrl = array(
        
    );

    /**
     * @property string $padesUrl
     */
    private $padesUrl = null;

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
     * Gets as signatureJobStatus
     *
     * @return \Digipost\Signature\API\XML\XMLDirectSignatureJobStatus
     */
    public function getSignatureJobStatus()
    {
        return $this->signatureJobStatus;
    }

    /**
     * Sets a new signatureJobStatus
     *
     * @param \Digipost\Signature\API\XML\XMLDirectSignatureJobStatus $signatureJobStatus
     * @return self
     */
    public function setSignatureJobStatus(\Digipost\Signature\API\XML\XMLDirectSignatureJobStatus $signatureJobStatus)
    {
        $this->signatureJobStatus = $signatureJobStatus;
        return $this;
    }

    /**
     * Adds as status
     *
     * @return self
     * @param \Digipost\Signature\API\XML\XMLSignerStatus $status
     */
    public function addToStatus(\Digipost\Signature\API\XML\XMLSignerStatus $status)
    {
        $this->status[] = $status;
        return $this;
    }

    /**
     * isset status
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetStatus($index)
    {
        return isset($this->status[$index]);
    }

    /**
     * unset status
     *
     * @param string|number $index
     * @return void
     */
    public function unsetStatus($index)
    {
        unset($this->status[$index]);
    }

    /**
     * Gets as status
     *
     * @return \Digipost\Signature\API\XML\XMLSignerStatus[]
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets a new status
     *
     * @param \Digipost\Signature\API\XML\XMLSignerStatus[] $status
     * @return self
     */
    public function setStatus(array $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Gets as confirmationUrl
     *
     * If a confirmation url is included in the response, the client is required to POST an empty
     * request to this url to confirm that the status has been received, and proper actions has been
     * taken by the client as a result of the particular status. A typical example being when the client
     * gets a 'signed' status, the client should download the signed documents, and finally confirm the
     * received status using this url.
     *
     * If the status is retrieved using the POLLING method, failing to confirm the
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
     * If a confirmation url is included in the response, the client is required to POST an empty
     * request to this url to confirm that the status has been received, and proper actions has been
     * taken by the client as a result of the particular status. A typical example being when the client
     * gets a 'signed' status, the client should download the signed documents, and finally confirm the
     * received status using this url.
     *
     * If the status is retrieved using the POLLING method, failing to confirm the
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
     * Adds as xadesUrl
     *
     * @return self
     * @param \Digipost\Signature\API\XML\XMLSignerSpecificUrl $xadesUrl
     */
    public function addToXadesUrl(\Digipost\Signature\API\XML\XMLSignerSpecificUrl $xadesUrl)
    {
        $this->xadesUrl[] = $xadesUrl;
        return $this;
    }

    /**
     * isset xadesUrl
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetXadesUrl($index)
    {
        return isset($this->xadesUrl[$index]);
    }

    /**
     * unset xadesUrl
     *
     * @param string|number $index
     * @return void
     */
    public function unsetXadesUrl($index)
    {
        unset($this->xadesUrl[$index]);
    }

    /**
     * Gets as xadesUrl
     *
     * @return \Digipost\Signature\API\XML\XMLSignerSpecificUrl[]
     */
    public function getXadesUrl()
    {
        return $this->xadesUrl;
    }

    /**
     * Sets a new xadesUrl
     *
     * @param \Digipost\Signature\API\XML\XMLSignerSpecificUrl[] $xadesUrl
     * @return self
     */
    public function setXadesUrl(array $xadesUrl)
    {
        $this->xadesUrl = $xadesUrl;
        return $this;
    }

    /**
     * Gets as padesUrl
     *
     * @return string
     */
    public function getPadesUrl()
    {
        return $this->padesUrl;
    }

    /**
     * Sets a new padesUrl
     *
     * @param string $padesUrl
     * @return self
     */
    public function setPadesUrl($padesUrl)
    {
        $this->padesUrl = $padesUrl;
        return $this;
    }


}

