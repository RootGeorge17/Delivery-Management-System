<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Dashboard';
$rowsPerPage = 20;
$deliveryPointDataSet = new DeliveryPointDataSet();
$view->deliveryPointDataSet = $deliveryPointDataSet->fetchDeliverersDeliveryPoints($_SESSION['user']['id']);
$view->totalRows = count($view->deliveryPointDataSet);
$view->totalPages = ceil($view->totalRows / $rowsPerPage);
$view->currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($view->currentPage - 1) * $rowsPerPage;
$currentItems = array_slice($view->deliveryPointDataSet, $start, $rowsPerPage);

if (!authenticated()) {
    require_once("Views/Authentication/login.phtml");
    exit();
}

if($_SESSION['user']['usertypename'] == "Deliverer")
{

} else {
    $deliveryUserDataSet = new DeliveryUserDataSet();

    $view->deliveryPointDataSet = $deliveryPointDataSet->fetchAllDeliveryPoints();
    $view->deliveryUserDataSet = $deliveryUserDataSet->fetchAllDeliveryUsers();
}

require_once("Views/Deliveries/index.phtml");
exit();



