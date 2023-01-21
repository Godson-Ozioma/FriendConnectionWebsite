<?php

require_once ("Models/Database.php");
require_once ("Models/User.php");
class UserDataset
{
    protected $_dbHandle, $_dbInstance;

    /**
     * UserDataset constructor.
     * Constructor for creating a new instance of this class
     */
    //constructor
    public function __construct() {
        $this->_dbInstance = Database::getInstance();//create new instance of Database
        $this->_dbHandle = $this->_dbInstance->getdbConnection();//get the database connection
    }

    /**
     * @return array
     * Returns an array of all the users
     */
    public function getAllUsers(){
        $sqlQuery = "SELECT * FROM users";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataset = [];
        while($row = $statement->fetch()){
            $allUsers = new User($row);
            $dataset[] = $allUsers;
        }
        return $dataset;
    }


//    Returns all user details
    public function fetchUserDetails($username){
        $sqlQuery = "SELECT * FROM users WHERE username = ?";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $username);
        $statement->execute();

        $row = $statement->fetch();
        $user = new User($row);
        return $user;
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     */

//    Check for login authenticity
    public function verifyUserLogin($username, $password)//verify if login details are correct
    {
        $sqlQuery = "SELECT * FROM users WHERE username = ?";
        $statement = $this->_dbHandle->prepare($sqlQuery);

        //prevent sql injection
//        $statement->bindParam(1, $email);
        $statement->execute(array($username));

        $row = $statement->fetch();
        if(empty($row)){
            return false;
        }
        //$password == $user->getPassword()
        $user = new User($row);
        $verify = password_verify($password, $row['password']);
        if($verify){
            return true;
        }else{
            return false;
        }

    }



//    Creates a new user and adds their details to the database
    public function registerUser($firstName, $lastName, $email, $username, $password)
    {
        $sqlQuery = "SELECT * FROM users WHERE username = ?";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $username);
        $statement->execute();

        $row = $statement->fetch();

//        finds an empty row to store new user details
        if(empty($row))
        {
//            insert user details to the table
            $sqlQuery = "INSERT INTO users (first_name, last_name, email, username, password) VALUES(?, ?, ?, ?, ?)";
//            prepare the sqlQuery
            $statement = $this->_dbHandle->prepare($sqlQuery);
            //insert the fields as an array into the users table
            $fields = array($firstName,$lastName, $email, $username,$password);
            //execute the variable fields to perform the action of adding the parameters to the table
            $statement->execute($fields);
            return true;
        }else{
            return false;
        }
    }




}