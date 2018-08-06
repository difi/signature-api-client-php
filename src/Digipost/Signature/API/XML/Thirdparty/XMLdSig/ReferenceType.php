<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

use Digipost\Signature\API\XML\CustomBase64BinaryType;
use Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestValue;

/**
 * Class representing ReferenceType
 *
 *
 * XSD Type: ReferenceType
 */
class ReferenceType
{

  /**
     * @property string $id
     */
    private $id = null;


  /**
   * @property string $type
   */
    private $type = null;

   /**
     * @property string $uRI
     */
    private $uRI = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform[] $transforms
     */
    private $transforms = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod $digestMethod
     */
    private $digestMethod = null;

    /**
     * @property DigestValue $digestValue
     */
    private $digestValue = null;

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
     * Gets as uRI
     *
     * @return string
     */
    public function getURI()
    {
        return $this->uRI;
    }

    /**
     * Sets a new uRI
     *
     * @param string $uRI
     * @return self
     */
    public function setURI($uRI)
    {
        $this->uRI = $uRI;
        return $this;
    }

    /**
     * Gets as type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets a new type
     *
     * @param string $type
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Adds as transform
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform $transform
     */
    public function addToTransforms(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform $transform)
    {
        $this->transforms[] = $transform;
        return $this;
    }

    /**
     * isset transforms
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetTransforms($index)
    {
        return isset($this->transforms[$index]);
    }

    /**
     * unset transforms
     *
     * @param string|number $index
     * @return void
     */
    public function unsetTransforms($index)
    {
        unset($this->transforms[$index]);
    }

    /**
     * Gets as transforms
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform[]
     */
    public function getTransforms()
    {
        return $this->transforms;
    }

    /**
     * Sets a new transforms
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Transform[] $transforms
     * @return self
     */
    public function setTransforms(array $transforms)
    {
        $this->transforms = $transforms;
        return $this;
    }

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
    public function setDigestMethod($digestMethod)
    {
        $this->digestMethod = $digestMethod;
        return $this;
    }

    /**
     * Gets as digestValue
     *
     * @return DigestValue
     */
    public function getDigestValue()
    {
        return $this->digestValue;
    }

    /**
     * Sets a new digestValue
     *
     * @param DigestValue|CustomBase64BinaryType $digestValue
     * @return self
     */
    public function setDigestValue($digestValue)
    {
        $this->digestValue = $digestValue;
        return $this;
    }


}

