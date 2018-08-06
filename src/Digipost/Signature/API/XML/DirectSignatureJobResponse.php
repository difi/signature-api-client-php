<?php

namespace Digipost\Signature\API\XML;

/**
 * Class representing DirectSignatureJobResponse
 */
class DirectSignatureJobResponse
{

    /**
     * @property integer $signatureJobId
     */
    private $signatureJobId = null;

    /**
     * @property \Digipost\Signature\API\XML\XMLSignerSpecificUrl[] $redirectUrl
     */
    private $redirectUrl = array(
        
    );

    /**
     * @property string $statusUrl
     */
    private $statusUrl = null;

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
     * Adds as redirectUrl
     *
     * @return self
     * @param \Digipost\Signature\API\XML\XMLSignerSpecificUrl $redirectUrl
     */
    public function addToRedirectUrl(\Digipost\Signature\API\XML\XMLSignerSpecificUrl $redirectUrl)
    {
        $this->redirectUrl[] = $redirectUrl;
        return $this;
    }

    /**
     * isset redirectUrl
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetRedirectUrl($index)
    {
        return isset($this->redirectUrl[$index]);
    }

    /**
     * unset redirectUrl
     *
     * @param string|number $index
     * @return void
     */
    public function unsetRedirectUrl($index)
    {
        unset($this->redirectUrl[$index]);
    }

    /**
     * Gets as redirectUrl
     *
     * @return \Digipost\Signature\API\XML\XMLSignerSpecificUrl[]
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * Sets a new redirectUrl
     *
     * @param \Digipost\Signature\API\XML\XMLSignerSpecificUrl[] $redirectUrl
     * @return self
     */
    public function setRedirectUrl(array $redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
        return $this;
    }

    /**
     * Gets as statusUrl
     *
     * @return string
     */
    public function getStatusUrl()
    {
        return $this->statusUrl;
    }

    /**
     * Sets a new statusUrl
     *
     * @param string $statusUrl
     * @return self
     */
    public function setStatusUrl($statusUrl)
    {
        $this->statusUrl = $statusUrl;
        return $this;
    }


}

