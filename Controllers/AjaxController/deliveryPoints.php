<?php

/**
 * PHP script to handle fetching and returning all delivery points for the Map using Ajax
 */

require_once('Models/Deliveries/DeliveryPointDataSet.php');

// Get the token from the GET request
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
            // Fetch all delivery points for the map
            $deliveryPoints = $deliveryPointDataSet->fetchAllDeliveryPointsForMap();
            // Return the delivery points as JSON
            echo json_encode($deliveryPoints);
        }

        // Handle update request for "Manager" user type
        if($_SESSION['user']['usertypename'] == "Manager")
        {
            $deliveryPointDataSet = new DeliveryPointDataSet();
            // Fetch all delivery points for the map
            $deliveryPoints = $deliveryPointDataSet->fetchAllDeliveryPointsForMap();
            // Return the delivery points as JSON
            echo json_encode($deliveryPoints);
        }
    }
}