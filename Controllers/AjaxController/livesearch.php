<?php

/**
 * PHP script to handle the live search functionality for delivery points for Ajax transaction
 */

require_once('Models/Deliveries/DeliveryPointDataSet.php');

// Get the search conditions, page number, searched keyword, and token from the GET request
$conditions = $_GET['condition'] ?? ['id', 'name', 'postcode', 'address_1', 'address_2'];
$page = $_GET['page'];
$keyword = $_GET['keyword'];
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
        // Call the liveSearch function with the provided parameters
        liveSearch($keyword, $conditions, $page, 5);
    }
}

/**
 * Performs a live search for delivery points based on the provided keyword, conditions, page, and results per page.
 *
 * @param string $keyword The search keyword.
 * @param array $conditions An array of search conditions.
 * @param int $page The page number for pagination.
 * @param int $resultsPerPage The number of results to return per page.
 */
function liveSearch($keyword, $conditions, $page, $resultsPerPage) {
    // Handle update request for "Deliverer" user type
    if($_SESSION['user']['usertypename'] == "Deliverer") {
        $deliveryPointDataSet = new DeliveryPointDataSet();
        $data = $deliveryPointDataSet->searchDeliveryPointsLive($conditions, $keyword, $page, $resultsPerPage);

        echo json_encode($data);
    }

    // Handle update request for "Manager" user type
    if($_SESSION['user']['usertypename'] == "Manager")
    {
        $deliveryPointDataSet = new DeliveryPointDataSet();
        $data = $deliveryPointDataSet->searchDeliveryPointsLive($conditions, $keyword, $page, $resultsPerPage);

        echo json_encode($data);
    }
}