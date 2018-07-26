<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing DigestAlgAndValueType
 *
 *
 * XSD Type: DigestAlgAndValueType
 */
class DigestAlgAndValueType
{

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod $digestMethod
     */
    private $digestMethod = null;

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $digestValue
     */
    private $digestValue = null;

    /**
     * Gets as digestMethod
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod
     */
    public function getDigestMethod()
    {
        return $this->digestMethod;
    }

    /**
     * Sets a new digestMethod
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod $digestMethod
     * @return self
     */
    public function setDigestMethod(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod $digestMethod)
    {
        $this->digestMethod = $digestMethod;
        return $this;
    }

    /**
     * Gets as digestValue
     *
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType
     */
    public function getDigestValue()
    {
        return $this->digestValue;
    }

    /**
     * Sets a new digestValue
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $digestValue
     * @return self
     */
    public function setDigestValue($digestValue)
    {
        $this->digestValue = $digestValue;
        return $this;
    }


}

