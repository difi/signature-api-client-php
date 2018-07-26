<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing CRLRefType
 *
 *
 * XSD Type: CRLRefType
 */
class CRLRefType
{

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\DigestAlgAndValueType $digestAlgAndValue
     */
    private $digestAlgAndValue = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\CRLIdentifierType $cRLIdentifier
     */
    private $cRLIdentifier = null;

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

    /**
     * Gets as cRLIdentifier
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\CRLIdentifierType
     */
    public function getCRLIdentifier()
    {
        return $this->cRLIdentifier;
    }

    /**
     * Sets a new cRLIdentifier
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CRLIdentifierType $cRLIdentifier
     * @return self
     */
    public function setCRLIdentifier(\Digipost\Signature\API\XML\Thirdparty\XAdES\CRLIdentifierType $cRLIdentifier)
    {
        $this->cRLIdentifier = $cRLIdentifier;
        return $this;
    }


}

