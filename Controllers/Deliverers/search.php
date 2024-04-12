<?php

require_once("Models/Core/TableData.php");

// Creating an instance of TableData
$table = new TableData();

// Get search term and current page from POST and GET requests respectively
$searchTerm = $_POST['search'] ?? '';
$currentPage = $_GET['page'] ?? 1;

// Check the current table in session and perform search accordingly
if (isset($_POST['filters'])) {
    // Define search columns based on received POST parameters
    if (in_array('id', $_POST['filters'])) {
        $searchColumns[] = 'id';
    }
    if (in_array('name', $_POST['filters'])) {
        $searchColumns[] = 'name';
    }
    if (in_array('postcode', $_POST['filters'])) {
        $searchColumns[] = 'postcode';
    }
    if (in_array('address_1', $_POST['filters'])) {
        $searchColumns[] = 'address_1';
        $searchColumns[] = 'address_2';
    }

    // Perform search for delivery points using TableData instance
    $table->searchDeliveryPoints($currentPage, "Deliveries", $searchColumns, $searchTerm, $table);
    $_SESSION['user']['searched'] = true;
} else {
    $searchColumns = ['id', 'name', 'postcode', 'address_1', 'address_2'];
    $table->searchDeliveryPoints($currentPage, "Deliveries", $searchColumns, $searchTerm, $table);
    $_SESSION['user']['searched'] = true;
}

// Include controller for showing search results
require_once("Controllers/Deliverers/show.php");
exit();
