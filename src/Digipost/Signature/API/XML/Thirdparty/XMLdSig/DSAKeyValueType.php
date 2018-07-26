<?php

namespace Digipost\Signature\API\XML\Thirdparty\XMLdSig;

/**
 * Class representing DSAKeyValueType
 *
 *
 * XSD Type: DSAKeyValueType
 */
class DSAKeyValueType
{

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $p
     */
    private $p = null;

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $q
     */
    private $q = null;

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $g
     */
    private $g = null;

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $y
     */
    private $y = null;

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $j
     */
    private $j = null;

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $seed
     */
    private $seed = null;

    /**
     * @property \Digipost\Signature\API\XML\CustomBase64BinaryType $pgenCounter
     */
    private $pgenCounter = null;

    /**
     * Gets as p
     *
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType
     */
    public function getP()
    {
        return $this->p;
    }

    /**
     * Sets a new p
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $p
     * @return self
     */
    public function setP(\Digipost\Signature\API\XML\CustomBase64BinaryType $p)
    {
        $this->p = $p;
        return $this;
    }

    /**
     * Gets as q
     *
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType
     */
    public function getQ()
    {
        return $this->q;
    }

    /**
     * Sets a new q
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $q
     * @return self
     */
    public function setQ(\Digipost\Signature\API\XML\CustomBase64BinaryType $q)
    {
        $this->q = $q;
        return $this;
    }

    /**
     * Gets as g
     *
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType
     */
    public function getG()
    {
        return $this->g;
    }

    /**
     * Sets a new g
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $g
     * @return self
     */
    public function setG(\Digipost\Signature\API\XML\CustomBase64BinaryType $g)
    {
        $this->g = $g;
        return $this;
    }

    /**
     * Gets as y
     *
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Sets a new y
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $y
     * @return self
     */
    public function setY(\Digipost\Signature\API\XML\CustomBase64BinaryType $y)
    {
        $this->y = $y;
        return $this;
    }

    /**
     * Gets as j
     *
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType
     */
    public function getJ()
    {
        return $this->j;
    }

    /**
     * Sets a new j
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $j
     * @return self
     */
    public function setJ(\Digipost\Signature\API\XML\CustomBase64BinaryType $j)
    {
        $this->j = $j;
        return $this;
    }

    /**
     * Gets as seed
     *
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType
     */
    public function getSeed()
    {
        return $this->seed;
    }

    /**
     * Sets a new seed
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $seed
     * @return self
     */
    public function setSeed(\Digipost\Signature\API\XML\CustomBase64BinaryType $seed)
    {
        $this->seed = $seed;
        return $this;
    }

    /**
     * Gets as pgenCounter
     *
     * @return \Digipost\Signature\API\XML\CustomBase64BinaryType
     */
    public function getPgenCounter()
    {
        return $this->pgenCounter;
    }

    /**
     * Sets a new pgenCounter
     *
     * @param \Digipost\Signature\API\XML\CustomBase64BinaryType $pgenCounter
     * @return self
     */
    public function setPgenCounter(\Digipost\Signature\API\XML\CustomBase64BinaryType $pgenCounter)
    {
        $this->pgenCounter = $pgenCounter;
        return $this;
    }


}

