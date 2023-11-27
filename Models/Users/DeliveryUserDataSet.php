<?php

require_once('Models/Infrastructure/Database.php');
require_once('Models/Users/DeliveryUserData.php');

class DeliveryUserDataSet
{
    protected $dbHandle, $dbInstance;

    public function __construct() {
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getDBConnection();
    }

    public function fetchAllDeliveryUsers() {
        $sqlQuery = 'SELECT * FROM delivery_users';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryUserData($row);
        }
        return $dataSet;
    }

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

    public function credentialsMatch($username, $password)
    {
        $sqlQuery = 'SELECT * FROM delivery_users
                     WHERE username = :username
                     AND password = :password';

        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute([
            ':username' => $username,
            ':password' => $password
        ]);

        $dataSet = [];
        while($row = $statement->fetch()) {
            $dataSet[] = new DeliveryUserData($row);
        }
        return $dataSet;
    }

    public function checkUserExists($username) {
        $sqlQuery = 'SELECT * FROM delivery_users 
         WHERE username = :username';

        $searchValue = trim($username);

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute([
            ':username' => $searchValue,
        ]); // execute the PDO statement
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryUserData($row);
        }
        return $dataSet;
    }
}
