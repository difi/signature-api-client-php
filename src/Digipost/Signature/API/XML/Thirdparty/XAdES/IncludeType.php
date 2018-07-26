<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing IncludeType
 *
 *
 * XSD Type: IncludeType
 */
class IncludeType
{

    /**
     * @property string $uRI
     */
    private $uRI = null;

    /**
     * @property boolean $referencedData
     */
    private $referencedData = null;

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
     * Gets as referencedData
     *
     * @return boolean
     */
    public function getReferencedData()
    {
        return $this->referencedData;
    }

    /**
     * Sets a new referencedData
     *
     * @param boolean $referencedData
     * @return self
     */
    public function setReferencedData($referencedData)
    {
        $this->referencedData = $referencedData;
        return $this;
    }


}

