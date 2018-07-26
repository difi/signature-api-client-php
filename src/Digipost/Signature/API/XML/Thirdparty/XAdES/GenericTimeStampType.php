<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing GenericTimeStampType
 *
 *
 * XSD Type: GenericTimeStampType
 */
class GenericTimeStampType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\IncludeXsd[] $include
     */
    private $include = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\ReferenceInfo[] $referenceInfo
     */
    private $referenceInfo = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\CanonicalizationMethod $canonicalizationMethod
     */
    private $canonicalizationMethod = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType[] $encapsulatedTimeStamp
     */
    private $encapsulatedTimeStamp = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[] $xMLTimeStamp
     */
    private $xMLTimeStamp = array(
        
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
     * Adds as include
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\IncludeXsd $include
     */
    public function addToInclude(\Digipost\Signature\API\XML\Thirdparty\XAdES\IncludeXsd $include)
    {
        $this->include[] = $include;
        return $this;
    }

    /**
     * isset include
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetInclude($index)
    {
        return isset($this->include[$index]);
    }

    /**
     * unset include
     *
     * @param scalar $index
     * @return void
     */
    public function unsetInclude($index)
    {
        unset($this->include[$index]);
    }

    /**
     * Gets as include
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\IncludeXsd[]
     */
    public function getInclude()
    {
        return $this->include;
    }

    /**
     * Sets a new include
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\IncludeXsd[] $include
     * @return self
     */
    public function setInclude(array $include)
    {
        $this->include = $include;
        return $this;
    }

    /**
     * Adds as referenceInfo
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\ReferenceInfo $referenceInfo
     */
    public function addToReferenceInfo(\Digipost\Signature\API\XML\Thirdparty\XAdES\ReferenceInfo $referenceInfo)
    {
        $this->referenceInfo[] = $referenceInfo;
        return $this;
    }

    /**
     * isset referenceInfo
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetReferenceInfo($index)
    {
        return isset($this->referenceInfo[$index]);
    }

    /**
     * unset referenceInfo
     *
     * @param scalar $index
     * @return void
     */
    public function unsetReferenceInfo($index)
    {
        unset($this->referenceInfo[$index]);
    }

    /**
     * Gets as referenceInfo
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\ReferenceInfo[]
     */
    public function getReferenceInfo()
    {
        return $this->referenceInfo;
    }

    /**
     * Sets a new referenceInfo
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\ReferenceInfo[] $referenceInfo
     * @return self
     */
    public function setReferenceInfo(array $referenceInfo)
    {
        $this->referenceInfo = $referenceInfo;
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
     * Adds as encapsulatedTimeStamp
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType $encapsulatedTimeStamp
     */
    public function addToEncapsulatedTimeStamp(\Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType $encapsulatedTimeStamp)
    {
        $this->encapsulatedTimeStamp[] = $encapsulatedTimeStamp;
        return $this;
    }

    /**
     * isset encapsulatedTimeStamp
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetEncapsulatedTimeStamp($index)
    {
        return isset($this->encapsulatedTimeStamp[$index]);
    }

    /**
     * unset encapsulatedTimeStamp
     *
     * @param scalar $index
     * @return void
     */
    public function unsetEncapsulatedTimeStamp($index)
    {
        unset($this->encapsulatedTimeStamp[$index]);
    }

    /**
     * Gets as encapsulatedTimeStamp
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType[]
     */
    public function getEncapsulatedTimeStamp()
    {
        return $this->encapsulatedTimeStamp;
    }

    /**
     * Sets a new encapsulatedTimeStamp
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType[] $encapsulatedTimeStamp
     * @return self
     */
    public function setEncapsulatedTimeStamp(array $encapsulatedTimeStamp)
    {
        $this->encapsulatedTimeStamp = $encapsulatedTimeStamp;
        return $this;
    }

    /**
     * Adds as xMLTimeStamp
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType $xMLTimeStamp
     */
    public function addToXMLTimeStamp(\Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType $xMLTimeStamp)
    {
        $this->xMLTimeStamp[] = $xMLTimeStamp;
        return $this;
    }

    /**
     * isset xMLTimeStamp
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetXMLTimeStamp($index)
    {
        return isset($this->xMLTimeStamp[$index]);
    }

    /**
     * unset xMLTimeStamp
     *
     * @param scalar $index
     * @return void
     */
    public function unsetXMLTimeStamp($index)
    {
        unset($this->xMLTimeStamp[$index]);
    }

    /**
     * Gets as xMLTimeStamp
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[]
     */
    public function getXMLTimeStamp()
    {
        return $this->xMLTimeStamp;
    }

    /**
     * Sets a new xMLTimeStamp
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[] $xMLTimeStamp
     * @return self
     */
    public function setXMLTimeStamp(array $xMLTimeStamp)
    {
        $this->xMLTimeStamp = $xMLTimeStamp;
        return $this;
    }


}

