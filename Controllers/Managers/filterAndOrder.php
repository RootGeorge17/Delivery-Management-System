<?php

require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

$deliveryPointDataSet = new DeliveryPointDataSet();
$deliveryUserDataSet = new DeliveryUserDataSet();

if ($_SESSION['user']['currentTable'] === "Deliveries") {
    if (isset($_POST['order'])) {
        $orderBy = $_POST['order']; // Value from the order dropdown


    }

} elseif ($_SESSION['user']['currentTable'] === "Users") {

}