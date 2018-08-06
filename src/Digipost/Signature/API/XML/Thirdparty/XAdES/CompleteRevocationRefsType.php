<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing CompleteRevocationRefsType
 *
 *
 * XSD Type: CompleteRevocationRefsType
 */
class CompleteRevocationRefsType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\CRLRefType[] $cRLRefs
     */
    private $cRLRefs = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\OCSPRefType[] $oCSPRefs
     */
    private $oCSPRefs = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[] $otherRefs
     */
    private $otherRefs = null;

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
     * Adds as cRLRef
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CRLRefType $cRLRef
     */
    public function addToCRLRefs(\Digipost\Signature\API\XML\Thirdparty\XAdES\CRLRefType $cRLRef)
    {
        $this->cRLRefs[] = $cRLRef;
        return $this;
    }

    /**
     * isset cRLRefs
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetCRLRefs($index)
    {
        return isset($this->cRLRefs[$index]);
    }

    /**
     * unset cRLRefs
     *
     * @param string|number $index
     * @return void
     */
    public function unsetCRLRefs($index)
    {
        unset($this->cRLRefs[$index]);
    }

    /**
     * Gets as cRLRefs
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\CRLRefType[]
     */
    public function getCRLRefs()
    {
        return $this->cRLRefs;
    }

    /**
     * Sets a new cRLRefs
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\CRLRefType[] $cRLRefs
     * @return self
     */
    public function setCRLRefs(array $cRLRefs)
    {
        $this->cRLRefs = $cRLRefs;
        return $this;
    }

    /**
     * Adds as oCSPRef
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\OCSPRefType $oCSPRef
     */
    public function addToOCSPRefs(\Digipost\Signature\API\XML\Thirdparty\XAdES\OCSPRefType $oCSPRef)
    {
        $this->oCSPRefs[] = $oCSPRef;
        return $this;
    }

    /**
     * isset oCSPRefs
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetOCSPRefs($index)
    {
        return isset($this->oCSPRefs[$index]);
    }

    /**
     * unset oCSPRefs
     *
     * @param string|number $index
     * @return void
     */
    public function unsetOCSPRefs($index)
    {
        unset($this->oCSPRefs[$index]);
    }

    /**
     * Gets as oCSPRefs
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\OCSPRefType[]
     */
    public function getOCSPRefs()
    {
        return $this->oCSPRefs;
    }

    /**
     * Sets a new oCSPRefs
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\OCSPRefType[] $oCSPRefs
     * @return self
     */
    public function setOCSPRefs(array $oCSPRefs)
    {
        $this->oCSPRefs = $oCSPRefs;
        return $this;
    }

    /**
     * Adds as otherRef
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType $otherRef
     */
    public function addToOtherRefs(\Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType $otherRef)
    {
        $this->otherRefs[] = $otherRef;
        return $this;
    }

    /**
     * isset otherRefs
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetOtherRefs($index)
    {
        return isset($this->otherRefs[$index]);
    }

    /**
     * unset otherRefs
     *
     * @param string|number $index
     * @return void
     */
    public function unsetOtherRefs($index)
    {
        unset($this->otherRefs[$index]);
    }

    /**
     * Gets as otherRefs
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[]
     */
    public function getOtherRefs()
    {
        return $this->otherRefs;
    }

    /**
     * Sets a new otherRefs
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[] $otherRefs
     * @return self
     */
    public function setOtherRefs(array $otherRefs)
    {
        $this->otherRefs = $otherRefs;
        return $this;
    }


}

