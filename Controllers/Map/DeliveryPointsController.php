<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');

$deliveryPointDataSet = new DeliveryPointDataSet();
$deliveryPoints = $deliveryPointDataSet->fetchAllDeliveryPointsForMap();

echo json_encode($deliveryPoints);