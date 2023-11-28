<?php

$view = new stdClass();
$view->pageTitle = 'Dashboard';

if (!authenticated()) {
    require_once("Views/Authentication/login.phtml");
    exit();
}

require_once("Models/Core/Dashboard.php");

$dashboard = new Dashboard();
$view->totalDeliveries = $dashboard->fetchAllDeliveries();
$view->totalDeliverers = $dashboard->fetchAllUsers();

$rowsPerPage = 10;

$currentPage = $_GET['page'] ?? 1;
$tableData = $dashboard->displayData($view->totalDeliveries, $currentPage, $rowsPerPage, 'Deliveries');
$view->deliveriesTable = $tableData['currentItems'];
$view->currentPage = $tableData['currentPage'];
$view->totalPages = $tableData['totalPages'];
$view->totalRows = $tableData['totalRows'];
$_SESSION['user']['currentTable'] = $tableData['currentTable'];

require_once("Views/Deliveries/index.phtml");


