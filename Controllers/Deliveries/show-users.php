<?php
require_once("Models/Core/TableData.php");

$view = new stdClass();
$view->pageTitle = 'Dashboard';

$serializedTable = $_SESSION['user']['tableData'] ?? null;
$table = unserialize($serializedTable);
$view->totalDeliveries = $table->getTotalDeliveries();
$view->totalUsers = $table ->getTotalUsers();

if($table instanceof TableData)
{
    if (isset($_POST['show_deliverers'])) {
        $_SESSION['user']['currentTable'] = "Users";
        $currentPage = $_GET['page'] ?? 1;
        $table->setData($currentPage, "Users");
        $view->currentItems = $table->getCurrentItems();
        $view->currentPage = $table->getCurrentPage();
        $view->totalPages = $table->getTotalPages();

        require_once("Views/Managers/index.phtml");
        exit();
    }
}






