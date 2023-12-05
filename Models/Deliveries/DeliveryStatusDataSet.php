<?php

require_once('Models/Core/Database.php');
require_once('Models/Deliveries/DeliveryStatusData.php');

/**
 * Class DeliveryStatusDataSet
 * Handles fetching data related to delivery statuses from the database.
 */
class DeliveryStatusDataSet
{
    /**
     * @var PDO Represents the database connection handle.
     */
    /**
     * @var Database Represents the instance of the database.
     */
    protected $dbHandle, $dbInstance;

    /**
     * DeliveryStatusDataSet constructor.
     * Initializes the database instance and connection handle.
     */
    public function __construct() {
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getDBConnection();
    }

    /**
     * Fetches all delivery status data from the database.
     *
     * @return array An array of DeliveryStatusData objects representing delivery statuses.
     */
    public function fetchAllDeliveryUsers() {
        $sqlQuery = 'SELECT * FROM delivery_status';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryStatusData($row);
        }
        return $dataSet;
    }
}
