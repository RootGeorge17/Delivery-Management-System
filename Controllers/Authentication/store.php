<?php
require_once('Models/Users/DeliveryUserDataSet.php'); // Including the DeliveryUserDataSet class

// Creating a new stdClass object to hold view-related data
$view = new stdClass();
$view->pageTitle = 'Log in';

// Initializing variables for user data and error messages
$user = [];
$errors = [];
$deliveryUserDataSet = new DeliveryUserDataSet(); // Creating an instance of DeliveryUserDataSet class

// Retrieving user input from a login form
$user['username'] = $_POST['username'];
$user['password'] = $_POST['password'];
$user['randomString'] = $_POST['randomString'];
$user['notRobot'] = $_POST['notRobot'] ?? '';

// Checking if anti-spam random bytes are stored in the session
if (isset($_SESSION['antiSpamRandomBytes'])) {
    // Verifying the submitted anti-spam string against the stored one
    if ($_POST['randomString'] == $_SESSION['antiSpamRandomBytes']) {
        // Checking if the "notRobot" checkbox is ticked
        if (isset($_POST['notRobot'])) {
            // Checking if the account exists and the credentials match
            $match = $deliveryUserDataSet->credentialsMatch($user['username'], $user['password']);

            if ($match) {
                // If credentials match, retrieve user details and perform login
                $matchUser = $deliveryUserDataSet->getUserDetails($user['username']);

                // Perform the login process
                login(
                    $matchUser['id'],
                    $matchUser['username'],
                    $matchUser['usertypeid'],
                    $matchUser['usertypename']
                );

                // Redirecting the user to the home page after successful login
                header('Location: /');
                exit();

            } else {
                // Display error message if the account doesn't exist
                $errors['NoAccount'] = "Account doesn't exist!";
                return require_once("Views/Authentication/login.phtml");
            }
        } else {
            // Display error message if the "notRobot" checkbox isn't ticked
            $errors['NoAccount'] = "Please tick the checkbox to confirm you are not a robot!";
            return require_once("Views/Authentication/login.phtml");
        }
    } else {
        // Display error message if the anti-spam string doesn't match
        $errors['NoAccount'] = "Incorrect AntiSpam String!";
        return require_once("Views/Authentication/login.phtml");
    }
} else {
    // Display error message if anti-spam information is missing from the session
    $errors['NoAccount'] = "AntiSpam information missing!";
    return require_once("Views/Authentication/login.phtml");
}



