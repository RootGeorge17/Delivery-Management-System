<?php

require_once('Models/Core/Database.php');
require_once('Models/Users/DeliveryUserData.php');

/**
 * Class DeliveryUserDataSet
 * Handles operations related to the dataset of delivery users.
 */
class DeliveryUserDataSet
{
    /**
     * @var PDO|null The database handle instance.
     */
    /**
     * @var Database|null The database instance.
     */
    protected $dbHandle, $dbInstance;


    /**
     * Constructor for DeliveryUserDataSet class.
     * Initializes the database connection.
     */
    public function __construct() {
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getDBConnection();
    }

    /**
     * Fetches all delivery users.
     *
     * @return array An array of DeliveryUserData objects representing all delivery users.
     */
    public function fetchAllDeliveryUsers() {
        $sqlQuery = 'SELECT * FROM delivery_users
                     WHERE usertype = 2';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryUserData($row);
        }
        return $dataSet;
    }


    /**
     * Retrieves user details based on the username.
     *
     * @param string $username The username to retrieve details for.
     *
     * @return array|null An associative array representing user details if found, otherwise null.
     */
    public function getUserDetails($username)
    {
        $sqlQuery = 'SELECT u.id, u.username, ut.id as usertypeid, ut.usertypename
                 FROM delivery_users u
                 INNER JOIN delivery_usertype ut ON u.usertype = ut.id
                 WHERE u.username = :username';

        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute([
            'username' => $username
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC); // Fetch as an associative array

        if ($result && isset($result['id'])) {
            return $result; // Return the user details directly
        }

        return null; // Or handle the case where user details are not found
    }

    /**
     * Validates if the provided credentials match.
     *
     * @param string $username The username to validate.
     * @param string $password The password to validate.
     *
     * @return bool Returns true if credentials match, false otherwise.
     */
    public function credentialsMatch($username, $password)
    {
        $sqlQuery = 'SELECT * FROM delivery_users
                     WHERE username = :username';

        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute([
            ':username' => $username,
        ]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $storedHashedPassword = $user['password'];
            if (password_verify($password, $storedHashedPassword)) {
                return true; // Passwords match
            }
        }

        return false;
    }

    /**
     * Retrieves the ID of a user based on their username.
     *
     * @param string $username The username to search for.
     *
     * @return int|null Returns the user ID if found, otherwise null.
     */
    public function getUserID($username)
    {
        $sqlQuery = 'SELECT id FROM delivery_users
                     WHERE username = :username';

        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute([
            ':username' => $username,
        ]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return intval($user['id']);
        }
    }

    /**
     * Retrieves the username based on the user's ID.
     *
     * @param int $id The ID of the user.
     *
     * @return string|null Returns the username if found, otherwise null.
     */
    public function getUsername($id)
    {
        $sqlQuery = 'SELECT username FROM delivery_users
                     WHERE id = :id';

        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute([
            ':id' => $id,
        ]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return $user['username'];
        }
    }

    /**
     * Checks if a user with the provided username exists.
     *
     * @param string $username The username to check.
     *
     * @return bool Returns true if the user exists, otherwise false.
     */
    public function checkUserExists($username): bool
    {
        $sqlQuery = 'SELECT * FROM delivery_users 
         WHERE username = :username';

        $searchValue = trim($username);

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':username' => $searchValue,
        ]); // execute the PDO statement

        $user = $statement->fetch(); // Fetch the result

        return ($user !== false); // If user is found, return true; otherwise, return false
    }

    /**
     * Updates deliverer's username and password.
     *
     * @param int $id The ID of the deliverer.
     * @param string $username The new username.
     * @param string $password The new password.
     *
     * @return void
     */
    public function updateDeliverer($id, $username, $password) {
        $sqlQuery = 'UPDATE delivery_users
                    SET username = :username, password = :password
                    WHERE id = :id';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':id' => $id,
            ':username' => $username,
            ':password' => password_hash($password, PASSWORD_BCRYPT),
        ]); // execute the PDO statement
    }

    /**
     * Updates deliverer's username without changing the password.
     *
     * @param int $id The ID of the deliverer.
     * @param string $username The new username.
     *
     * @return void
     */
    public function updateDelivererNoPassword($id, $username) {
        $sqlQuery = 'UPDATE delivery_users
                    SET username = :username
                    WHERE id = :id';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':id' => $id,
            ':username' => $username,
        ]); // execute the PDO statement
    }

    /**
     * Creates a new deliverer in the database.
     *
     * @param string $username The username of the new deliverer.
     * @param string $password The password of the new deliverer.
     * @param int $usertype The user type (deliverer) identifier.
     *
     * @return void
     */
    public function createDeliverer($username, $password, $usertype) {
        $sqlQuery = 'INSERT INTO delivery_users 
                     (username, password, usertype) 
                     VALUES (:username, :password, :usertype)';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':username' => $username,
            ':password' => password_hash($password, PASSWORD_BCRYPT),
            ':usertype' => $usertype
        ]); // execute the PDO statement
    }

    /**
     * Deletes a deliverer from the database.
     *
     * @param int $id The ID of the deliverer to be deleted.
     *
     * @return void
     */
    public function deleteDeliverer($id) {
        $sqlQuery = 'DELETE FROM delivery_users
                     WHERE id = :id';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':id' => $id
        ]); // execute the PDO statement
    }

    /**
     * Searches for users based on specific conditions and search terms.
     *
     * @param array $conditions An array of conditions to search for.
     * @param string $searchTerm The term to search for.
     *
     * @return array An array of DeliveryUserData objects matching the search.
     */
    public function searchUsers($conditions, $searchTerm)
    {
        if (!empty($conditions) && !empty($searchTerm)) {
            $sqlQuery = 'SELECT * FROM delivery_users WHERE';
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
            $dataSet[] = new DeliveryPointData($row);
        }

        return $dataSet;
    }
}
