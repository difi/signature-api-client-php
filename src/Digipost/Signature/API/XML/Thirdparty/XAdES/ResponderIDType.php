<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing ResponderIDType
 *
 *
 * XSD Type: ResponderIDType
 */
class ResponderIDType
{

    /**
     * @property string $byName
     */
    private $byName = null;

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $byKey
     */
    private $byKey = null;

    /**
     * Gets as byName
     *
     * @return string
     */
    public function getByName()
    {
        return $this->byName;
    }

    /**
     * Sets a new byName
     *
     * @param string $byName
     * @return self
     */
    public function setByName($byName)
    {
        $this->byName = $byName;
        return $this;
    }

    /**
     * Gets as byKey
     *
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType
     */
    public function getByKey()
    {
        return $this->byKey;
    }

    /**
     * Sets a new byKey
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $byKey
     * @return self
     */
    public function setByKey(\Digipost\Signature\API\XML\CustomBase64BinaryType $byKey)
    {
        $this->byKey = $byKey;
        return $this;
    }


}

