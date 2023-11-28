<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');
require_once("Models/Core/Table.php");

$view = new stdClass();
$view->pageTitle = 'Dashboard';

$serializedTable = $_SESSION['user']['tableData'] ?? null;
$table = unserialize($serializedTable);

if($table instanceof Table)
{
    $view->totalDeliveries = $table->getTotalDeliveries();
    $view->totalDeliverers = $table ->getTotalDeliverers();

    if (isset($_POST['show_deliveries'])) {
        $_SESSION['user']['currentTable'] = "Deliveries";
        $view->currentPage = $table->getCurrentPage();
        $view->totalPages = $table->getTotalPages();
        require_once("Views/Deliveries/manager-index.phtml");
        exit();

    } elseif (isset($_POST['show_deliverers'])) {


    } elseif (isset($_POST['search'])) {

    }
}






