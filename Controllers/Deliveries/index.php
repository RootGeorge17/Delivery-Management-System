<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');
require_once("Models/Core/Table.php");

$view = new stdClass();
$view->pageTitle = 'Dashboard';

if (!authenticated()) {
    require_once("Views/Authentication/login.phtml");
    exit();
}

$table = new Table;

if ($_SESSION['user']['usertypename'] == "Manager")
{
    $currentPage = $_GET['page'] ?? 1;
    $table->setData($currentPage, "Deliveries");
    $view->totalDeliveries = $table->getTotalDeliveries();
    $view->totalDeliverers = $table->getTotalDeliverers();

    $view->currentPage = $table->getCurrentPage();
    $view->totalPages = $table->getTotalPages();

    $_SESSION['user']['tableData'] = serialize($table);
    require_once("Views/Deliveries/manager-index.phtml");
}




