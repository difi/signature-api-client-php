<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

/**
 * Class representing RSAKeyValueType
 *
 *
 * XSD Type: RSAKeyValueType
 */
class RSAKeyValueType
{

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $modulus
     */
    private $modulus = null;

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $exponent
     */
    private $exponent = null;

    /**
     * Gets as modulus
     *
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType
     */
    public function getModulus()
    {
        return $this->modulus;
    }

    /**
     * Sets a new modulus
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $modulus
     * @return self
     */
    public function setModulus(\Digipost\Signature\API\XML\CustomBase64BinaryType $modulus)
    {
        $this->modulus = $modulus;
        return $this;
    }

    /**
     * Gets as exponent
     *
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType
     */
    public function getExponent()
    {
        return $this->exponent;
    }

    /**
     * Sets a new exponent
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $exponent
     * @return self
     */
    public function setExponent(\Digipost\Signature\API\XML\CustomBase64BinaryType $exponent)
    {
        $this->exponent = $exponent;
        return $this;
    }


}

