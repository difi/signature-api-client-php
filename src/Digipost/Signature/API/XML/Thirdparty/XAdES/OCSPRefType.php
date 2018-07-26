<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing OCSPRefType
 *
 *
 * XSD Type: OCSPRefType
 */
class OCSPRefType
{

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\OCSPIdentifierType $oCSPIdentifier
     */
    private $oCSPIdentifier = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType $digestAlgAndValue
     */
    private $digestAlgAndValue = null;

    /**
     * Gets as oCSPIdentifier
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\OCSPIdentifierType
     */
    public function getOCSPIdentifier()
    {
        return $this->oCSPIdentifier;
    }

    /**
     * Sets a new oCSPIdentifier
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\OCSPIdentifierType $oCSPIdentifier
     * @return self
     */
    public function setOCSPIdentifier(\Digipost\Signature\API\XML\Thirdparty\XAdES\OCSPIdentifierType $oCSPIdentifier)
    {
        $this->oCSPIdentifier = $oCSPIdentifier;
        return $this;
    }

    /**
     * Gets as digestAlgAndValue
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType
     */
    public function getDigestAlgAndValue()
    {
        return $this->digestAlgAndValue;
    }

    /**
     * Sets a new digestAlgAndValue
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType $digestAlgAndValue
     * @return self
     */
    public function setDigestAlgAndValue(\Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType $digestAlgAndValue)
    {
        $this->digestAlgAndValue = $digestAlgAndValue;
        return $this;
    }


}

