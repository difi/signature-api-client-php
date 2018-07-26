<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

/**
 * Class representing DigestValue
 */
class DigestValue
{

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $__value
     */
    private $__value = null;

    /**
     * Construct
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $value
     */
    public function __construct(\Digipost\Signature\API\XML\CustomBase64BinaryType $value)
    {
        $this->value($value);
    }

    /**
     * Gets or sets the inner value
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $value
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType
     */
    public function value()
    {
        if ($args = func_get_args()) {
            $this->__value = $args[0];
        }
        return $this->__value;
    }

    /**
     * Gets a string value
     *
     * @return string
     */
    public function __toString()
    {
        return strval($this->__value);
    }


}

