<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');
use \Core\Pagination;

$view = new stdClass();
$view->pageTitle = 'Dashboard';
$rowsPerPage = 5;
$deliveryPointDataSet = new DeliveryPointDataSet();
$deliveryUserDataSet = new DeliveryUserDataSet();
$view->deliveryPointDataSet = $deliveryPointDataSet->fetchAllDeliveryPoints();
$view->deliveryUserDataSet = $deliveryUserDataSet->fetchAllDeliveryUsers();

if (isset($_POST['show_deliveries'])) {

    $view->totalRows = count($view->deliveryPointDataSet);
    $view->totalPages = ceil($view->totalRows / $rowsPerPage);
    $view->currentPage = $_GET['page'] ?? 1;
    $start = ($view->currentPage - 1) * $rowsPerPage;
    $currentItems = array_slice($view->deliveryPointDataSet, $start, $rowsPerPage);
    $_SESSION['user']['currentTable'] = 'Deliveries';

} elseif (isset($_POST['show_deliverers'])) {
    $view->totalRows = count($view->deliveryUserDataSet);
    $view->totalPages = ceil($view->totalRows / $rowsPerPage);
    $view->currentPage = $_GET['page'] ?? 1;
    $start = ($view->currentPage - 1) * $rowsPerPage;
    $currentItems = array_slice($view->deliveryUserDataSet, $start, $rowsPerPage);
    $_SESSION['user']['currentTable'] = 'Deliverers';

} elseif (isset($_POST['search'])) {

}

require_once("Views/Deliveries/index.phtml");
exit();


