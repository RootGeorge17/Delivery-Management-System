<?php

require_once('Models/Core/Database.php');
require_once('Models/Deliveries/DeliveryStatusData.php');

class DeliveryStatusDataSet
{
    protected $dbHandle, $dbInstance;

    public function __construct() {
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getDBConnection();
    }

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
