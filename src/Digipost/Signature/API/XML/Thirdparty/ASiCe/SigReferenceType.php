<?php

namespace Digipost\Signature\API\XML\Thirdparty\ASiCe;

/**
 * Class representing SigReferenceType
 *
 *
 * XSD Type: SigReferenceType
 */
class SigReferenceType
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


}

