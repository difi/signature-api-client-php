<?php

namespace Digipost\Signature\API\XML;

/**
 * Class representing PortalSignatureJobRequest
 */
class PortalSignatureJobRequest
{

    /**
     * @property string $reference
     */
    private $reference = null;

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

