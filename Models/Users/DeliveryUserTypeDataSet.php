<?php

require_once('Models/Core/Database.php');
require_once('Models/Users/DeliveryUserTypeData.php');

/**
 * Class DeliveryUserTypeDataSet
 * Handles operations related to delivery user types.
 */
class DeliveryUserTypeDataSet
{
    /**
     * @var PDO Represents the database connection handle.
     */
    /**
     * @var Database|null Represents the Database instance.
     */
    protected $dbHandle, $dbInstance;

    /**
     * DeliveryUserTypeDataSet constructor.
     * Initializes the database connection.
     */
    public function __construct() {
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getDBConnection();
    }

    /**
     * Fetches all delivery user types from the database.
     *
     * @return array Returns an array containing DeliveryUserTypeData instances.
     */
    public function fetchAllDeliveryUsers() {
        $sqlQuery = 'SELECT * FROM delivery_usertype';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryUserTypeData($row);
        }
        return $dataSet;
    }
}
