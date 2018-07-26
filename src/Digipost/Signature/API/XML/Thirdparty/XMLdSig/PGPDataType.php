<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

/**
 * Class representing PGPDataType
 *
 *
 * XSD Type: PGPDataType
 */
class PGPDataType
{

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $pGPKeyID
     */
    private $pGPKeyID = null;

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $pGPKeyPacket
     */
    private $pGPKeyPacket = null;

    /**
     * Gets as pGPKeyID
     *
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType
     */
    public function getPGPKeyID()
    {
        return $this->pGPKeyID;
    }

    /**
     * Sets a new pGPKeyID
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $pGPKeyID
     * @return self
     */
    public function setPGPKeyID(\Digipost\Signature\API\XML\CustomBase64BinaryType $pGPKeyID)
    {
        $this->pGPKeyID = $pGPKeyID;
        return $this;
    }

    /**
     * Gets as pGPKeyPacket
     *
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType
     */
    public function getPGPKeyPacket()
    {
        return $this->pGPKeyPacket;
    }

    /**
     * Sets a new pGPKeyPacket
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $pGPKeyPacket
     * @return self
     */
    public function setPGPKeyPacket(\Digipost\Signature\API\XML\CustomBase64BinaryType $pGPKeyPacket)
    {
        $this->pGPKeyPacket = $pGPKeyPacket;
        return $this;
    }


}

