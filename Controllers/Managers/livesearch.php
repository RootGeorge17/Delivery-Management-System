<?php

/*
require_once('Models/Core/Database.php');

$results = 'abc';

try {
    $response = array(
        'success' => true,
        'data' => $results
    );
} catch (Exception $e) {
    $response = array(
        'success' => false,
        'message' => $e->getMessage()
    );
}

header('Content-Type: application/json');
echo json_encode($response);
*/

require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

if(isset($_GET["action"])) {
    $action = $_GET["action"];

    if($action == 'search-delivery') {
        $keyword = $_GET['keyword'];
        liveSearch($keyword);
    }
}

function liveSearch($keyword) {
    $deliveryPointDataSet = new DeliveryPointDataSet();
    $data = $deliveryPointDataSet->searchDeliveryPoints(['name'], $keyword);

    header('Content-Type: application/json');
    $json = $data;
    echo $json;
}


