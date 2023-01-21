<?php
//require_once ('Models/SearchDataset.php');
require_once ("Models/FriendsDataset.php");

$view = new stdClass();
$view->pageTitle = "Request";

// start the session
session_start();
$loggedInUser = $_SESSION['userID'];
$friendsDataset = new FriendsDataset();

if (isset($_SESSION['userID'])){
    $view->allRequests = $friendsDataset->getAllRequests($loggedInUser);


}
if (isset($_GET['live_request'])) {
    $allRequests = $friendsDataset->getAllRequests($loggedInUser);
    echo json_encode($allRequests);
    return;
}

// user requested to be friends
if(isset($_GET['user_id'])) {
    $receiverID = htmlentities($_GET['user_id']);
    $senderID = $_SESSION['userID'];
    $friendsDataset->sendRequest($senderID, $receiverID);
    header('Location: index.php');
}



if(isset($_GET['accept_user_id'])) {
    $requestingID = htmlentities($_GET['accept_user_id']);
//    $senderID = $_SESSION['userID'];
    $friendsDataset->acceptRequest($loggedInUser, $requestingID);

}
if(isset($_GET['reject_user_id'])) {
    $requestingID = htmlentities($_GET['reject_user_id']);
//    $senderID = $_SESSION['userID'];
    $friendsDataset->deleteRequest($requestingID);

}










require_once ('Views/request.phtml');