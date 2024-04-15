<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');

$lat = $_GET['lat'];
$lng = $_GET['lng'];
$token = $_GET['token'];


// My router already checks for if user is logged in for extra security
if (isset($_SESSION['user']['ajaxToken'])) {
    $userToken = $_SESSION['user']['ajaxToken'];

    if (!isset($token) || $token !== $userToken) {
        $data = new stdClass();
        $data->error = "No data for you sir";
        echo json_encode($data);
        exit;
    } else {
        $deliveryPointDataSet = new DeliveryPointDataSet();
        $deliveryPoint = $deliveryPointDataSet->fetchDeliveryPointByLatLng($lat, $lng);
        $isDelivered = $deliveryPointDataSet->isDelivered($deliveryPoint);
        echo json_encode($isDelivered);
    }
}