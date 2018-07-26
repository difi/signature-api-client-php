<?php

namespace Digipost\Signature\API\XML\Thirdparty\ASiCe;

/**
 * Class representing ASiCManifestType
 *
 *
 * XSD Type: ASiCManifestType
 */
class ASiCManifestType
{

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\ASiCe\SigReference $sigReference
     */
    private $sigReference = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\ASiCe\DataObjectReference[] $dataObjectReference
     */
    private $dataObjectReference = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\ASiCe\Extension[] $aSiCManifestExtensions
     */
    private $aSiCManifestExtensions = null;

    /**
     * Gets as sigReference
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\ASiCe\SigReference
     */
    public function getSigReference()
    {
        return $this->sigReference;
    }

    /**
     * Sets a new sigReference
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\ASiCe\SigReference $sigReference
     * @return self
     */
    public function setSigReference(\Digipost\Signature\API\XML\Thirdparty\ASiCe\SigReference $sigReference)
    {
        $this->sigReference = $sigReference;
        return $this;
    }

    /**
     * Adds as dataObjectReference
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\ASiCe\DataObjectReference $dataObjectReference
     */
    public function addToDataObjectReference(\Digipost\Signature\API\XML\Thirdparty\ASiCe\DataObjectReference $dataObjectReference)
    {
        $this->dataObjectReference[] = $dataObjectReference;
        return $this;
    }

    /**
     * isset dataObjectReference
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetDataObjectReference($index)
    {
        return isset($this->dataObjectReference[$index]);
    }

    /**
     * unset dataObjectReference
     *
     * @param scalar $index
     * @return void
     */
    public function unsetDataObjectReference($index)
    {
        unset($this->dataObjectReference[$index]);
    }

    /**
     * Gets as dataObjectReference
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\ASiCe\DataObjectReference[]
     */
    public function getDataObjectReference()
    {
        return $this->dataObjectReference;
    }

    /**
     * Sets a new dataObjectReference
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\ASiCe\DataObjectReference[] $dataObjectReference
     * @return self
     */
    public function setDataObjectReference(array $dataObjectReference)
    {
        $this->dataObjectReference = $dataObjectReference;
        return $this;
    }

    /**
     * Adds as extension
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\ASiCe\Extension $extension
     */
    public function addToASiCManifestExtensions(\Digipost\Signature\API\XML\Thirdparty\ASiCe\Extension $extension)
    {
        $this->aSiCManifestExtensions[] = $extension;
        return $this;
    }

    /**
     * isset aSiCManifestExtensions
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetASiCManifestExtensions($index)
    {
        return isset($this->aSiCManifestExtensions[$index]);
    }

    /**
     * unset aSiCManifestExtensions
     *
     * @param scalar $index
     * @return void
     */
    public function unsetASiCManifestExtensions($index)
    {
        unset($this->aSiCManifestExtensions[$index]);
    }

    /**
     * Gets as aSiCManifestExtensions
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\ASiCe\Extension[]
     */
    public function getASiCManifestExtensions()
    {
        return $this->aSiCManifestExtensions;
    }

    /**
     * Sets a new aSiCManifestExtensions
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\ASiCe\Extension[] $aSiCManifestExtensions
     * @return self
     */
    public function setASiCManifestExtensions(array $aSiCManifestExtensions)
    {
        $this->aSiCManifestExtensions = $aSiCManifestExtensions;
        return $this;
    }


}

