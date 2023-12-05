<?php

/**
 * Class DeliveryUserTypeData
 * Represents data related to user types for delivery.
 */
class DeliveryUserTypeData
{
    /**
     * @var int The ID of the user type.
     */
    /**
     * @var string The name of the user type.
     */
    protected $id, $userTypeName;

    /**
     * DeliveryUserTypeData constructor.
     *
     * @param array $dbRow The database row containing user type data.
     */
    public function __construct($dbRow)
    {
        $this->id = $dbRow['id'];
        $this->userTypeName = $dbRow['usertypename'];
    }

    /**
     * Retrieves the ID of the user type.
     *
     * @return int Returns the user type ID.
     */
    public function getUserTypeID()
    {
        return $this->id;
    }

    /**
     * Retrieves the name of the user type.
     *
     * @return string Returns the user type name.
     */
    public function getUserTypeName()
    {
        return $this->userTypeName;
    }
}