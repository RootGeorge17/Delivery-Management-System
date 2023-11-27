<?php
require_once('Models/Users/DeliveryUserDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Log in';

$user = [];
$errors = [];
$deliveryUserDataSet = new DeliveryUserDataSet();

$user['username'] = $_POST['username'];
$user['password'] = $_POST['password'];

// Check if the account exists and match credentials
$match = $deliveryUserDataSet->credentialsMatch($user['username'], $user['password']);

if ($match) {
    $matchUser = $deliveryUserDataSet->getUserDetails($user['username']);

    login(
        $matchUser['id'],
        $matchUser['username'],
        $matchUser['usertypeid'],
        $matchUser['usertypename']
    );

    header('Location: /');
    exit();

} else {
    $errors['NoAccount'] = "Account doesn't exist!";
    return require_once("Views/Authentication/login.phtml");
}

