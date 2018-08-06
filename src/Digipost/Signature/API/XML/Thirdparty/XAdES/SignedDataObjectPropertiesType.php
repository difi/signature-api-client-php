<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing SignedDataObjectPropertiesType
 *
 *
 * XSD Type: SignedDataObjectPropertiesType
 */
class SignedDataObjectPropertiesType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\DataObjectFormatType[] $dataObjectFormat
     */
    private $dataObjectFormat = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\CommitmentTypeIndicationType[] $commitmentTypeIndication
     */
    private $commitmentTypeIndication = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[] $allDataObjectsTimeStamp
     */
    private $allDataObjectsTimeStamp = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[] $individualDataObjectsTimeStamp
     */
    private $individualDataObjectsTimeStamp = array(
        
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
     * Adds as dataObjectFormat
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\DataObjectFormatType $dataObjectFormat
     */
    public function addToDataObjectFormat(\Digipost\Signature\API\XML\Thirdparty\XAdES\DataObjectFormatType $dataObjectFormat)
    {
        $this->dataObjectFormat[] = $dataObjectFormat;
        return $this;
    }

    /**
     * isset dataObjectFormat
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetDataObjectFormat($index)
    {
        return isset($this->dataObjectFormat[$index]);
    }

    /**
     * unset dataObjectFormat
     *
     * @param string|number $index
     * @return void
     */
    public function unsetDataObjectFormat($index)
    {
        unset($this->dataObjectFormat[$index]);
    }

    /**
     * Gets as dataObjectFormat
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\DataObjectFormatType[]
     */
    public function getDataObjectFormat()
    {
        return $this->dataObjectFormat;
    }

    /**
     * Sets a new dataObjectFormat
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\DataObjectFormatType[] $dataObjectFormat
     * @return self
     */
    public function setDataObjectFormat(array $dataObjectFormat)
    {
        $this->dataObjectFormat = $dataObjectFormat;
        return $this;
    }

    /**
     * Adds as commitmentTypeIndication
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CommitmentTypeIndicationType $commitmentTypeIndication
     */
    public function addToCommitmentTypeIndication(\Digipost\Signature\API\XML\Thirdparty\XAdES\CommitmentTypeIndicationType $commitmentTypeIndication)
    {
        $this->commitmentTypeIndication[] = $commitmentTypeIndication;
        return $this;
    }

    /**
     * isset commitmentTypeIndication
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetCommitmentTypeIndication($index)
    {
        return isset($this->commitmentTypeIndication[$index]);
    }

    /**
     * unset commitmentTypeIndication
     *
     * @param string|number $index
     * @return void
     */
    public function unsetCommitmentTypeIndication($index)
    {
        unset($this->commitmentTypeIndication[$index]);
    }

    /**
     * Gets as commitmentTypeIndication
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\CommitmentTypeIndicationType[]
     */
    public function getCommitmentTypeIndication()
    {
        return $this->commitmentTypeIndication;
    }

    /**
     * Sets a new commitmentTypeIndication
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CommitmentTypeIndicationType[] $commitmentTypeIndication
     * @return self
     */
    public function setCommitmentTypeIndication(array $commitmentTypeIndication)
    {
        $this->commitmentTypeIndication = $commitmentTypeIndication;
        return $this;
    }

    /**
     * Adds as allDataObjectsTimeStamp
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType $allDataObjectsTimeStamp
     */
    public function addToAllDataObjectsTimeStamp(\Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType $allDataObjectsTimeStamp)
    {
        $this->allDataObjectsTimeStamp[] = $allDataObjectsTimeStamp;
        return $this;
    }

    /**
     * isset allDataObjectsTimeStamp
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetAllDataObjectsTimeStamp($index)
    {
        return isset($this->allDataObjectsTimeStamp[$index]);
    }

    /**
     * unset allDataObjectsTimeStamp
     *
     * @param string|number $index
     * @return void
     */
    public function unsetAllDataObjectsTimeStamp($index)
    {
        unset($this->allDataObjectsTimeStamp[$index]);
    }

    /**
     * Gets as allDataObjectsTimeStamp
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[]
     */
    public function getAllDataObjectsTimeStamp()
    {
        return $this->allDataObjectsTimeStamp;
    }

    /**
     * Sets a new allDataObjectsTimeStamp
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[] $allDataObjectsTimeStamp
     * @return self
     */
    public function setAllDataObjectsTimeStamp(array $allDataObjectsTimeStamp)
    {
        $this->allDataObjectsTimeStamp = $allDataObjectsTimeStamp;
        return $this;
    }

    /**
     * Adds as individualDataObjectsTimeStamp
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType $individualDataObjectsTimeStamp
     */
    public function addToIndividualDataObjectsTimeStamp(\Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType $individualDataObjectsTimeStamp)
    {
        $this->individualDataObjectsTimeStamp[] = $individualDataObjectsTimeStamp;
        return $this;
    }

    /**
     * isset individualDataObjectsTimeStamp
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetIndividualDataObjectsTimeStamp($index)
    {
        return isset($this->individualDataObjectsTimeStamp[$index]);
    }

    /**
     * unset individualDataObjectsTimeStamp
     *
     * @param string|number $index
     * @return void
     */
    public function unsetIndividualDataObjectsTimeStamp($index)
    {
        unset($this->individualDataObjectsTimeStamp[$index]);
    }

    /**
     * Gets as individualDataObjectsTimeStamp
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[]
     */
    public function getIndividualDataObjectsTimeStamp()
    {
        return $this->individualDataObjectsTimeStamp;
    }

    /**
     * Sets a new individualDataObjectsTimeStamp
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\XAdESTimeStampType[] $individualDataObjectsTimeStamp
     * @return self
     */
    public function setIndividualDataObjectsTimeStamp(array $individualDataObjectsTimeStamp)
    {
        $this->individualDataObjectsTimeStamp = $individualDataObjectsTimeStamp;
        return $this;
    }


}

