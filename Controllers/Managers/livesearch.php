<?php

require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

$action = $_GET["action"];

if($action == 'search-delivery') {
    $keyword = $_GET['keyword'];
    liveSearch($keyword);
}

function liveSearch($keyword) {
    $conditions = $_GET['condition'] ?? ['id', 'name', 'postcode', 'address_1', 'address_2'];
    $deliveryPointDataSet = new DeliveryPointDataSet();
    $data = $deliveryPointDataSet->searchDeliveryPointsLive($conditions, $keyword);
    
    $json = $data;
    echo $json;
}



