<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

/**
 * Class representing SignatureValueType
 *
 *
 * XSD Type: SignatureValueType
 */
class SignatureValueType
{

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $__value
     */
    private $__value = null;

    /**
     * @property string $id
     */
    private $id = null;

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

    /**
     * Gets as id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets a new id
     *
     * @param string $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


}

