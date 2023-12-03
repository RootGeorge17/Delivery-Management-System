<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

$deliveryPointDataSet = new DeliveryPointDataSet();
$deliveryUserDataSet = new DeliveryUserDataSet();
$id = $_POST['id'];

if($_POST['type'] == 'Parcel')
{
    $deliveryPointDataSet->deleteStatusDeliveryPoint($id);
} elseif($_POST['type'] == 'Deliverer') {
    $deliveryUserDataSet->deleteDeliverer($id);
}

require_once("Controllers/Managers/show.php");
exit();
