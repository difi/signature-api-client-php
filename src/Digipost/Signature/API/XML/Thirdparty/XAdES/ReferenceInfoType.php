<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing ReferenceInfoType
 *
 *
 * XSD Type: ReferenceInfoType
 */
class ReferenceInfoType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property string $uRI
     */
    private $uRI = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod $digestMethod
     */
    private $digestMethod = null;

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $digestValue
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
    public function setDigestValue(\Digipost\Signature\API\XML\CustomBase64BinaryType $digestValue)
    {
        $this->digestValue = $digestValue;
        return $this;
    }


}

