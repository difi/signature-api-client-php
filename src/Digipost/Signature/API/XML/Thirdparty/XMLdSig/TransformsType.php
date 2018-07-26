<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

/**
 * Class representing TransformsType
 *
 *
 * XSD Type: TransformsType
 */
class TransformsType
{

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform[] $transform
     */
    private $transform = array(
        
    );

    /**
     * Adds as transform
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform $transform
     */
    public function addToTransform(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform $transform)
    {
        $this->transform[] = $transform;
        return $this;
    }

    /**
     * isset transform
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetTransform($index)
    {
        return isset($this->transform[$index]);
    }

    /**
     * unset transform
     *
     * @param scalar $index
     * @return void
     */
    public function unsetTransform($index)
    {
        unset($this->transform[$index]);
    }

    /**
     * Gets as transform
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform[]
     */
    public function getTransform()
    {
        return $this->transform;
    }

    /**
     * Sets a new transform
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform[] $transform
     * @return self
     */
    public function setTransform(array $transform)
    {
        $this->transform = $transform;
        return $this;
    }


}

