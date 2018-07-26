<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing CommitmentTypeIndicationType
 *
 *
 * XSD Type: CommitmentTypeIndicationType
 */
class CommitmentTypeIndicationType
{

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\ObjectIdentifierType $commitmentTypeId
     */
    private $commitmentTypeId = null;

    /**
     * @property string[] $objectReference
     */
    private $objectReference = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\AnyType $allSignedDataObjects
     */
    private $allSignedDataObjects = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[] $commitmentTypeQualifiers
     */
    private $commitmentTypeQualifiers = null;

    /**
     * Gets as commitmentTypeId
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\ObjectIdentifierType
     */
    public function getCommitmentTypeId()
    {
        return $this->commitmentTypeId;
    }

    /**
     * Sets a new commitmentTypeId
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\ObjectIdentifierType $commitmentTypeId
     * @return self
     */
    public function setCommitmentTypeId(\Digipost\Signature\API\XML\Thirdparty\XAdES\ObjectIdentifierType $commitmentTypeId)
    {
        $this->commitmentTypeId = $commitmentTypeId;
        return $this;
    }

    /**
     * Adds as objectReference
     *
     * @return self
     * @param string $objectReference
     */
    public function addToObjectReference($objectReference)
    {
        $this->objectReference[] = $objectReference;
        return $this;
    }

    /**
     * isset objectReference
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetObjectReference($index)
    {
        return isset($this->objectReference[$index]);
    }

    /**
     * unset objectReference
     *
     * @param scalar $index
     * @return void
     */
    public function unsetObjectReference($index)
    {
        unset($this->objectReference[$index]);
    }

    /**
     * Gets as objectReference
     *
     * @return string[]
     */
    public function getObjectReference()
    {
        return $this->objectReference;
    }

    /**
     * Sets a new objectReference
     *
     * @param string[] $objectReference
     * @return self
     */
    public function setObjectReference(array $objectReference)
    {
        $this->objectReference = $objectReference;
        return $this;
    }

    /**
     * Gets as allSignedDataObjects
     *
     * @return \Digipost\Signature\API\XML\AnyType
     */
    public function getAllSignedDataObjects()
    {
        return $this->allSignedDataObjects;
    }

    /**
     * Sets a new allSignedDataObjects
     *
     * @param \Digipost\Signature\API\XML\AnyType $allSignedDataObjects
     * @return self
     */
    public function setAllSignedDataObjects(\Digipost\Signature\API\XML\AnyType $allSignedDataObjects)
    {
        $this->allSignedDataObjects = $allSignedDataObjects;
        return $this;
    }

    /**
     * Adds as commitmentTypeQualifier
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType $commitmentTypeQualifier
     */
    public function addToCommitmentTypeQualifiers(\Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType $commitmentTypeQualifier)
    {
        $this->commitmentTypeQualifiers[] = $commitmentTypeQualifier;
        return $this;
    }

    /**
     * isset commitmentTypeQualifiers
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetCommitmentTypeQualifiers($index)
    {
        return isset($this->commitmentTypeQualifiers[$index]);
    }

    /**
     * unset commitmentTypeQualifiers
     *
     * @param scalar $index
     * @return void
     */
    public function unsetCommitmentTypeQualifiers($index)
    {
        unset($this->commitmentTypeQualifiers[$index]);
    }

    /**
     * Gets as commitmentTypeQualifiers
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[]
     */
    public function getCommitmentTypeQualifiers()
    {
        return $this->commitmentTypeQualifiers;
    }

    /**
     * Sets a new commitmentTypeQualifiers
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[] $commitmentTypeQualifiers
     * @return self
     */
    public function setCommitmentTypeQualifiers(array $commitmentTypeQualifiers)
    {
        $this->commitmentTypeQualifiers = $commitmentTypeQualifiers;
        return $this;
    }


}

