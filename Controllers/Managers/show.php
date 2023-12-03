<?php
require_once("Models/Core/TableData.php");

$view = new stdClass();
$table = new TableData();
$view->pageTitle = 'Dashboard';
$currentPage = $_GET['page'] ?? 1;

if (isset($_POST["show"])) {
    if ($_POST["show"] == 'show-deliveries') {
        $_SESSION['user']['currentTable'] = "Deliveries";
        $table->setData($currentPage, "Deliveries");
    } elseif ($_POST["show"] == 'show-users') {
        $_SESSION['user']['currentTable'] = "Users";
        $table->setData($currentPage, "Users");
    }
}

// For Pagination
if(isCurrentUrl("/")) {
    $_SESSION['user']['currentTable'] = "Deliveries";
    $table->setData($currentPage, "Deliveries");
} elseif (isCurrentUrl("/users")) {
    $_SESSION['user']['currentTable'] = "Users";
    $table->setData($currentPage, "Users");
}

// Fetch necessary data and render the view
$view->totalDeliveries = $table->getTotalDeliveries();
$view->totalUsers = $table->getTotalUsers();
$view->currentItems = $table->getCurrentItems();
$view->currentPage = $table->getCurrentPage();
$view->totalPages = $table->getTotalPages();

require_once("Views/Managers/index.phtml");
exit();








