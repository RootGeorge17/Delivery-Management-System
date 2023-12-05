<?php
// Including necessary files
require_once("Models/Core/TableData.php");

// Creating a new stdClass object to hold view-related data
$view = new stdClass();

// Setting the page title for the home page
$view->pageTitle = 'Dashboard';

// Retrieving the current page number from the URL query parameter
$currentPage = $_GET['page'] ?? 1;

// Check if a search has been performed
if ($_SESSION['user']['searched']) {
    TableData::getTable();
    $view->totalDeliveries = $table->getTotalDeliveries();
    $view->totalUsers = $table->getTotalUsers();
    $view->currentItems = $table->getCurrentItems();
    $view->currentPage = $table->getCurrentPage();
    $view->totalPages = $table->getTotalPages();

    // Render the view for Managers' dashboard with search results
    require_once("Views/Managers/index.phtml");
    exit();
}

// Creating an instance of TableData
$table = new TableData();

// Handling the case when the 'show' form is submitted
if (isset($_POST["show"])) {
    // Handling the case when the 'show_deliveries' form is submitted
    if ($_POST["show"] == 'show-deliveries') {
        // Set current table in session and fetch data for Deliveries
        $table->SetDataForManagers($currentPage, "Deliveries");
    } elseif ($_POST["show"] == 'show-users') {
        // Set current table in session and fetch data for Users
        $table->SetDataForManagers($currentPage, "Users");
    }
}

// For Pagination: Handling different URL cases
if (isCurrentUrl("/")) {
    // Set current table in session and fetch data for Deliveries
    $_SESSION['user']['currentTable'] = "Deliveries";
    $table->SetDataForManagers($currentPage, "Deliveries");
} elseif (isCurrentUrl("/users")) {
    // Set current table in session and fetch data for Users
    $_SESSION['user']['currentTable'] = "Users";
    $table->SetDataForManagers($currentPage, "Users");
}


// Fetching necessary data for rendering the view
$view->totalDeliveries = $table->getTotalDeliveries();
$view->totalUsers = $table->getTotalUsers();
$view->currentItems = $table->getCurrentItems();
$view->currentPage = $table->getCurrentPage();
$view->totalPages = $table->getTotalPages();

// Redirecting if the current page is out of range
redirectToRootIfOutOfRange($view->currentPage, $view->totalPages);

// Requiring the view file to render the Managers' dashboard
require_once("Views/Managers/index.phtml");
exit();
