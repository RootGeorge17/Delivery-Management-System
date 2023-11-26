<?php

class DeliveryUserData
{
    protected $id, $username, $password, $usertype;

    public function __construct($dbRow)
    {
        $this->id = $dbRow['id'];
        $this->username = $dbRow['username'];
        $this->password = $dbRow['password'];
        $this->usertype = $dbRow['usertype'];
    }

    public function getUserID()
    {
        return $this->id;
    }

    public function getUserUsername()
    {
        return $this->username;
    }

    public function getUserPassword()
    {
        return $this->password;
    }

    public function getUserUserType()
    {
        return $this->usertype;
    }
}