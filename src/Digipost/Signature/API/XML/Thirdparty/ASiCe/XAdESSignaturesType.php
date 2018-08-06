<?php

namespace Digipost\Signature\API\XML\Thirdparty\ASiCe;

/**
 * Class representing XAdESSignaturesType
 *
 *
 * XSD Type: XAdESSignaturesType
 */
class XAdESSignaturesType
{

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Signature[] $signature
     */
    private $signature = array(
        
    );

    /**
     * Adds as signature
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Signature $signature
     */
    public function addToSignature(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\Signature $signature)
    {
        $this->signature[] = $signature;
        return $this;
    }

    /**
     * isset signature
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetSignature($index)
    {
        return isset($this->signature[$index]);
    }

    /**
     * unset signature
     *
     * @param string|number $index
     * @return void
     */
    public function unsetSignature($index)
    {
        unset($this->signature[$index]);
    }

    /**
     * Gets as signature
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Signature[]
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Sets a new signature
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Signature[] $signature
     * @return self
     */
    public function setSignature(array $signature)
    {
        $this->signature = $signature;
        return $this;
    }


}

