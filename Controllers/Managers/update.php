<?php
// Requiring necessary classes
require_once('Models/Deliveries/DeliveryPointDataSet.php');

// Function to convert status text to its corresponding number
function getStatusNumber($statusWord) {
    if ($statusWord == 'Pending') {
        return '1';
    } elseif ($statusWord == 'Shipped') {
        return '2';
    } elseif ($statusWord == 'Out for delivery') {
        return '3';
    } elseif ($statusWord == 'Delivered') {
        return '4';
    }
}

// Creating an instance of DeliveryPointDataSet
$deliveryPointDataSet = new DeliveryPointDataSet();

// Retrieving data from the POST request
$id = $_POST['_id'];
$statusWord = $_POST['_status'];
$status = getStatusNumber($statusWord);

// Updating the status of a delivery point based on the received status
if ($_POST['_status'] == 'Pending' || $_POST['_status'] == 'Shipped' || $_POST['_status'] == 'Out for delivery' || $_POST['_status'] == 'Delivered') {
    $deliveryPointDataSet->updateStatusDeliveryPoint($id, $status);
}

// Including the show.php controller for Managers
require_once("Controllers/Managers/show.php");
exit();
