<?php
// Requiring necessary classes
require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

// Creating instances of classes
$deliveryPointDataSet = new DeliveryPointDataSet();
$deliveryUserDataSet = new DeliveryUserDataSet();

// Retrieving ID from the form submission
$id = $_POST['id'];

// Handling deletion based on type
if ($_POST['type'] == 'Parcel') {
    // Deleting a Parcel based on the provided ID
    $deliveryPointDataSet->deleteStatusDeliveryPoint($id);
} elseif ($_POST['type'] == 'Deliverer') {
    // Deleting a Deliverer based on the provided ID
    $deliveryUserDataSet->deleteDeliverer($id);
}

// After deletion, require the show.php controller for Managers
require_once("Controllers/Managers/show.php");
exit();
