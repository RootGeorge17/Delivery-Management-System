<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Dashboard';
$rowsPerPage = 20;

if (isset($_POST['show_deliveries'])) {
    $deliveryPointDataSet = new DeliveryPointDataSet();
    $deliveryUserDataSet = new DeliveryUserDataSet();

    $view->deliveryPointDataSet = $deliveryPointDataSet->fetchAllDeliveryPoints();
    $view->currentItems = $_POST['currentItems'];

    $view->deliveryPointDataSet = $deliveryPointDataSet->fetchAllDeliveryPoints();
    $view->deliveryUserDataSet = $deliveryUserDataSet->fetchAllDeliveryUsers();


} elseif (isset($_POST['show_deliverers'])) {

}

require_once("Views/Deliveries/index.phtml");
exit();


