<?php
// // Including the TableData class
require_once("Models/Core/TableData.php");

// Creating a new stdClass object to hold view-related data
$view = new stdClass();


// Setting the page title for the Home Page
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
    require_once("Views/Deliveries/index.phtml");
    exit();
}

// Creating an instance of TableData
$table = new TableData();


// Handling the case when the 'show' form is submitted
if (isset($_POST["show"])) {
    if ($_POST["show"] == 'show-deliveries') {
        // Setting the current table in session and fetching data for Deliveries
        $_SESSION['user']['currentTable'] = "Deliveries";
        $table->setDataForDeliverers($currentPage, "Deliveries", $_SESSION['user']['id']);
    }
}

// For Pagination: Handling the case when the current URL is "/"
if (isCurrentUrl("/")) {
    $_SESSION['user']['currentTable'] = "Deliveries";
    $table->setDataForDeliverers($currentPage, "Deliveries", $_SESSION['user']['id']);
}

// Check if the current URL is '/search'
if (isset($_GET['parcel'])) {
    $searchTerm = $_GET['parcel'];

    $table->displayParcelById($searchTerm, $_SESSION['user']['id']);
}

// Fetching necessary data for rendering the view
$view->totalDeliveries = $table->getTotalDeliveries();
$view->currentItems = $table->getCurrentItems();
$view->currentPage = $table->getCurrentPage();
$view->totalPages = $table->getTotalPages();

// Redirecting if the current page is out of range
redirectToRootIfOutOfRange($view->currentPage, $view->totalPages);

// Requiring the view file to render the Deliveries page
require_once("Views/Deliveries/index.phtml");
exit();
