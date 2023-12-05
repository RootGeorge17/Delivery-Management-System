<?php
// Creating a new stdClass object to hold view-related data
$view = new stdClass();
$view->pageTitle = 'Dashboard';

// Check if the user is not authenticated
if (!authenticated()) {
    // Redirect to the login page if not authenticated
    header('location: /login');
    exit();
}

// If authenticated, include the show.php controller for Deliverers
require_once("Controllers/Deliverers/show.php");
exit();





