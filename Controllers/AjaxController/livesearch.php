<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');

$conditions = $_GET['condition'] ?? ['id', 'name', 'postcode', 'address_1', 'address_2'];
$page = $_GET['page'];
$keyword = $_GET['keyword'];
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
        liveSearch($keyword, $conditions, $page, 5);
    }
}

function liveSearch($keyword, $conditions, $page, $resultsPerPage) {
    $deliveryPointDataSet = new DeliveryPointDataSet();
    $data = $deliveryPointDataSet->searchDeliveryPointsLive($conditions, $keyword, $page, $resultsPerPage);

    echo json_encode($data);
}



