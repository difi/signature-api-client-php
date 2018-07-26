<?php

namespace Digipost\Signature\API\XML\Thirdparty\XAdES;

/**
 * Class representing QualifyingPropertiesReferenceType
 *
 *
 * XSD Type: QualifyingPropertiesReferenceType
 */
class QualifyingPropertiesReferenceType
{

    /**
     * @property string $uRI
     */
    private $uRI = null;

    /**
     * @property string $id
     */
    private $id = null;

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


}

