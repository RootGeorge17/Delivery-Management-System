<?php

class DeliveryUserTypeData
{
    protected $id, $userTypeName;

    public function __construct($dbRow)
    {
        $this->id = $dbRow['id'];
        $this->userTypeName = $dbRow['usertypename'];
    }

    public function getUserTypeID()
    {
        return $this->id;
    }

    public function getUserTypeName()
    {
        return $this->userTypeName;
    }
}