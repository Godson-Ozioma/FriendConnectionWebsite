<?php
require_once ('Models/Database.php');
require_once ('Models/User.php');
require_once ('Models/Friends.php');
class FriendsDataset
{
//    A class to control the various functions of the user to user action in terms of friends
//    Accepts, send and delete friend requests
//  Displays all friends
    protected $_dbHandle, $_dbInstance;

    /**
     * FriendDataset constructor.
     * Constructor for creating a new instance of this class
     */
    //constructor for the FriendsDataset Class
    public function __construct() {
        $this->_dbInstance = Database::getInstance();//create new instance of Database
        $this->_dbHandle = $this->_dbInstance->getdbConnection();//get the database connection
    }


//    Send a friend request to another user
    public function sendRequest($sendID, $receiverID){
        if ($this->verifyRequest($sendID, $receiverID) == true){}
        $sqlQuery = "INSERT INTO request (send, receive) VALUE ($sendID, $receiverID)";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

    }

//    Accept friend request from a different user
    public function acceptRequest($userID, $requestingID){
        //sql query to insert the new friend to the database
        $sqlQuery = "INSERT INTO friend (friend1, friend2) VALUE ($requestingID, $userID)";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        //deletes request from the request table
        $this->deleteRequest($requestingID);
//        $sqlQuery = "DELETE FROM request WHERE send = $requestingID";
////        var_dump($sqlQuery);
//        $statement = $this->_dbHandle->prepare($sqlQuery);
//        $statement->execute();
    }
//Delete a request after acceptance or rejection
    public function deleteRequest($requestingID){
        //sql query to delete the request
        $sqlQuery = "DELETE FROM request WHERE send = $requestingID";
//        var_dump($sqlQuery);
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function cancelRequest($userID, $friendID){
        try{
            $sqlQuery = "DELETE FROM request WHERE (send = :userID AND receive = :friendID) OR (send = :friendID AND receive = :userID)";
            $statement = $this->_dbHandle->prepare($sqlQuery);
            $statement->bindValue(':userID', $userID, PDO::PARAM_STR);
            $statement->bindValue(':friendID', $friendID, PDO::PARAM_STR);
            $statement->execute();

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
//        Display all the friend's of the current user
    public function displayAllFriends($userID){
        try {

            $sqlQuery = "
            SELECT * from (
                SELECT *
                from users
            WHERE userID in (
                SELECT  friend1 as friend
                FROM friend
                WHERE (friend.friend1 = $userID OR friend.friend2 = $userID)
                UNION
                SELECT friend2 as friend
                FROM friend
                WHERE (friend.friend1 = $userID OR friend.friend2 = $userID)

            )
                and userID != $userID
            )ping inner join friend WHERE ((friend1=ping.userID and friend2= $userID) OR (friend1=$userID AND friend2=ping.userID))";

            $statement = $this->_dbHandle->prepare($sqlQuery);
            //$statement->bindValue(':user_id', $user_id, PDO::PARAM_STR);
            $statement->execute();

//            var_dump($str);
            $dataset = [];
            while ($row = $statement->fetch()) {
                $dataset[] = new Friends($row);
//                var_dump($dataset);

            }
//
            return $dataset;

        }catch (PDOException $e){
            die($e->getMessage());
        }
    }

//    Display all the friend requests
    public function getAllRequests($userID){
        $sqlQuery = "SELECT * FROM request,users WHERE receive ='$userID' AND users.userID = send";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataset = [];
        while($row = $statement->fetch()){
            $dataset[] = new User($row);
        }
        return $dataset;
    }

//    Verification of request to prevent a user from adding themselves as a friend or adding another user twice
    public function verifyRequest($sendID, $receiveID){
        if ($sendID == $receiveID){
            return false;
        }
        $sqlQuery = "SELECT * FROM friend WHERE friend1 = $sendID AND friend2 = $receiveID OR friend1 = $receiveID AND friend2 = $sendID";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $row = $statement->fetch();
        if (empty($row == false))
            return false;


        $sqlQuery = "SELECT * FROM request WHERE send = $sendID AND receive = $receiveID OR send = $receiveID AND receive = $sendID";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $row = $statement->fetch();
        if (empty($row == false))
            return false;

        return true;

    }





}