<?php

require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

$deliveryPointDataSet = new DeliveryPointDataSet();
$deliveryUserDataSet = new DeliveryUserDataSet();
$searchTerm = $_POST['search'] ?? '';
$searchColumns = [];

if ($_SESSION['user']['currentTable'] === "Deliveries") {
    if (isset($_POST['parcelID'])) {
        $searchColumns[] = 'id';
    }
    if (isset($_POST['recipientName'])) {
        $searchColumns[] = 'name';
    }
    if (isset($_POST['postcode'])) {
        $searchColumns[] = 'postcode'; //
    }
    if (isset($_POST['address'])) {
        $searchColumns[] = 'address_1';
        $searchColumns[] = 'address_2';
    }
    $deliveryPointDataSet->searchDeliveryPoints($searchColumns, $searchTerm);

} elseif ($_SESSION['user']['currentTable'] === "Users") {
    if (isset($_POST['userID'])) {
        $searchColumns[] = 'id';
    }
    if (isset($_POST['username'])) {
        $searchColumns[] = 'username';
    }
}



require_once("Controllers/Managers/show.php");
exit();








