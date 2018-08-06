<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

/**
 * Class representing SignatureType
 *
 *
 * XSD Type: SignatureType
 */
class SignatureType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignedInfo $signedInfo
     */
    private $signedInfo = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureValue $signatureValue
     */
    private $signatureValue = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\KeyInfo $keyInfo
     */
    private $keyInfo = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\ObjectXsd[] $object
     */
    private $object = array(
        
    );

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
     * Gets as signedInfo
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignedInfo
     */
    public function getSignedInfo()
    {
        return $this->signedInfo;
    }

    /**
     * Sets a new signedInfo
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignedInfo $signedInfo
     * @return self
     */
    public function setSignedInfo(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignedInfo $signedInfo)
    {
        $this->signedInfo = $signedInfo;
        return $this;
    }

    /**
     * Gets as signatureValue
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureValue
     */
    public function getSignatureValue()
    {
        return $this->signatureValue;
    }

    /**
     * Sets a new signatureValue
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureValue $signatureValue
     * @return self
     */
    public function setSignatureValue(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureValue $signatureValue)
    {
        $this->signatureValue = $signatureValue;
        return $this;
    }

    /**
     * Gets as keyInfo
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\KeyInfo
     */
    public function getKeyInfo()
    {
        return $this->keyInfo;
    }

    /**
     * Sets a new keyInfo
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\KeyInfo $keyInfo
     * @return self
     */
    public function setKeyInfo(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\KeyInfo $keyInfo)
    {
        $this->keyInfo = $keyInfo;
        return $this;
    }

    /**
     * Adds as object
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\ObjectXsd $object
     */
    public function addToObject(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\ObjectXsd $object)
    {
        $this->object[] = $object;
        return $this;
    }

    /**
     * isset object
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetObject($index)
    {
        return isset($this->object[$index]);
    }

    /**
     * unset object
     *
     * @param string|number $index
     * @return void
     */
    public function unsetObject($index)
    {
        unset($this->object[$index]);
    }

    /**
     * Gets as object
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\ObjectXsd[]
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Sets a new object
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\ObjectXsd[] $object
     * @return self
     */
    public function setObject(array $object)
    {
        $this->object = $object;
        return $this;
    }


}

