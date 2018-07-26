<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing UnsignedPropertiesType
 *
 *
 * XSD Type: UnsignedPropertiesType
 */
class UnsignedPropertiesType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\UnsignedSignaturePropertiesType $unsignedSignatureProperties
     */
    private $unsignedSignatureProperties = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\UnsignedDataObjectPropertiesType $unsignedDataObjectProperties
     */
    private $unsignedDataObjectProperties = null;

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
     * Gets as unsignedSignatureProperties
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\UnsignedSignaturePropertiesType
     */
    public function getUnsignedSignatureProperties()
    {
        return $this->unsignedSignatureProperties;
    }

    /**
     * Sets a new unsignedSignatureProperties
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\UnsignedSignaturePropertiesType $unsignedSignatureProperties
     * @return self
     */
    public function setUnsignedSignatureProperties(\Digipost\Signature\API\XML\Thirdparty\XAdES\UnsignedSignaturePropertiesType $unsignedSignatureProperties)
    {
        $this->unsignedSignatureProperties = $unsignedSignatureProperties;
        return $this;
    }

    /**
     * Gets as unsignedDataObjectProperties
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\UnsignedDataObjectPropertiesType
     */
    public function getUnsignedDataObjectProperties()
    {
        return $this->unsignedDataObjectProperties;
    }

    /**
     * Sets a new unsignedDataObjectProperties
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\UnsignedDataObjectPropertiesType $unsignedDataObjectProperties
     * @return self
     */
    public function setUnsignedDataObjectProperties(\Digipost\Signature\API\XML\Thirdparty\XAdES\UnsignedDataObjectPropertiesType $unsignedDataObjectProperties)
    {
        $this->unsignedDataObjectProperties = $unsignedDataObjectProperties;
        return $this;
    }


}

