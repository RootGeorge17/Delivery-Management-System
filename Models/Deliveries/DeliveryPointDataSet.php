<?php

require_once('Models/Core/Database.php');
require_once('Models/Deliveries/DeliveryPointData.php');
require_once('Models/Users/DeliveryUserData.php');

/**
 * Class DeliveryPointDataSet
 * Handles operations related to delivery points in the database.
 */
class DeliveryPointDataSet
{
    protected $dbHandle, $dbInstance;

    public function __construct()
    {
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getDBConnection();
    }

    /**
     * Fetch delivery points for a specific user.
     *
     * @param int $delivererID The ID of the deliverer.
     * @return array An array of DeliveryPointData objects.
     */
    public function fetchUserDeliveryPoints($delivererID)
    {
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

    /**
     * Fetch all delivery points.
     *
     * @return array An array of DeliveryPointData objects.
     */
    public function fetchAllDeliveryPoints()
    {
        $sqlQuery = 'SELECT dp.*, du.username AS deliverer_username 
                     FROM delivery_point dp
                     LEFT JOIN delivery_users du ON dp.deliverer = du.id';

        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryPointData($row);
        }
        return $dataSet;
    }

    /**
     * Update the status of a delivery point.
     *
     * @param int $id The ID of the delivery point.
     * @param int $status The new status.
     */
    public function updateStatusDeliveryPoint($id, $status)
    {
        $sqlQuery = 'UPDATE delivery_point
                    SET status = :status
                    WHERE id = :id';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':status' => $status,
            ':id' => $id
        ]); // execute the PDO statement
    }

    /**
     * Delete a delivery point by ID.
     *
     * @param int $id The ID of the delivery point.
     */
    public function deleteStatusDeliveryPoint($id)
    {
        $sqlQuery = 'DELETE FROM delivery_point
                     WHERE id = :id';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':id' => $id
        ]); // execute the PDO statement
    }

    /**
     * Assign a deliverer to a delivery point.
     *
     * @param int $id The ID of the delivery point.
     * @param string $assignedDeliverer The username of the assigned deliverer.
     */
    public function assignDeliverer($id, $assignedDeliverer)
    {
        $sqlQuery = 'UPDATE delivery_point dp
                     SET dp.deliverer = (SELECT du.id FROM delivery_users du WHERE du.username = :assignedDeliverer)
                     WHERE dp.id = :id';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':id' => $id,
            ':assignedDeliverer' => $assignedDeliverer
        ]); // execute the PDO statement
    }

    /**
     * Create a new delivery point.
     *
     * @param string $name The name of the delivery point.
     * @param string $address1 The first address line.
     * @param string $address2 The second address line.
     * @param string $postcode The postcode.
     * @param float $latitude The latitude.
     * @param float $longitude The longitude.
     * @param string $deliverer The username of the deliverer.
     * @param int $status The status ID.
     */
    public function createParcel($name, $address1, $address2, $postcode, $latitude, $longitude, $deliverer, $status)
    {
        $sqlQuery = 'INSERT INTO delivery_point
        (name, address_1, address_2, postcode, deliverer, lat, lng, status) 
        VALUES
         (:name, :address1, :address2, :postcode, 
        (SELECT id FROM delivery_users WHERE username = :deliverer), 
         :latitude, :longitude, 
         (SELECT id FROM delivery_status WHERE id = :status));';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':name' => $name,
            ':address1' => $address1,
            ':address2' => $address2,
            ':postcode' => $postcode,
            ':latitude' => $latitude,
            ':longitude' => $longitude,
            ':deliverer' => $deliverer,
            ':status' => $status
        ]); // execute the PDO statement
    }

    /**
     * Update a delivery point without changing the photo.
     *
     * @param int $id The ID of the delivery point.
     * @param string $name The name of the delivery point.
     * @param string $address1 The first address line.
     * @param string $address2 The second address line.
     * @param string $postcode The postcode.
     * @param float $latitude The latitude.
     * @param float $longitude The longitude.
     * @param string $deliverer The username of the deliverer.
     * @param int $status The status ID.
     */
    public function updateParcelWithoutPhoto($id, $name, $address1, $address2, $postcode, $latitude, $longitude, $deliverer, $status)
    {
        $sqlQuery = 'UPDATE delivery_point  
                     SET 
                     name = :name,
                     address_1 = :address1,
                     address_2 = :address2,
                     postcode = :postcode,
                     deliverer = :deliverer,
                     lat = :latitude,
                     lng = :longitude,            
                     status = :status
                     WHERE 
                     id = :id';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':id' => $id,
            ':name' => $name,
            ':address1' => $address1,
            ':address2' => $address2,
            ':postcode' => $postcode,
            ':deliverer' => $deliverer,
            ':latitude' => $latitude,
            ':longitude' => $longitude,
            ':status' => $status,
        ]); // execute the PDO statement
    }

    /**
     * Search for delivery points based on conditions and a search term.
     *
     * @param array $conditions An array of conditions to search.
     * @param string $searchTerm The term to search for.
     * @return array An array of DeliveryPointData objects.
     */
    public function searchDeliveryPoints($conditions, $searchTerm)
    {
        if (!empty($conditions) && !empty($searchTerm)) {
            $sqlQuery = 'SELECT * FROM delivery_point WHERE';
            $params = [];

            foreach ($conditions as $key => $condition) {
                if ($condition === 'id') {
                    $sqlQuery .= " $condition = ?";
                    $params[] = $searchTerm;
                } else {
                    $sqlQuery .= " $condition LIKE ?";
                    $params[] = "%$searchTerm%";
                }

                if ($key !== array_key_last($conditions)) {
                    $sqlQuery .= ' OR';
                }
            }
        } else {
            $sqlQuery = 'SELECT * FROM delivery_point';
        }

        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute($params);

        $dataSet = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet[] = $row;
        }

        return json_encode($dataSet);
    }
}
