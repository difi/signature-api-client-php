<?php

namespace Digipost\Signature\API\XML\Thirdparty\ASiCe;

/**
 * Class representing DataObjectReferenceType
 *
 *
 * XSD Type: DataObjectReferenceType
 */
class DataObjectReferenceType
{

    /**
     * @property string $uRI
     */
    private $uRI = null;

    /**
     * @property string $mimeType
     */
    private $mimeType = null;

    /**
     * @property boolean $rootfile
     */
    private $rootfile = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod $digestMethod
     */
    private $digestMethod = null;

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $digestValue
     */
    private $digestValue = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\ASiCe\Extension[] $dataObjectReferenceExtensions
     */
    private $dataObjectReferenceExtensions = null;

    /**
     * Gets as uRI
     *
     * @return string
     */
    public function getURI()
    {
        return $this->uRI;
    }

    /**
     * Sets a new uRI
     *
     * @param string $uRI
     * @return self
     */
    public function setURI($uRI)
    {
        $this->uRI = $uRI;
        return $this;
    }

    /**
     * Gets as mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Sets a new mimeType
     *
     * @param string $mimeType
     * @return self
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
        return $this;
    }

    /**
     * Gets as rootfile
     *
     * @return boolean
     */
    public function getRootfile()
    {
        return $this->rootfile;
    }

    /**
     * Sets a new rootfile
     *
     * @param boolean $rootfile
     * @return self
     */
    public function setRootfile($rootfile)
    {
        $this->rootfile = $rootfile;
        return $this;
    }

    /**
     * Gets as digestMethod
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod
     */
    public function getDigestMethod()
    {
        return $this->digestMethod;
    }

    /**
     * Sets a new digestMethod
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod $digestMethod
     * @return self
     */
    public function setDigestMethod(\Digipost\Signature\API\XML\Thirdparty\XMLdSig\DigestMethod $digestMethod)
    {
        $this->digestMethod = $digestMethod;
        return $this;
    }

    /**
     * Gets as digestValue
     *
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType
     */
    public function getDigestValue()
    {
        return $this->digestValue;
    }

    /**
     * Sets a new digestValue
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $digestValue
     * @return self
     */
    public function setDigestValue(\Digipost\Signature\API\XML\CustomBase64BinaryType $digestValue)
    {
        $this->digestValue = $digestValue;
        return $this;
    }

    /**
     * Adds as extension
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\ASiCe\Extension $extension
     */
    public function addToDataObjectReferenceExtensions(\Digipost\Signature\API\XML\Thirdparty\ASiCe\Extension $extension)
    {
        $this->dataObjectReferenceExtensions[] = $extension;
        return $this;
    }

    /**
     * isset dataObjectReferenceExtensions
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetDataObjectReferenceExtensions($index)
    {
        return isset($this->dataObjectReferenceExtensions[$index]);
    }

    /**
     * unset dataObjectReferenceExtensions
     *
     * @param scalar $index
     * @return void
     */
    public function unsetDataObjectReferenceExtensions($index)
    {
        unset($this->dataObjectReferenceExtensions[$index]);
    }

    /**
     * Gets as dataObjectReferenceExtensions
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\ASiCe\Extension[]
     */
    public function getDataObjectReferenceExtensions()
    {
        return $this->dataObjectReferenceExtensions;
    }

    /**
     * Sets a new dataObjectReferenceExtensions
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\ASiCe\Extension[] $dataObjectReferenceExtensions
     * @return self
     */
    public function setDataObjectReferenceExtensions(array $dataObjectReferenceExtensions)
    {
        $this->dataObjectReferenceExtensions = $dataObjectReferenceExtensions;
        return $this;
    }


}

