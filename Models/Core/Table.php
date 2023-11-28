<?php

require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

class Table
{
    protected $currentItems, $totalPages, $currentPage;
    protected $rowsPerPage = 10;

    protected $totalDeliveries;
    protected $totalDeliverers;

    public function setData($currentPage, $tableName = "null")
    {
        $deliveryPointDataSet = new DeliveryPointDataSet();
        $deliveryUserDataSet = new DeliveryUserDataSet();
        $offset = ($currentPage - 1) * $this->rowsPerPage;
        $this->totalDeliveries = $deliveryPointDataSet->fetchAllDeliveryPoints();
        $this->totalDeliverers = $deliveryUserDataSet->fetchAllDeliveryUsers();
        $this->currentPage = $currentPage;

        if ($tableName == "Deliveries") {
            $totalRows = count($this->totalDeliveries);
            $this->totalPages = ceil($totalRows / $this->rowsPerPage);
            $start = ($currentPage - 1) * $this->rowsPerPage;
            $this->currentItems = array_slice($this->totalDeliveries, $start, $this->rowsPerPage);

        } elseif ($tableName == "Users") {
            $totalRows = count($this->totalDeliverers);
            $this->totalPages = ceil($totalRows / $this->rowsPerPage);
            $start = ($currentPage - 1) * $this->rowsPerPage;
            $this->currentItems = array_slice($this->totalDeliverers, $start, $this->rowsPerPage);
        }
    }

    public function getCurrentItems ()
    {
        return $this->currentItems;
    }

    public function getTotalPages()
    {
        return $this->totalPages;
    }

    public function getTotalDeliveries()
    {
        return $this->totalDeliveries;
    }

    public function getTotalDeliverers()
    {
        return $this->totalDeliverers;
    }
    public function getCurrentPage()
    {
        return $this->currentPage;
    }
}