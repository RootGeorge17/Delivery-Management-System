<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');
require_once("Models/Core/Dashboard.php");

$view = new stdClass();
$view->pageTitle = 'Dashboard';
$dashboard = new Dashboard();
$view->totalDeliveries = $dashboard->fetchDeliveryStatistics();
$view->totalDeliverers = $dashboard->fetchAllUsers();

$rowsPerPage = 10;

if (isset($_POST['show_deliveries'])) {
    $currentPage = $_GET['page'] ?? 1;
    $tableData = $dashboard->displayData($view->totalDeliveries, $currentPage, $rowsPerPage, 'Deliveries');
} elseif (isset($_POST['show_deliverers'])) {
    $currentPage = $_GET['page'] ?? 1;
    $tableData = $dashboard->displayData($view->totalDeliverers, $currentPage, $rowsPerPage, 'Deliverers');
} elseif (isset($_POST['search'])) {

}

$view->deliveriesTable = $tableData['currentItems'];
$view->currentPage = $tableData['currentPage'];
$view->totalPages = $tableData['totalPages'];
$view->totalRows = $tableData['totalRows'];
$_SESSION['user']['currentTable'] = $tableData['currentTable'];

require_once("Views/Deliveries/index.phtml");
exit();


