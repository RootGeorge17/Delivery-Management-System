<?php

require_once("Models/Core/TableData.php");

// Creating an instance of TableData
$table = new TableData();

// Get search term and current page from POST and GET requests respectively
$searchTerm = $_POST['search'] ?? '';
$currentPage = $_GET['page'] ?? 1;


// Check the current table in session and perform search accordingly
if ($_SESSION['user']['currentTable'] === "Deliveries") {
    // Define search columns based on received POST parameters
    $searchColumns = [];
    if (isset($_POST['parcelID'])) {
        $searchColumns[] = 'id';
    }
    if (isset($_POST['recipientName'])) {
        $searchColumns[] = 'name';
    }
    if (isset($_POST['postcode'])) {
        $searchColumns[] = 'postcode';
    }
    if (isset($_POST['address'])) {
        $searchColumns[] = 'address_1';
        $searchColumns[] = 'address_2';
    }

    // Perform search for delivery points using TableData instance
    $table->searchDeliveryPoints($currentPage, "Deliveries", $searchColumns, $searchTerm, $table);
    $_SESSION['user']['searched'] = true;

}

// Include controller for showing search results
require_once("Controllers/Deliverers/show.php");
exit();
