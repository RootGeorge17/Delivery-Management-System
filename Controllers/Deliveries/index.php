<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Deliveries';

$rowsPerPage = 10;
$deliveryPointDataSet = new DeliveryPointDataSet();

$view->deliveryPointDataSet = $deliveryPointDataSet->fetchAllDeliveryPoints($_SESSION['user']['id']);
$view->totalRows = count($view->deliveryPointDataSet);
$view->totalPages = ceil($view->totalRows / $rowsPerPage);
$view->currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($view->currentPage - 1) * $rowsPerPage;
$currentItems = array_slice($view->deliveryPointDataSet, $start, $rowsPerPage);

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $view->deliveryPointDataSet = $deliveryPointDataSet->searchDeliveryPoints($_POST['search'], $_SESSION['user']['id']);
    $currentItems = array_slice($view->deliveryPointDataSet, $start, $rowsPerPage);
}

require_once("Views/Deliveries/index.phtml");