<?php

require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

class Dashboard
{
    protected $deliveryPointDataSet, $deliveryUserDataSet;

    public function __construct()
    {
        $this->deliveryPointDataSet = new DeliveryPointDataSet();
        $this->deliveryUserDataSet = new DeliveryUserDataSet();
    }

    public function fetchDeliveryStatistics(): array
    {
        return $this->deliveryPointDataSet->fetchAllDeliveryPoints();
    }

    public function fetchAllUsers(): array
    {
        return $this->deliveryUserDataSet->fetchAllDeliveryUsers();
    }

    public function showTable($totalArray, $rowsPerPage)
    {
        $totalRows = count($totalArray);
        $totalPages = ceil($totalRows / $rowsPerPage);
        $currentPage = $_GET['page'] ?? 1;
        $start = ($currentPage - 1) * $rowsPerPage;
        $currentItems = array_slice($totalArray, $start, $rowsPerPage);

        return [
            'currentItems' => $currentItems,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalRows' => $totalRows
        ];
    }

    public function displayData($totalArray, $currentPage, $rowsPerPage, $currentTable)
    {
        $totalRows = count($totalArray);
        $totalPages = ceil($totalRows / $rowsPerPage);
        $start = ($currentPage - 1) * $rowsPerPage;
        $currentItems = array_slice($totalArray, $start, $rowsPerPage);

        return [
            'currentItems' => $currentItems,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalRows' => $totalRows,
            'currentTable' => $currentTable
        ];
    }
}