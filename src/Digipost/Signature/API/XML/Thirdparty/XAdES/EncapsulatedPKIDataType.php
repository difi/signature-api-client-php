<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing EncapsulatedPKIDataType
 *
 *
 * XSD Type: EncapsulatedPKIDataType
 */
class EncapsulatedPKIDataType
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
     * @property string $encoding
     */
    private $encoding = null;

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

    /**
     * Gets as encoding
     *
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Sets a new encoding
     *
     * @param string $encoding
     * @return self
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
        return $this;
    }


}

