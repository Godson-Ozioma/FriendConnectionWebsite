<?php

require_once ("Models/Database.php");
require_once ("Models/User.php");


class SearchDataset
{
    public function __construct() {
        $this->_dbInstance = Database::getInstance();//create new instance of Database
        $this->_dbHandle = $this->_dbInstance->getdbConnection();//get the database connection
    }

    /**
     *
     */

//        Return the details of all the searched Users
    public function fetchAllSearchedUsers($searchUserText){
        $sqlQuery = "SELECT * FROM users WHERE username LIKE '". $searchUserText ."%'";
        $statement = $this->_dbHandle->prepare($sqlQuery);
//        var_dump($sqlQuery);
        $statement->execute(); //execute the PDO statement

        $dataset = [];
        while ($row = $statement->fetch()) {
            $dataset[] = new User($row);
//                var_dump($dataset);

        }
//
        return $dataset;

    }









}