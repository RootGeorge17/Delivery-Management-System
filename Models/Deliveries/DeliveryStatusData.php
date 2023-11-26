<?php

class DeliveryStatusData
{
    protected $id, $statusCode, $status_text;

    public function __construct($dbRow)
    {
        $this->id = $dbRow['id'];
        $this->statusCode = $dbRow['statusCode'];
        $this->status_text = $dbRow['status_text'];
    }

    public function getStatusID()
    {
        return $this->id;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getStatusText()
    {
        return $this->status_text;
    }
}