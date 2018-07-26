<?php

namespace Digipost\Signature\API\XML;

/**
 * Class representing DirectSignatureJobRequest
 */
class DirectSignatureJobRequest
{

    /**
     * @property string $reference
     */
    private $reference = null;

    /**
     * @property \Digipost\Signature\API\XML\XMLExitUrls $exitUrls
     */
    private $exitUrls = null;

    /**
     * Indicates the method of which the sender will retrieve a job's status upon a status change by specifying one of:
     *
     *  * WAIT_FOR_CALLBACK
     *  Querying the job's status explicitly using the query parameter appended
     *  to the exit-URL after e.g. a signer have completed the job
     *  * POLLING
     *  Continuously polling the service, receiving a response every time one of the
     *  sender's jobs has had its status changed.
     *
     * Defaults to WAIT_FOR_CALLBACK if omitted.
     *
     * @property \Digipost\Signature\API\XML\XMLStatusRetrievalMethod $statusRetrievalMethod
     */
    private $statusRetrievalMethod = null;

    /**
     * Specifies the queue that status changes for this signature job will occur in. This is a feature aimed at organizations where
     * it makes sense to retrieve status changes from several queues. This may be if the organization has more than one division,
     * and each division has an application that create signature jobs through the API and want to retrieve status changes
     * independent of the other division's actions.
     *
     * For example, if the polling-queue element is set to 'custom-queue', status changes related to this signature job can only
     * be retrieved by setting the query parameter 'polling_queue' to 'custom-queue' on the request. If the polling-queue element is not
     * specified, the job status changes will be available on the default queue. No query parameter is required to obtain status changes
     * for the default queue.
     *
     * @property string $pollingQueue
     */
    private $pollingQueue = null;

    /**
     * Gets as reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Sets a new reference
     *
     * @param string $reference
     * @return self
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * Gets as exitUrls
     *
     * @return \Digipost\Signature\API\XML\XMLExitUrls
     */
    public function getExitUrls()
    {
        return $this->exitUrls;
    }

    /**
     * Sets a new exitUrls
     *
     * @param \Digipost\Signature\API\XML\XMLExitUrls $exitUrls
     * @return self
     */
    public function setExitUrls(\Digipost\Signature\API\XML\XMLExitUrls $exitUrls)
    {
        $this->exitUrls = $exitUrls;
        return $this;
    }

    /**
     * Gets as statusRetrievalMethod
     *
     * Indicates the method of which the sender will retrieve a job's status upon a status change by specifying one of:
     *
     *  * WAIT_FOR_CALLBACK
     *  Querying the job's status explicitly using the query parameter appended
     *  to the exit-URL after e.g. a signer have completed the job
     *  * POLLING
     *  Continuously polling the service, receiving a response every time one of the
     *  sender's jobs has had its status changed.
     *
     * Defaults to WAIT_FOR_CALLBACK if omitted.
     *
     * @return \Digipost\Signature\API\XML\XMLStatusRetrievalMethod
     */
    public function getStatusRetrievalMethod()
    {
        return $this->statusRetrievalMethod;
    }

    /**
     * Sets a new statusRetrievalMethod
     *
     * Indicates the method of which the sender will retrieve a job's status upon a status change by specifying one of:
     *
     *  * WAIT_FOR_CALLBACK
     *  Querying the job's status explicitly using the query parameter appended
     *  to the exit-URL after e.g. a signer have completed the job
     *  * POLLING
     *  Continuously polling the service, receiving a response every time one of the
     *  sender's jobs has had its status changed.
     *
     * Defaults to WAIT_FOR_CALLBACK if omitted.
     *
     * @param \Digipost\Signature\API\XML\XMLStatusRetrievalMethod $statusRetrievalMethod
     * @return self
     */
    public function setStatusRetrievalMethod(\Digipost\Signature\API\XML\XMLStatusRetrievalMethod $statusRetrievalMethod)
    {
        $this->statusRetrievalMethod = $statusRetrievalMethod;
        return $this;
    }

    /**
     * Gets as pollingQueue
     *
     * Specifies the queue that status changes for this signature job will occur in. This is a feature aimed at organizations where
     * it makes sense to retrieve status changes from several queues. This may be if the organization has more than one division,
     * and each division has an application that create signature jobs through the API and want to retrieve status changes
     * independent of the other division's actions.
     *
     * For example, if the polling-queue element is set to 'custom-queue', status changes related to this signature job can only
     * be retrieved by setting the query parameter 'polling_queue' to 'custom-queue' on the request. If the polling-queue element is not
     * specified, the job status changes will be available on the default queue. No query parameter is required to obtain status changes
     * for the default queue.
     *
     * @return string
     */
    public function getPollingQueue()
    {
        return $this->pollingQueue;
    }

    /**
     * Sets a new pollingQueue
     *
     * Specifies the queue that status changes for this signature job will occur in. This is a feature aimed at organizations where
     * it makes sense to retrieve status changes from several queues. This may be if the organization has more than one division,
     * and each division has an application that create signature jobs through the API and want to retrieve status changes
     * independent of the other division's actions.
     *
     * For example, if the polling-queue element is set to 'custom-queue', status changes related to this signature job can only
     * be retrieved by setting the query parameter 'polling_queue' to 'custom-queue' on the request. If the polling-queue element is not
     * specified, the job status changes will be available on the default queue. No query parameter is required to obtain status changes
     * for the default queue.
     *
     * @param string $pollingQueue
     * @return self
     */
    public function setPollingQueue($pollingQueue)
    {
        $this->pollingQueue = $pollingQueue;
        return $this;
    }


}

