<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Dashboard';
$rowsPerPage = 20;

if (isset($_POST['show_deliveries'])) {

} elseif (isset($_POST['show_deliverers'])) {

} elseif (isset($_POST['search'])) {
    $view->deliveryPointDataSet = $deliveryPointDataSet->searchDeliveryPoints($_POST['search'], $_SESSION['user']['id']);
    $currentItems = array_slice($view->deliveryPointDataSet, $start, $rowsPerPage);
}

require_once("Views/Deliveries/index.phtml");
exit();


