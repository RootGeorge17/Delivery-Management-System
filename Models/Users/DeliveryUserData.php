<?php

/**
 * Class DeliveryUserData
 * Represents user data related to delivery operations.
 */
class DeliveryUserData
{
    /**
     * @var int The user ID.
     */
    /**
     * @var string The username of the user.
     */
    /**
     * @var string The password of the user.
     */
    /**
     * @var string The user type associated with the user.
     */
    protected $id, $username, $password, $usertype;

    /**
     * DeliveryUserData constructor.
     * Initializes user data based on the provided database row.
     *
     * @param array $dbRow An associative array representing user data from the database.
     */
    public function __construct($dbRow)
    {
        $this->id = $dbRow['id'];
        $this->username = $dbRow['username'];
        $this->password = $dbRow['password'];
        $this->usertype = $dbRow['usertype'];
    }

    /**
     * Retrieves the user's ID.
     *
     * @return int The user ID.
     */
    public function getUserID()
    {
        return $this->id;
    }

    /**
     * Retrieves the username of the user.
     *
     * @return string The username.
     */
    public function getUserUsername()
    {
        return $this->username;
    }

    /**
     * Retrieves the password of the user.
     *
     * @return string The password.
     */
    public function getUserPassword()
    {
        return $this->password;
    }

    /**
     * Retrieves the user type associated with the user.
     *
     * @return string The user type.
     */
    public function getUserUserType()
    {
        return $this->usertype;
    }
}