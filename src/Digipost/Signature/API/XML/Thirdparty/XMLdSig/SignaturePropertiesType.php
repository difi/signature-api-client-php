<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

/**
 * Class representing SignaturePropertiesType
 *
 *
 * XSD Type: SignaturePropertiesType
 */
class SignaturePropertiesType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureProperty[] $signatureProperty
     */
    private $signatureProperty = array(
        
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
     * Adds as signatureProperty
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureProperty $signatureProperty
     */
    public function addToSignatureProperty(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureProperty $signatureProperty)
    {
        $this->signatureProperty[] = $signatureProperty;
        return $this;
    }

    /**
     * isset signatureProperty
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSignatureProperty($index)
    {
        return isset($this->signatureProperty[$index]);
    }

    /**
     * unset signatureProperty
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSignatureProperty($index)
    {
        unset($this->signatureProperty[$index]);
    }

    /**
     * Gets as signatureProperty
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureProperty[]
     */
    public function getSignatureProperty()
    {
        return $this->signatureProperty;
    }

    /**
     * Sets a new signatureProperty
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureProperty[] $signatureProperty
     * @return self
     */
    public function setSignatureProperty(array $signatureProperty)
    {
        $this->signatureProperty = $signatureProperty;
        return $this;
    }


}

