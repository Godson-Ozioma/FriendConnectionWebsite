<?php
require_once ("Models/UserDataset.php");

$view = new stdClass();
$view->pageTitle = "Users";

// start the session
session_start();
//creates a new instance of the UserDataset class
$userDataset = new UserDataset();
//calls the while loop in the getAllUsers method to show all the users in the database
$view->userDataset = $userDataset->getAllUsers();







require_once ("Views/users.phtml");