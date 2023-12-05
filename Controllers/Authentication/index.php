<?php
// Creating a new stdClass object to hold view-related data
$view = new stdClass();
$view->pageTitle = 'Log in'; // Setting the page title for the login page

// Check if the user is not authenticated
if (!authenticated()) {
    // If not authenticated, include an Antispam class and generate random bytes for anti-spam purposes
    // and require the login view to display the login form
    require_once('Models/Core/Antispam.php');
    $antiSpam = new AntiSpam();
    $_SESSION['antiSpamRandomBytes'] = $antiSpam::getRandomBytes();

    require_once("Views/Authentication/login.phtml");
    exit();
}

// If the user is authenticated, redirect them to the home page
header('location: /');
exit();

