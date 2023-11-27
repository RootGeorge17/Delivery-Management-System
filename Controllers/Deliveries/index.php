<?php
$view = new stdClass();
$view->pageTitle = 'Dashboard';

if (!authenticated()) {
    require_once("Views/Authentication/login.phtml");
    exit();
}

require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

$deliveryPointDataSet = new DeliveryPointDataSet();
$deliveryUserDataSet = new DeliveryUserDataSet();
$rowsPerPage = 5;

$view->deliveryPointDataSet = $deliveryPointDataSet->fetchAllDeliveryPoints();
$view->deliveryUserDataSet = $deliveryUserDataSet->fetchAllDeliveryUsers();

$view->totalRows = count($view->deliveryPointDataSet);
$view->totalPages = ceil($view->totalRows / $rowsPerPage);
$view->currentPage = $_GET['page'] ?? 1;
$start = ($view->currentPage - 1) * $rowsPerPage;
$currentItems = array_slice($view->deliveryPointDataSet, $start, $rowsPerPage);

require_once("Views/Deliveries/index.phtml");




