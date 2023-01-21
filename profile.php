<?php

require_once ("Models/UserDataset.php");

$view = new stdClass();
$view->pageTitle = "Profile";

// start the session
session_start();

$userDataset = new UserDataset();

$view->userDataset = $userDataset->getAllUsers();



require_once ("Views/profile.phtml");