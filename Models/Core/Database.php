<?php

/**
 * Class Database
 *
 * Represents a database connection using PDO.
 */
class Database
{
    /**
     * @var Database|null Singleton instance of the Database class.
     */
    protected static $dbInstance = null;

    /**
     * @var PDO Database connection handle.
     */
    protected $dbHandle;

    /**
     * Get an instance of the Database class (singleton pattern).
     *
     * @return Database Singleton instance of the Database class.
     */
    public static function getInstance()
    {
        $config = require_once('config.php');

        if (self::$dbInstance === null) {
            self::$dbInstance = new self($config['database'], $username = 'sgc017', $password = 'LF3VbFtiP4UX6Cy');
        }

        return self::$dbInstance;
    }

    /**
     * Constructor to establish a database connection.
     *
     * @param array  $config   Configuration parameters for the database connection.
     * @param string $username Database username.
     * @param string $password Database password.
     */
    private function __construct($config, $username, $password)
    {
        $dsn = 'mysql:' . http_build_query($config, '', ';');

        try {
            $this->dbHandle = new PDO($dsn, $username, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get the PDO database connection handle.
     *
     * @return PDO|null PDO connection handle.
     */
    public function getDBConnection()
    {
        return $this->dbHandle;
    }

    /**
     * Destructor to release the PDO connection handle.
     */
    public function __destruct()
    {
        $this->dbHandle = null;
    }
}

