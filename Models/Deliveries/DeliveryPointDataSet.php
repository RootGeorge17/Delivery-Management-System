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
     * Update the status of a delivery point.
     *
     * @param int $id The ID of the delivery point.
     * @param int $status The new status.
     */
    public function getDeliveryPointStatus($id)
    {
        $sqlQuery = 'SELECT status
                    FROM delivery_point
                    WHERE id = :id';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':id' => $id
        ]); // execute the PDO statement

        $status = $statement->fetch(PDO::FETCH_ASSOC);
        return $status;
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
    public function searchDeliveryPointsLive($conditions, $searchTerm, $page, $resultsPerPage)
    {
        // Calculate the offset for the current page
        $offset = ($page - 1) * $resultsPerPage;

        // Initialize the SQL query and parameters array
        $sqlQuery = 'SELECT * FROM delivery_point';
        $params = [];

        if (!empty($conditions) && !empty($searchTerm)) {
            $sqlQuery .= ' WHERE';

            // Loop through conditions
            foreach ($conditions as $key => $condition) {
                // Append condition to SQL query
                if ($condition === 'id') {
                    $sqlQuery .= " $condition = ?";
                    $params[] = $searchTerm;
                } else {
                    $sqlQuery .= " $condition LIKE ?";
                    $params[] = "%$searchTerm%";
                }

                // Append OR between conditions except for the last one
                if ($key !== array_key_last($conditions)) {
                    $sqlQuery .= ' OR';
                }
            }
        }

        // Add the LIMIT and OFFSET clauses to the SQL query with literal values
        $sqlQuery .= " LIMIT $resultsPerPage OFFSET $offset";

        // Prepare and execute the SQL query
        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute($params);

        // Fetch the results
        $dataSet = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet[] = new DeliveryPointData($row);
        }

        return $dataSet;
    }

    public function searchDeliveryPoints($conditions, $searchTerm, $page, $resultsPerPage)
    {
        // Calculate the offset for the current page
        $offset = ($page - 1) * $resultsPerPage;

        // Initialize the SQL query and parameters array
        $sqlQuery = 'SELECT * FROM delivery_point';
        $params = [];
        $whereConditions = [];

        if (!empty($conditions) && !empty($searchTerm)) {
            $whereConditions[] = '(';

            // Loop through conditions
            foreach ($conditions as $key => $condition) {
                // Append condition to SQL query
                if ($condition === 'id') {
                    $whereConditions[] = "$condition = ?";
                    $params[] = $searchTerm;
                } else {
                    $whereConditions[] = "$condition LIKE ?";
                    $params[] = "%$searchTerm%";
                }

                // Append OR between conditions except for the last one
                if ($key !== array_key_last($conditions)) {
                    $whereConditions[] = 'OR';
                }
            }

            $whereConditions[] = ')';
            $sqlQuery .= ' WHERE ' . implode(' ', $whereConditions);
        }

        // Add the LIMIT and OFFSET clauses to the SQL query with literal values
        $sqlQuery .= " LIMIT $resultsPerPage OFFSET $offset";

        // Prepare and execute the SQL query
        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute($params);

        // Fetch the results
        $dataSet = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet[] = new DeliveryPointData($row);
        }

        // Get the total count of matching rows
        $countQuery = 'SELECT COUNT(*) AS total_count FROM delivery_point';
        if (!empty($conditions) && !empty($searchTerm)) {
            $countQuery .= ' WHERE ' . implode(' ', $whereConditions);
        }

        $statement = $this->dbHandle->prepare($countQuery);
        $statement->execute($params);
        $totalCount = $statement->fetch(PDO::FETCH_ASSOC)['total_count'];

        return ['dataSet' => $dataSet, 'totalCount' => $totalCount];
    }

    public function fetchAllDeliveryPointsForMap()
    {
        $sqlQuery = 'SELECT dp.*, du.username AS deliverer_username 
             FROM delivery_point dp
             LEFT JOIN delivery_users du ON dp.deliverer = du.id
             WHERE dp.status <> 4 
             ORDER BY dp.id ASC
             LIMIT 100';

        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute();

        // Fetch the results
        $dataSet = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet[] = new DeliveryPointData($row);
        }

        return $dataSet;
    }

    public function fetchDeliveryPointByLatLng($lat, $lng)
    {
        $sqlQuery = "
        SELECT *
        FROM delivery_point
        ORDER BY ABS(lat - ?) + ABS(lng - ?)
        LIMIT 1";

        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $lat, PDO::PARAM_STR);
        $statement->bindParam(2, $lng, PDO::PARAM_STR);
        $statement->execute();

        $point = $statement->fetch(PDO::FETCH_ASSOC);
        return $point;
    }

    public function fetchDeliveryPointById($id, $delivererId)
    {
        $sqlQuery = 'SELECT * FROM delivery_point
                     WHERE deliverer = :delivererID
                     AND id = :id';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':delivererID' => $delivererId,
            'id' => $id
        ]); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryPointData($row);
        }
        return $dataSet;
    }

    public function fetchDeliveryPointByIdForManagers($id)
    {
        $sqlQuery = 'SELECT * FROM delivery_point
                     WHERE id = :id';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            'id' => $id
        ]); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryPointData($row);
        }
        return $dataSet;
    }

    public function isDelivered($delivery)
    {
        $sqlQuery = "SELECT * FROM delivery_point WHERE id = :delivery";

        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute([':delivery' => $delivery['id']]);

        $deliveryPoint = $statement->fetch(PDO::FETCH_ASSOC);

        // Assuming 'status' is the column that indicates delivery status
        if ($deliveryPoint && $deliveryPoint['status'] != 4) {
            return $deliveryPoint; // Return the delivery point if it's not delivered
        } elseif ($deliveryPoint && $deliveryPoint['status'] == 4) {
            return 'Delivery already completed'; // Return an error if it's delivered
        } else {
            return 'Delivery point not found'; // Return an error if the delivery point doesn't exist
        }
    }



}