<?php

/**
 * PHP script to handle fetching and returning a single delivery point based on latitude and longitude for AJAX Map Transactions
 */

require_once('Models/Deliveries/DeliveryPointDataSet.php');

// Get latitude, longitude, and token from the GET request
$lat = $_GET['lat'];
$lng = $_GET['lng'];
$token = $_GET['token'];


// My router already checks for if user is logged in for extra security
if (isset($_SESSION['user']['ajaxToken'])) {
    $userToken = $_SESSION['user']['ajaxToken'];

    // Check if the provided token matches the user's token
    if (!isset($token) || $token !== $userToken) {
        $data = new stdClass();
        $data->error = "No data for you sir";
        echo json_encode($data);
        exit;
    } else {
        // Handle update request for "Deliverer" user type
        if($_SESSION['user']['usertypename'] == "Deliverer") {
            $deliveryPointDataSet = new DeliveryPointDataSet();
            // Fetch the delivery point by latitude and longitude
            $deliveryPoint = $deliveryPointDataSet->fetchDeliveryPointByLatLng($lat, $lng);
            // Check if the delivery point has been delivered
            $isDelivered = $deliveryPointDataSet->isDelivered($deliveryPoint);
            // Return the delivery status as JSON, if not delivered, else an error fill be returned as JSON
            echo json_encode($isDelivered);
        }

        // Handle update request for "Manager" user type
        if($_SESSION['user']['usertypename'] == "Manager")
        {
            $deliveryPointDataSet = new DeliveryPointDataSet();
            // Fetch the delivery point by latitude and longitude
            $deliveryPoint = $deliveryPointDataSet->fetchDeliveryPointByLatLng($lat, $lng);
            // Check if the delivery point has been delivered
            $isDelivered = $deliveryPointDataSet->isDelivered($deliveryPoint);
            // Return the delivery status as JSON, if not delivered, else an error fill be returned as JSON
            echo json_encode($isDelivered);
        }
    }
}