<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');

$conditions = $_GET['condition'] ?? ['id', 'name', 'postcode', 'address_1', 'address_2'];
$page = $_GET['page'];
$keyword = $_GET['keyword'];

liveSearch($keyword, $conditions, $page, 5);

function liveSearch($keyword, $conditions, $page, $resultsPerPage) {
    $deliveryPointDataSet = new DeliveryPointDataSet();
    $data = $deliveryPointDataSet->searchDeliveryPoints($conditions, $keyword, $page, $resultsPerPage);

    echo json_encode($data);
}



