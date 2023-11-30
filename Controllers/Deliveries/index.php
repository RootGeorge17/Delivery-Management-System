<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');
require_once("Models/Core/TableData.php");

$view = new stdClass();
$view->pageTitle = 'Dashboard';

if (!authenticated()) {
    require_once("Views/Authentication/login.phtml");
    exit();
}

$table = new TableData;

if ($_SESSION['user']['usertypename'] == "Manager")
{
    if(isCurrentUrl("/") || isCurrentUrl("/deliveries"))
    {
        $_SESSION['user']['currentTable'] = "Deliveries";
        $currentPage = $_GET['page'] ?? 1;
        $table->setData($currentPage, "Deliveries");
        $view->totalDeliveries = $table->getTotalDeliveries();
        $view->totalUsers = $table->getTotalUsers();

        $view->currentItems = $table->getCurrentItems();
        $view->currentPage = $table->getCurrentPage();
        $view->totalPages = $table->getTotalPages();
    } elseif (isCurrentUrl("/users"))
    {
        $_SESSION['user']['currentTable'] = "Users";
        $currentPage = $_GET['page'] ?? 1;
        $table->setData($currentPage, "Users");
        $view->totalDeliveries = $table->getTotalDeliveries();
        $view->totalUsers = $table->getTotalUsers();

        $view->currentItems = $table->getCurrentItems();
        $view->currentPage = $table->getCurrentPage();
        $view->totalPages = $table->getTotalPages();
    }
    $_SESSION['user']['tableData'] = serialize($table);
    require_once("Views/Managers/index.phtml");
}




