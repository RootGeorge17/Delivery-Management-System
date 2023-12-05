<?php

/**
 * Class DeliveryStatusData
 * Represents data related to delivery statuses.
 */
class DeliveryStatusData
{
    /**
     * @var int The ID of the status.
     */
    /**
     * @var string The status code.
     */
    /**
     * @var string The textual representation of the status.
     */
    protected $id, $statusCode, $status_text;

    /**
     * DeliveryStatusData constructor.
     *
     * @param array $dbRow The database row containing status data.
     */
    public function __construct($dbRow)
    {
        $this->id = $dbRow['id'];
        $this->statusCode = $dbRow['statusCode'];
        $this->status_text = $dbRow['status_text'];
    }

    /**
     * Get the ID of the status.
     *
     * @return int The status ID.
     */
    public function getStatusID()
    {
        return $this->id;
    }

    /**
     * Get the status code.
     *
     * @return string The status code.
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Get the textual representation of the status.
     *
     * @return string The status text.
     */
    public function getStatusText()
    {
        return $this->status_text;
    }
}