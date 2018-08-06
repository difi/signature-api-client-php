<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing RevocationValuesType
 *
 *
 * XSD Type: RevocationValuesType
 */
class RevocationValuesType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType[] $cRLValues
     */
    private $cRLValues = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType[] $oCSPValues
     */
    private $oCSPValues = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[] $otherValues
     */
    private $otherValues = null;

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
     * Adds as encapsulatedCRLValue
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType $encapsulatedCRLValue
     */
    public function addToCRLValues(\Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType $encapsulatedCRLValue)
    {
        $this->cRLValues[] = $encapsulatedCRLValue;
        return $this;
    }

    /**
     * isset cRLValues
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetCRLValues($index)
    {
        return isset($this->cRLValues[$index]);
    }

    /**
     * unset cRLValues
     *
     * @param string|number $index
     * @return void
     */
    public function unsetCRLValues($index)
    {
        unset($this->cRLValues[$index]);
    }

    /**
     * Gets as cRLValues
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType[]
     */
    public function getCRLValues()
    {
        return $this->cRLValues;
    }

    /**
     * Sets a new cRLValues
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType[] $cRLValues
     * @return self
     */
    public function setCRLValues(array $cRLValues)
    {
        $this->cRLValues = $cRLValues;
        return $this;
    }

    /**
     * Adds as encapsulatedOCSPValue
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType $encapsulatedOCSPValue
     */
    public function addToOCSPValues(\Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType $encapsulatedOCSPValue)
    {
        $this->oCSPValues[] = $encapsulatedOCSPValue;
        return $this;
    }

    /**
     * isset oCSPValues
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetOCSPValues($index)
    {
        return isset($this->oCSPValues[$index]);
    }

    /**
     * unset oCSPValues
     *
     * @param string|number $index
     * @return void
     */
    public function unsetOCSPValues($index)
    {
        unset($this->oCSPValues[$index]);
    }

    /**
     * Gets as oCSPValues
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType[]
     */
    public function getOCSPValues()
    {
        return $this->oCSPValues;
    }

    /**
     * Sets a new oCSPValues
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\EncapsulatedPKIDataType[] $oCSPValues
     * @return self
     */
    public function setOCSPValues(array $oCSPValues)
    {
        $this->oCSPValues = $oCSPValues;
        return $this;
    }

    /**
     * Adds as otherValue
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType $otherValue
     */
    public function addToOtherValues(\Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType $otherValue)
    {
        $this->otherValues[] = $otherValue;
        return $this;
    }

    /**
     * isset otherValues
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetOtherValues($index)
    {
        return isset($this->otherValues[$index]);
    }

    /**
     * unset otherValues
     *
     * @param string|number $index
     * @return void
     */
    public function unsetOtherValues($index)
    {
        unset($this->otherValues[$index]);
    }

    /**
     * Gets as otherValues
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[]
     */
    public function getOtherValues()
    {
        return $this->otherValues;
    }

    /**
     * Sets a new otherValues
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[] $otherValues
     * @return self
     */
    public function setOtherValues(array $otherValues)
    {
        $this->otherValues = $otherValues;
        return $this;
    }


}

