<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

/**
 * Class representing KeyInfoType
 *
 *
 * XSD Type: KeyInfoType
 */
class KeyInfoType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property string[] $keyName
     */
    private $keyName = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\KeyValue[] $keyValue
     */
    private $keyValue = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\RetrievalMethod[] $retrievalMethod
     */
    private $retrievalMethod = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\X509Data[] $x509Data
     */
    private $x509Data = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\PGPData[] $pGPData
     */
    private $pGPData = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType[] $sPKIData
     */
    private $sPKIData = null;

    /**
     * @property string[] $mgmtData
     */
    private $mgmtData = array(
        
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
     * Adds as keyName
     *
     * @return self
     * @param string $keyName
     */
    public function addToKeyName($keyName)
    {
        $this->keyName[] = $keyName;
        return $this;
    }

    /**
     * isset keyName
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetKeyName($index)
    {
        return isset($this->keyName[$index]);
    }

    /**
     * unset keyName
     *
     * @param string|number $index
     * @return void
     */
    public function unsetKeyName($index)
    {
        unset($this->keyName[$index]);
    }

    /**
     * Gets as keyName
     *
     * @return string[]
     */
    public function getKeyName()
    {
        return $this->keyName;
    }

    /**
     * Sets a new keyName
     *
     * @param string $keyName
     * @return self
     */
    public function setKeyName(array $keyName)
    {
        $this->keyName = $keyName;
        return $this;
    }

    /**
     * Adds as keyValue
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\KeyValue $keyValue
     */
    public function addToKeyValue(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\KeyValue $keyValue)
    {
        $this->keyValue[] = $keyValue;
        return $this;
    }

    /**
     * isset keyValue
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetKeyValue($index)
    {
        return isset($this->keyValue[$index]);
    }

    /**
     * unset keyValue
     *
     * @param string|number $index
     * @return void
     */
    public function unsetKeyValue($index)
    {
        unset($this->keyValue[$index]);
    }

    /**
     * Gets as keyValue
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\KeyValue[]
     */
    public function getKeyValue()
    {
        return $this->keyValue;
    }

    /**
     * Sets a new keyValue
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\KeyValue[] $keyValue
     * @return self
     */
    public function setKeyValue(array $keyValue)
    {
        $this->keyValue = $keyValue;
        return $this;
    }

    /**
     * Adds as retrievalMethod
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\RetrievalMethod $retrievalMethod
     */
    public function addToRetrievalMethod(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\RetrievalMethod $retrievalMethod)
    {
        $this->retrievalMethod[] = $retrievalMethod;
        return $this;
    }

    /**
     * isset retrievalMethod
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetRetrievalMethod($index)
    {
        return isset($this->retrievalMethod[$index]);
    }

    /**
     * unset retrievalMethod
     *
     * @param string|number $index
     * @return void
     */
    public function unsetRetrievalMethod($index)
    {
        unset($this->retrievalMethod[$index]);
    }

    /**
     * Gets as retrievalMethod
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\RetrievalMethod[]
     */
    public function getRetrievalMethod()
    {
        return $this->retrievalMethod;
    }

    /**
     * Sets a new retrievalMethod
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\RetrievalMethod[] $retrievalMethod
     * @return self
     */
    public function setRetrievalMethod(array $retrievalMethod)
    {
        $this->retrievalMethod = $retrievalMethod;
        return $this;
    }

    /**
     * Adds as x509Data
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\X509Data $x509Data
     */
    public function addToX509Data(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\X509Data $x509Data)
    {
        $this->x509Data[] = $x509Data;
        return $this;
    }

    /**
     * isset x509Data
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetX509Data($index)
    {
        return isset($this->x509Data[$index]);
    }

    /**
     * unset x509Data
     *
     * @param string|number $index
     * @return void
     */
    public function unsetX509Data($index)
    {
        unset($this->x509Data[$index]);
    }

    /**
     * Gets as x509Data
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\X509Data[]
     */
    public function getX509Data()
    {
        return $this->x509Data;
    }

    /**
     * Sets a new x509Data
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\X509Data[] $x509Data
     * @return self
     */
    public function setX509Data(array $x509Data)
    {
        $this->x509Data = $x509Data;
        return $this;
    }

    /**
     * Adds as pGPData
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\PGPData $pGPData
     */
    public function addToPGPData(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\PGPData $pGPData)
    {
        $this->pGPData[] = $pGPData;
        return $this;
    }

    /**
     * isset pGPData
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetPGPData($index)
    {
        return isset($this->pGPData[$index]);
    }

    /**
     * unset pGPData
     *
     * @param string|number $index
     * @return void
     */
    public function unsetPGPData($index)
    {
        unset($this->pGPData[$index]);
    }

    /**
     * Gets as pGPData
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\PGPData[]
     */
    public function getPGPData()
    {
        return $this->pGPData;
    }

    /**
     * Sets a new pGPData
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\PGPData[] $pGPData
     * @return self
     */
    public function setPGPData(array $pGPData)
    {
        $this->pGPData = $pGPData;
        return $this;
    }

    /**
     * Adds as sPKISexp
     *
     * @return self
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $sPKISexp
     */
    public function addToSPKIData(\Digipost\Signature\API\XML\CustomBase64BinaryType $sPKISexp)
    {
        $this->sPKIData[] = $sPKISexp;
        return $this;
    }

    /**
     * isset sPKIData
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetSPKIData($index)
    {
        return isset($this->sPKIData[$index]);
    }

    /**
     * unset sPKIData
     *
     * @param string|number $index
     * @return void
     */
    public function unsetSPKIData($index)
    {
        unset($this->sPKIData[$index]);
    }

    /**
     * Gets as sPKIData
     *
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType[]
     */
    public function getSPKIData()
    {
        return $this->sPKIData;
    }

    /**
     * Sets a new sPKIData
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType[] $sPKIData
     * @return self
     */
    public function setSPKIData(array $sPKIData)
    {
        $this->sPKIData = $sPKIData;
        return $this;
    }

    /**
     * Adds as mgmtData
     *
     * @return self
     * @param string $mgmtData
     */
    public function addToMgmtData($mgmtData)
    {
        $this->mgmtData[] = $mgmtData;
        return $this;
    }

    /**
     * isset mgmtData
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetMgmtData($index)
    {
        return isset($this->mgmtData[$index]);
    }

    /**
     * unset mgmtData
     *
     * @param string|number $index
     * @return void
     */
    public function unsetMgmtData($index)
    {
        unset($this->mgmtData[$index]);
    }

    /**
     * Gets as mgmtData
     *
     * @return string[]
     */
    public function getMgmtData()
    {
        return $this->mgmtData;
    }

    /**
     * Sets a new mgmtData
     *
     * @param string $mgmtData
     * @return self
     */
    public function setMgmtData(array $mgmtData)
    {
        $this->mgmtData = $mgmtData;
        return $this;
    }


}

