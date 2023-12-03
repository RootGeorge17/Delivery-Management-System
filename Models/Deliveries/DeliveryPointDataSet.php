<?php

require_once('Models/Core/Database.php');
require_once('Models/Deliveries/DeliveryPointData.php');
require_once('Models/Users/DeliveryUserData.php');

class DeliveryPointDataSet
{
    protected $dbHandle, $dbInstance;

    public function __construct() {
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getDBConnection();
    }

    public function fetchUserDeliveryPoints($delivererID) {
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

    public function fetchAllDeliveryPoints() {
        $sqlQuery = 'SELECT dp.*, du.username AS deliverer_username 
                 FROM delivery_point dp
                 INNER JOIN delivery_users du ON dp.deliverer = du.id';

        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryPointData($row);
        }
        return $dataSet;
    }

    public function updateStatusDeliveryPoint($id, $status) {
        $sqlQuery = 'UPDATE delivery_point
                    SET status = :status
                    WHERE id = :id';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':status' => $status,
            ':id' => $id
        ]); // execute the PDO statement
    }

    public function deleteStatusDeliveryPoint($id) {
        $sqlQuery = 'DELETE FROM delivery_point
                     WHERE id = :id';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':id' => $id
        ]); // execute the PDO statement
    }

    public function assignDeliverer($id, $assignedDeliverer) {
        $sqlQuery = 'UPDATE delivery_point dp
                     SET dp.deliverer = (SELECT du.id FROM delivery_users du WHERE du.username = :assignedDeliverer)
                     WHERE dp.id = :id';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':id' => $id,
            ':assignedDeliverer' => $assignedDeliverer
        ]); // execute the PDO statement
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
            $dataSet[] = new DeliveryPointData($row, $deliverer);
        }
        return $dataSet;
    }
}
