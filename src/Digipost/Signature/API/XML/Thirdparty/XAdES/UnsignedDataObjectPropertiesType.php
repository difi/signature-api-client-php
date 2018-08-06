<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing UnsignedDataObjectPropertiesType
 *
 *
 * XSD Type: UnsignedDataObjectPropertiesType
 */
class UnsignedDataObjectPropertiesType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[] $unsignedDataObjectProperty
     */
    private $unsignedDataObjectProperty = array(
        
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
     * Adds as unsignedDataObjectProperty
     *
     * @return self
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType $unsignedDataObjectProperty
     */
    public function addToUnsignedDataObjectProperty(\Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType $unsignedDataObjectProperty)
    {
        $this->unsignedDataObjectProperty[] = $unsignedDataObjectProperty;
        return $this;
    }

    /**
     * isset unsignedDataObjectProperty
     *
     * @param string|number $index
     * @return boolean
     */
    public function issetUnsignedDataObjectProperty($index)
    {
        return isset($this->unsignedDataObjectProperty[$index]);
    }

    /**
     * unset unsignedDataObjectProperty
     *
     * @param string|number $index
     * @return void
     */
    public function unsetUnsignedDataObjectProperty($index)
    {
        unset($this->unsignedDataObjectProperty[$index]);
    }

    /**
     * Gets as unsignedDataObjectProperty
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[]
     */
    public function getUnsignedDataObjectProperty()
    {
        return $this->unsignedDataObjectProperty;
    }

    /**
     * Sets a new unsignedDataObjectProperty
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\AnyType[] $unsignedDataObjectProperty
     * @return self
     */
    public function setUnsignedDataObjectProperty(array $unsignedDataObjectProperty)
    {
        $this->unsignedDataObjectProperty = $unsignedDataObjectProperty;
        return $this;
    }


}

