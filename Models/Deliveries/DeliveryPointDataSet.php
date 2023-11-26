<?php

require_once('Models/Infrastructure/Database.php');
require_once('Models/Deliveries/DeliveryPointData.php');

class DeliveryPointDataSet
{
    protected $dbHandle, $dbInstance;

    public function __construct() {
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getDBConnection();
    }

    public function fetchAllDeliveryPoints($delivererID) {
        $sqlQuery = 'SELECT * FROM delivery_point
                     WHERE deliverer = :delivererID';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':delivererID' => $delivererID
        ]); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryPointData($row);
        }
        return $dataSet;
    }

    public function searchDeliveryPoints($value, $deliverer) {
        $sqlQuery = 'SELECT * 
        FROM delivery_point
        WHERE deliverer = :deliverer AND id LIKE :id
        OR name LIKE :name
        OR address_1 LIKE :address_1
        OR address_2 LIKE :address_2
        OR postcode LIKE :postcode';

        $searchValue = '%' . trim($value) . '%';

        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute([
            ':deliverer' => $deliverer,
            ':id' => $searchValue,
            ':name' => $searchValue,
            ':address_1' => $searchValue,
            ':address_2' => $searchValue,
            ':postcode' => $searchValue
        ]);

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryPointData($row);
        }
        return $dataSet;
    }
}
