<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

/**
 * Class representing KeyValueType
 *
 *
 * XSD Type: KeyValueType
 */
class KeyValueType
{

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\DSAKeyValue $dSAKeyValue
     */
    private $dSAKeyValue = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\RSAKeyValue $rSAKeyValue
     */
    private $rSAKeyValue = null;

    /**
     * Gets as dSAKeyValue
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\DSAKeyValue
     */
    public function getDSAKeyValue()
    {
        return $this->dSAKeyValue;
    }

    /**
     * Sets a new dSAKeyValue
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\DSAKeyValue $dSAKeyValue
     * @return self
     */
    public function setDSAKeyValue(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\DSAKeyValue $dSAKeyValue)
    {
        $this->dSAKeyValue = $dSAKeyValue;
        return $this;
    }

    /**
     * Gets as rSAKeyValue
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\RSAKeyValue
     */
    public function getRSAKeyValue()
    {
        return $this->rSAKeyValue;
    }

    /**
     * Sets a new rSAKeyValue
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\RSAKeyValue $rSAKeyValue
     * @return self
     */
    public function setRSAKeyValue(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\RSAKeyValue $rSAKeyValue)
    {
        $this->rSAKeyValue = $rSAKeyValue;
        return $this;
    }


}

