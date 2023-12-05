<?php
require_once('Models/Deliveries/DeliveryPointDataSet.php');
require_once('Models/Users/DeliveryUserDataSet.php');

/**
 * Class TableData
 *
 * Manages data for tables including pagination, search, and fetching operations.
 */
class TableData
{
    // Properties
    protected $currentItems, $totalPages, $currentPage;
    protected $rowsPerPage = 10;
    protected $totalDeliveries;
    protected $totalUsers;
    static $table;

    /**
     * Sets data for managers' view based on table name and current page.
     *
     * @param int $currentPage The current page number.
     * @param string $tableName The name of the table.
     */
    public function setDataForManagers($currentPage, $tableName)
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

    /**
     * Sets data for deliverers' view based on table name, current page, and deliverer.
     *
     * @param int $currentPage The current page number.
     * @param string $tableName The name of the table.
     * @param int $deliverer The deliverer ID.
     */
    public function setDataForDeliverers($currentPage, $tableName, $deliverer)
    {
        $deliveryPointDataSet = new DeliveryPointDataSet();
        $offset = ($currentPage - 1) * $this->rowsPerPage;
        $this->totalDeliveries = $deliveryPointDataSet->fetchUserDeliveryPoints($deliverer);
        $this->currentPage = $currentPage;

        if ($tableName == "Deliveries") {
            $totalRows = count($this->totalDeliveries);
            $this->totalPages = ceil($totalRows / $this->rowsPerPage);
            $start = ($currentPage - 1) * $this->rowsPerPage;
            $this->currentItems = array_slice($this->totalDeliveries, $start, $this->rowsPerPage);
        }
    }

    /**
     * Searches delivery points based on specified conditions and search term.
     *
     * @param int $currentPage The current page number.
     * @param string $tableName The name of the table.
     * @param array $conditions The search conditions.
     * @param string $searchTerm The term to search for.
     * @param string $table The table being accessed.
     * @return array The current items matching the search criteria.
     */
    public function searchDeliveryPoints($currentPage, $tableName, $conditions, $searchTerm, $table)
    {
        self::$table = $table;
        $deliveryPointDataSet = new DeliveryPointDataSet();
        $deliveryUserDataSet = new DeliveryUserDataSet();
        $this->currentPage = $currentPage;
        $this->totalDeliveries = $deliveryPointDataSet->searchDeliveryPoints($conditions, $searchTerm);
        $this->totalUsers = $deliveryUserDataSet->fetchAllDeliveryUsers();
        $this->currentPage = $currentPage;

        $totalRows = count($this->totalDeliveries);
        $this->totalPages = ceil($totalRows / $this->rowsPerPage);
        $start = ($currentPage - 1) * $this->rowsPerPage;
        $this->currentItems = array_slice($this->totalDeliveries, $start, $this->rowsPerPage);
        return $this->currentItems;
    }

    /**
     * Searches users based on specified conditions and search term.
     *
     * @param int $currentPage The current page number.
     * @param string $tableName The name of the table.
     * @param array $conditions The search conditions.
     * @param string $searchTerm The term to search for.
     * @param string $table The table being accessed.
     * @return array The current items matching the search criteria.
     */
    public function searchUsers($currentPage, $tableName, $conditions, $searchTerm, $table)
    {
        self::$table = $table;
        $deliveryPointDataSet = new DeliveryPointDataSet();
        $deliveryUserDataSet = new DeliveryUserDataSet();
        $this->currentPage = $currentPage;
        $this->totalDeliveries = $deliveryUserDataSet->searchUsers($conditions, $searchTerm);
        $this->totalUsers = $deliveryUserDataSet->fetchAllDeliveryUsers();
        $this->currentPage = $currentPage;

        $totalRows = count($this->totalDeliveries);
        $this->totalPages = ceil($totalRows / $this->rowsPerPage);
        $start = ($currentPage - 1) * $this->rowsPerPage;
        $this->currentItems = array_slice($this->totalDeliveries, $start, $this->rowsPerPage);
        return $this->currentItems;
    }

    /**
     * Returns the table being accessed.
     *
     * @return string The table name.
     */
    public static function getTable()
    {
        return self::$table;
    }

    /**
     * Returns the current items for display.
     *
     * @return array The current items for display.
     */
    public function getCurrentItems()
    {
        return $this->currentItems;
    }

    /**
     * Returns the total number of pages for pagination.
     *
     * @return int The total number of pages.
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /**
     * Returns the total number of deliveries.
     *
     * @return array The total number of deliveries.
     */
    public function getTotalDeliveries()
    {
        return $this->totalDeliveries;
    }

    /**
     * Returns the total number of users.
     *
     * @return array The total number of users.
     */
    public function getTotalUsers()
    {
        return $this->totalUsers;
    }

    /**
     * Returns the current page number.
     *
     * @return int The current page number.
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }
}