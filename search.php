<?php
require_once ('Models/SearchDataset.php');
require_once ("Models/UserDataset.php");

$view = new stdClass();
$view->pageTitle = "User Search Results";

// start the session
session_start();

//create a new instance of the searchUsers class
$searchDataset = new SearchDataset();

//when the user search button is clicked
if(isset($_POST['userSearchBtn'])) {
    //make the user's search userSearch
    $userSearch = $_POST['searchUsers'];
    //only show records matching entered search term
    $view->searchDataset = $searchDataset->fetchAllSearchedUsers($userSearch);

}

// Fetch the details of all the searched users
if (isset($_GET['live_search'])){
    $searchText = $_GET['live_search'];
    $usersArr = $searchDataset->fetchAllSearchedUsers($searchText);
    echo json_encode($usersArr);
//prevent the systems from running forever
    return;
}




require_once ("Views/search.phtml");