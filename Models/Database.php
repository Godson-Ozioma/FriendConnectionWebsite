<?php

class Database
{
    protected static $_dbInstance = null;
    protected $_dbHandle;

    public static function getInstance()
    {
        $username = 'age488';
        $password = 'Godoz2003';
        $host = 'poseidon.salford.ac.uk';
        $dbName = 'age488';

        if (self::$_dbInstance === null)//checks if the PDO exists
        {
            // creates new instance if not, sending in connection info
            self::$_dbInstance = new self($username, $password, $host, $dbName);
        }

        return self::$_dbInstance;
    }

    private function __construct($username, $password, $host, $database) {
        try {
            $this->_dbHandle = new PDO("mysql:host=$host;dbname=$database",  $username, $password); // creates the database handle with connection info
            //$this->_dbHandle = new PDO('mysql:host=' . $host . ';dbname=' . $database,  $username, $password); // creates the database handle with connection info

        }
        catch (PDOException $e) { // catch any failure to connect to the database
            echo $e->getMessage();
        }
    }

    // return the PDO connection
    public function getdbConnection(){
        return $this->_dbHandle;
    }

    // destroy the PDO connection when no longer needed
    public function __destruct(){
        $this->_dbHandle = null;
    }
}