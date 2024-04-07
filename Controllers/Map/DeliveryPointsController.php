<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');

$deliveryPointDataSet = new DeliveryPointDataSet();
$deliveryPoints = $deliveryPointDataSet->fetchAllDeliveryPointsJSON();

echo $deliveryPoints;