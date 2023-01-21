<?php
require_once ("Models/FriendsDataset.php");
require_once ("Models/UserDataset.php");

$view = new stdClass();
$view->pageTitle = "Register";


// start the session
session_start();


$friendsDataset =   new FriendsDataset();

//Display all users friends when user is logged in
if (isset($_SESSION['userID'])){//checks if user is logged in
//    displays a list of all users friends
    $view->friendsDataset = $friendsDataset->displayAllFriends($_SESSION['userID']);

//    To get the friends details and create an array that stores the friends details
    if(isset($_GET['live_location'])){
//        returns the details of all friends
        $friends = $friendsDataset->displayAllFriends($_SESSION['userID']);


        $response = [];
        foreach($friends as $friend){
            $arr = [];
            $arr[] = $friend -> getUsername();//array to store the friends username
            $arr[] = $friend -> getLatitude();//array for the friends latitude to be able to view friend's location on the map
            $arr[] = $friend -> getLongitude();//array for the friends longitude to be able to view friend's location on the map
            $response[] = $arr;
        }

        echo json_encode($response);
        return;
    }
}



require_once ("Views/friends.phtml");