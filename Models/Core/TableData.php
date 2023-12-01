<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

class TableData
{
    protected $currentItems, $totalPages, $currentPage;
    protected $rowsPerPage = 10;
    protected $totalDeliveries;
    protected $totalUsers;

    public function setData($currentPage, $tableName)
    {
        $deliveryPointDataSet = new DeliveryPointDataSet();
        $deliveryUserDataSet = new DeliveryUserDataSet();
        $offset = ($currentPage - 1) * $this->rowsPerPage;
        $this->totalDeliveries = $deliveryPointDataSet->fetchAllDeliveryPoints();
        $this->totalUsers = $deliveryUserDataSet->fetchAllDeliveryUsers();
        $this->currentPage = $currentPage;

        if ($tableName == "Deliveries") {
            $totalRows = count($this->totalDeliveries);
            $this->totalPages = ceil($totalRows / $this->rowsPerPage);
            $start = ($currentPage - 1) * $this->rowsPerPage;
            $this->currentItems = array_slice($this->totalDeliveries, $start, $this->rowsPerPage);

        } elseif ($tableName == "Users") {
            $totalRows = count($this->totalUsers);
            $this->totalPages = ceil($totalRows / $this->rowsPerPage);
            $start = ($currentPage - 1) * $this->rowsPerPage;
            $this->currentItems = array_slice($this->totalUsers, $start, $this->rowsPerPage);
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

    public function getTotalUsers()
    {
        return $this->totalUsers;
    }
    public function getCurrentPage()
    {
        return $this->currentPage;
    }
}