<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing OCSPIdentifierType
 *
 *
 * XSD Type: OCSPIdentifierType
 */
class OCSPIdentifierType
{

    /**
     * @property string $uRI
     */
    private $uRI = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\ResponderIDType $responderID
     */
    private $responderID = null;

    /**
     * @property \DateTime $producedAt
     */
    private $producedAt = null;

    /**
     * Gets as uRI
     *
     * @return string
     */
    public function getURI()
    {
        return $this->uRI;
    }

    /**
     * Sets a new uRI
     *
     * @param string $uRI
     * @return self
     */
    public function setURI($uRI)
    {
        $this->uRI = $uRI;
        return $this;
    }

    /**
     * Gets as responderID
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\ResponderIDType
     */
    public function getResponderID()
    {
        return $this->responderID;
    }

    /**
     * Sets a new responderID
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\ResponderIDType $responderID
     * @return self
     */
    public function setResponderID(\Digipost\Signature\API\XML\Thirdparty\XAdES\ResponderIDType $responderID)
    {
        $this->responderID = $responderID;
        return $this;
    }

    /**
     * Gets as producedAt
     *
     * @return \DateTime
     */
    public function getProducedAt()
    {
        return $this->producedAt;
    }

    /**
     * Sets a new producedAt
     *
     * @param \DateTime $producedAt
     * @return self
     */
    public function setProducedAt(\DateTime $producedAt)
    {
        $this->producedAt = $producedAt;
        return $this;
    }


}

