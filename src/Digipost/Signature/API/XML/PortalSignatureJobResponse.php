<?php

namespace Digipost\Signature\API\XML;

/**
 * Class representing PortalSignatureJobResponse
 */
class PortalSignatureJobResponse
{

    /**
     * @property integer $signatureJobId
     */
    private $signatureJobId = null;

    /**
     * @property string $cancellationUrl
     */
    private $cancellationUrl = null;

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


}

