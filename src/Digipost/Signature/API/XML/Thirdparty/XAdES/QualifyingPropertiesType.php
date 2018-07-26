<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing QualifyingPropertiesType
 *
 *
 * XSD Type: QualifyingPropertiesType
 */
class QualifyingPropertiesType
{

    /**
     * @property string $target
     */
    private $target = null;

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\SignedPropertiesType $signedProperties
     */
    private $signedProperties = null;

    /**
     * @property \Digipost\Signature\API\XML\Thirdparty\XAdES\UnsignedPropertiesType $unsignedProperties
     */
    private $unsignedProperties = null;

    /**
     * Gets as target
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Sets a new target
     *
     * @param string $target
     * @return self
     */
    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }

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
     * Gets as signedProperties
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\SignedPropertiesType
     */
    public function getSignedProperties()
    {
        return $this->signedProperties;
    }

    /**
     * Sets a new signedProperties
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\SignedPropertiesType $signedProperties
     * @return self
     */
    public function setSignedProperties(\Digipost\Signature\API\XML\Thirdparty\XAdES\SignedPropertiesType $signedProperties)
    {
        $this->signedProperties = $signedProperties;
        return $this;
    }

    /**
     * Gets as unsignedProperties
     *
     * @return \Digipost\Signature\API\XML\Thirdparty\XAdES\UnsignedPropertiesType
     */
    public function getUnsignedProperties()
    {
        return $this->unsignedProperties;
    }

    /**
     * Sets a new unsignedProperties
     *
     * @param \Digipost\Signature\API\XML\Thirdparty\XAdES\UnsignedPropertiesType $unsignedProperties
     * @return self
     */
    public function setUnsignedProperties(\Digipost\Signature\API\XML\Thirdparty\XAdES\UnsignedPropertiesType $unsignedProperties)
    {
        $this->unsignedProperties = $unsignedProperties;
        return $this;
    }


}

