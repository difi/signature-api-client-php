<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing CounterSignatureType
 *
 *
 * XSD Type: CounterSignatureType
 */
class CounterSignatureType
{

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Signature $signature
     */
    private $signature = null;

    /**
     * Gets as signature
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Signature
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Sets a new signature
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Signature $signature
     * @return self
     */
    public function setSignature(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\Signature $signature)
    {
        $this->signature = $signature;
        return $this;
    }


}

