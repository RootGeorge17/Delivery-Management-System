<?php
require_once('Models/Users/DeliveryUserDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Log in';

$user = [];
$errors = [];
$deliveryUserDataSet = new DeliveryUserDataSet();

$user['username'] = $_POST['username'];
$user['password'] = $_POST['password'];
$user['randomString'] = $_POST['randomString'];
$user['notRobot'] = $_POST['notRobot'] ?? '';

if (isset($_SESSION['antiSpamRandomBytes'])) {
    if ($_POST['randomString'] == $_SESSION['antiSpamRandomBytes']) {
        if (isset($_POST['notRobot'])) {
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

        } else {
            $errors['NoAccount'] = "Please tick the checkbox to confirm you are not a robot!";
            return require_once("Views/Authentication/login.phtml");
        }
    } else {
        $errors['NoAccount'] = "Incorrect AntiSpam String!";
        return require_once("Views/Authentication/login.phtml");
    }
} else {
    $errors['NoAccount'] = "AntiSpam information missing!";
    return require_once("Views/Authentication/login.phtml");
}



