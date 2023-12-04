<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

$deliveryPointDataSet = new DeliveryPointDataSet();
$deliveryUserDataSet = new DeliveryUserDataSet();
$errors = [];

if($_POST['type'] == 'Deliverer') {
    // Validate data
        // Check for duplicates in username as it needs to be UNIQUE
    $delivererUsername = $_POST['username'];
    $delivererPassword = $_POST['password'];
    $delivererUserType = 2;

    $deliveryUserDataSet->createDeliverer($delivererUsername, $delivererPassword, $delivererUserType);
}

require_once("Controllers/Managers/show.php");
exit();