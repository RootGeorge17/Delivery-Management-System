<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');

$deliveryPointDataSet = new DeliveryPointDataSet();
$id = $_POST['id'];

if($_POST['type'] == 'Parcel')
{
    $deliveryPointDataSet->deleteStatusDeliveryPoint($id);
}

require_once("Controllers/Managers/show.php");
exit();
