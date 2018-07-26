<?php

namespace Digipost\Signature\API\XML;

/**
 * Class representing DirectSignatureJobManifest
 */
class DirectSignatureJobManifest
{

    /**
     * @property \Digipost\Signature\API\XML\XMLDirectSigner[] $signer
     */
    private $signer = array(
        
    );

    /**
     * @property \Digipost\Signature\API\XML\XMLSender $sender
     */
    private $sender = null;

    /**
     * @property \Digipost\Signature\API\XML\XMLDirectDocument $document
     */
    private $document = null;

    /**
     * @property \Digipost\Signature\API\XML\XMLAuthenticationLevel $requiredAuthentication
     */
    private $requiredAuthentication = null;

    /**
     * @property \Digipost\Signature\API\XML\XMLIdentifierInSignedDocuments $identifierInSignedDocuments
     */
    private $identifierInSignedDocuments = null;

    /**
     * Adds as signer
     *
     * @return self
     * @param \Digipost\Signature\API\XML\XMLDirectSigner $signer
     */
    public function addToSigner(\Digipost\Signature\API\XML\XMLDirectSigner $signer)
    {
        $this->signer[] = $signer;
        return $this;
    }

    /**
     * isset signer
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSigner($index)
    {
        return isset($this->signer[$index]);
    }

    /**
     * unset signer
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSigner($index)
    {
        unset($this->signer[$index]);
    }

    /**
     * Gets as signer
     *
     * @return \Digipost\Signature\API\XML\XMLDirectSigner[]
     */
    public function getSigner()
    {
        return $this->signer;
    }

    /**
     * Sets a new signer
     *
     * @param \Digipost\Signature\API\XML\XMLDirectSigner[] $signer
     * @return self
     */
    public function setSigner(array $signer)
    {
        $this->signer = $signer;
        return $this;
    }

    /**
     * Gets as sender
     *
     * @return \Digipost\Signature\API\XML\XMLSender
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Sets a new sender
     *
     * @param \Digipost\Signature\API\XML\XMLSender $sender
     * @return self
     */
    public function setSender(\Digipost\Signature\API\XML\XMLSender $sender)
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * Gets as document
     *
     * @return \Digipost\Signature\API\XML\XMLDirectDocument
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Sets a new document
     *
     * @param \Digipost\Signature\API\XML\XMLDirectDocument $document
     * @return self
     */
    public function setDocument(\Digipost\Signature\API\XML\XMLDirectDocument $document)
    {
        $this->document = $document;
        return $this;
    }

    /**
     * Gets as requiredAuthentication
     *
     * @return \Digipost\Signature\API\XML\XMLAuthenticationLevel
     */
    public function getRequiredAuthentication()
    {
        return $this->requiredAuthentication;
    }

    /**
     * Sets a new requiredAuthentication
     *
     * @param \Digipost\Signature\API\XML\XMLAuthenticationLevel $requiredAuthentication
     * @return self
     */
    public function setRequiredAuthentication(\Digipost\Signature\API\XML\XMLAuthenticationLevel $requiredAuthentication)
    {
        $this->requiredAuthentication = $requiredAuthentication;
        return $this;
    }

    /**
     * Gets as identifierInSignedDocuments
     *
     * @return \Digipost\Signature\API\XML\XMLIdentifierInSignedDocuments
     */
    public function getIdentifierInSignedDocuments()
    {
        return $this->identifierInSignedDocuments;
    }

    /**
     * Sets a new identifierInSignedDocuments
     *
     * @param \Digipost\Signature\API\XML\XMLIdentifierInSignedDocuments $identifierInSignedDocuments
     * @return self
     */
    public function setIdentifierInSignedDocuments(\Digipost\Signature\API\XML\XMLIdentifierInSignedDocuments $identifierInSignedDocuments)
    {
        $this->identifierInSignedDocuments = $identifierInSignedDocuments;
        return $this;
    }


}

