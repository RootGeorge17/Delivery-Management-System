<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');

$token = $_GET['token'];

if (isset($_SESSION['user']['ajaxToken'])) {
    $userToken = $_SESSION['user']['ajaxToken'];

    if (!isset($token) || $token !== $userToken) {
        $data = new stdClass();
        $data->error = "No data for you sir";
        echo json_encode($data);
        exit;
    } else {
        $deliveryPointDataSet = new DeliveryPointDataSet();
        $deliveryPoints = $deliveryPointDataSet->fetchAllDeliveryPointsForMap();
        echo json_encode($deliveryPoints);
    }
}

