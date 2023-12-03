<?php

require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

$deliveryPointDataSet = new DeliveryPointDataSet();
$deliveryUserDataSet = new DeliveryUserDataSet();
$errors = [];

if($_POST['type'] = 'Assign')
{
    $assignedDeliverer = $_POST['username'];
    $parcelID = $_POST['_id'];

    if($deliveryUserDataSet->checkUserExists($assignedDeliverer)) {
        $deliveryPointDataSet->assignDeliverer($parcelID, $assignedDeliverer);
    } else {
        $errors['InvalidUsername'] = "Username Not Found. Try again!";
    }
} elseif($_POST['type'] = 'Edit') {

}


require_once("Controllers/Managers/show.php");
exit();
