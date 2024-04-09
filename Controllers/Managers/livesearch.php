<?php

require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

$action = $_GET["action"];
$conditions = $_GET['condition'] ?? ['id', 'name', 'postcode', 'address_1', 'address_2'];
$page = $_GET['page'];

if($action == 'search-delivery') {
    $keyword = $_GET['keyword'];
    liveSearch($keyword, $conditions, $page, 5);
}

function liveSearch($keyword, $conditions, $page, $resultsPerPage) {
    $deliveryPointDataSet = new DeliveryPointDataSet();
    $data = $deliveryPointDataSet->searchDeliveryPointsLive($conditions, $keyword, $page, $resultsPerPage);

    $json = $data;
    echo $json;
}



