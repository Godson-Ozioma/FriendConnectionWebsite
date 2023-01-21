<?php

require_once ("Models/UserDataset.php");

$view = new stdClass();
$view->pageTitle = "Home";

// start the session
session_start();



require_once ("Views/index.phtml");