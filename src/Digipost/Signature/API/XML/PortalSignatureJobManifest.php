<?php

namespace Digipost\Signature\API\XML;

/**
 * Class representing PortalSignatureJobManifest
 */
class PortalSignatureJobManifest
{

    /**
     * @property \Digipost\Signature\API\XML\XMLPortalSigner[] $signers
     */
    private $signers = null;

    /**
     * @property \Digipost\Signature\API\XML\XMLSender $sender
     */
    private $sender = null;

    /**
     * @property \Digipost\Signature\API\XML\XMLPortalDocument $document
     */
    private $document = null;

    /**
     * @property \Digipost\Signature\API\XML\XMLAuthenticationLevel $requiredAuthentication
     */
    private $requiredAuthentication = null;

    /**
     * @property \Digipost\Signature\API\XML\XMLAvailability $availability
     */
    private $availability = null;

    /**
     * @property \Digipost\Signature\API\XML\XMLIdentifierInSignedDocuments $identifierInSignedDocuments
     */
    private $identifierInSignedDocuments = null;

    /**
     * Adds as signer
     *
     * @return self
     * @param \Digipost\Signature\API\XML\XMLPortalSigner $signer
     */
    public function addToSigners(\Digipost\Signature\API\XML\XMLPortalSigner $signer)
    {
        $this->signers[] = $signer;
        return $this;
    }

    /**
     * isset signers
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSigners($index)
    {
        return isset($this->signers[$index]);
    }

    /**
     * unset signers
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSigners($index)
    {
        unset($this->signers[$index]);
    }

    /**
     * Gets as signers
     *
     * @return \Digipost\Signature\API\XML\XMLPortalSigner[]
     */
    public function getSigners()
    {
        return $this->signers;
    }

    /**
     * Sets a new signers
     *
     * @param \Digipost\Signature\API\XML\XMLPortalSigner[] $signers
     * @return self
     */
    public function setSigners(array $signers)
    {
        $this->signers = $signers;
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
     * @return \Digipost\Signature\API\XML\XMLPortalDocument
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Sets a new document
     *
     * @param \Digipost\Signature\API\XML\XMLPortalDocument $document
     * @return self
     */
    public function setDocument(\Digipost\Signature\API\XML\XMLPortalDocument $document)
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
     * Gets as availability
     *
     * @return \Digipost\Signature\API\XML\XMLAvailability
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Sets a new availability
     *
     * @param \Digipost\Signature\API\XML\XMLAvailability $availability
     * @return self
     */
    public function setAvailability(\Digipost\Signature\API\XML\XMLAvailability $availability)
    {
        $this->availability = $availability;
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

