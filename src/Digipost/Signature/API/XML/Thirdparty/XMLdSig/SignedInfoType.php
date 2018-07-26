<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

/**
 * Class representing SignedInfoType
 *
 *
 * XSD Type: SignedInfoType
 */
class SignedInfoType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\CanonicalizationMethod $canonicalizationMethod
     */
    private $canonicalizationMethod = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureMethod $signatureMethod
     */
    private $signatureMethod = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Reference[] $reference
     */
    private $reference = array(
        
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
     * Gets as canonicalizationMethod
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\CanonicalizationMethod
     */
    public function getCanonicalizationMethod()
    {
        return $this->canonicalizationMethod;
    }

    /**
     * Sets a new canonicalizationMethod
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\CanonicalizationMethod $canonicalizationMethod
     * @return self
     */
    public function setCanonicalizationMethod(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\CanonicalizationMethod $canonicalizationMethod)
    {
        $this->canonicalizationMethod = $canonicalizationMethod;
        return $this;
    }

    /**
     * Gets as signatureMethod
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureMethod
     */
    public function getSignatureMethod()
    {
        return $this->signatureMethod;
    }

    /**
     * Sets a new signatureMethod
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureMethod $signatureMethod
     * @return self
     */
    public function setSignatureMethod(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\SignatureMethod $signatureMethod)
    {
        $this->signatureMethod = $signatureMethod;
        return $this;
    }

    /**
     * Adds as reference
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Reference $reference
     */
    public function addToReference(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\Reference $reference)
    {
        $this->reference[] = $reference;
        return $this;
    }

    /**
     * isset reference
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetReference($index)
    {
        return isset($this->reference[$index]);
    }

    /**
     * unset reference
     *
     * @param scalar $index
     * @return void
     */
    public function unsetReference($index)
    {
        unset($this->reference[$index]);
    }

    /**
     * Gets as reference
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Reference[]
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Sets a new reference
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\Reference[] $reference
     * @return self
     */
    public function setReference(array $reference)
    {
        $this->reference = $reference;
        return $this;
    }


}

