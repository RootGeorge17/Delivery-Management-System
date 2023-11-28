<?php
require_once("Models/Core/TableData.php");

$view = new stdClass();
$view->pageTitle = 'Dashboard';

$serializedTable = $_SESSION['user']['tableData'] ?? null;
$table = unserialize($serializedTable);
$view->totalDeliveries = $table->getTotalDeliveries();
$view->totalDeliverers = $table ->getTotalDeliverers();

if($table instanceof TableData)
{
    if (isset($_POST['show_deliveries'])) {
        $_SESSION['user']['currentTable'] = "Deliveries";
        $view->currentItems = $table->getCurrentItems();
        $view->currentPage = $table->getCurrentPage();
        $view->totalPages = $table->getTotalPages();
        require_once("Views/Deliveries/manager-index.phtml");
        exit();

    }
}






