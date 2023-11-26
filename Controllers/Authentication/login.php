<?php
require_once('Models/Users/DeliveryUserDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Log in';

$user = [];
$errors = [];
$deliveryUserDataSet = new DeliveryUserDataSet();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $user['username'] = $_POST['username'];
    $user['password'] = $_POST['password'];

    // Check if the account exists and match credentials
    $match = $deliveryUserDataSet->credentialsMatch($user['username'], $user['password']);
    $user['id'] = $deliveryUserDataSet->getUserID($user['username']);

    if($match)
    {
        login($user['username'], $user['id']);

        header('Location: /');
        exit();

    } else {
        $errors['NoAccount'] = "Account doesn't exist!";
    }
}

require_once("Views/Authentication/login.phtml");
