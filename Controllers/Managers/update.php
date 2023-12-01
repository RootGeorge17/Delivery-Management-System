<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');

function getStatusNumber($statusWord) {
    if($statusWord == 'Pending') {return $status = '1';}
    elseif($statusWord == 'Shipped') {return $status = '2';}
    elseif($statusWord == 'Out for delivery') {return $status = '3';}
    elseif($statusWord == 'Delivered') {return $status = '4';}
}

$deliveryPointDataSet = new DeliveryPointDataSet();
$id = $_POST['_id'];
$statusWord = $_POST['_status'];

if($_POST['_status'] == 'Pending')
{
    $status = getStatusNumber($statusWord);
    $deliveryPointDataSet->updateStatusDeliveryPoint($id, $status);
} elseif($_POST['_status'] == 'Shipped') {
    $status = getStatusNumber($statusWord);
    $deliveryPointDataSet->updateStatusDeliveryPoint($id, $status);
} elseif($_POST['_status'] == 'Out for delivery') {
    $status = getStatusNumber($statusWord);
    $deliveryPointDataSet->updateStatusDeliveryPoint($id, $status);
} elseif($_POST['_status'] == 'Delivered') {
    $status = getStatusNumber($statusWord);
    $deliveryPointDataSet->updateStatusDeliveryPoint($id, $status);
}

require_once("Controllers/Managers/show.php");
exit();
