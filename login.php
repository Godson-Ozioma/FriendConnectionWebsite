<?php

require_once ("Models/UserDataset.php");

$view = new stdClass();
$view->pageTitle = "Login";

// start the session
session_start();


//if(isset($_SESSION['userID'])){
//    echo $_SESSION['firstName'];
//}else{
//    echo "NOT LOGGED IN";
//}
/**
 * for when the login button is pressed
 */
if(isset($_POST["submit-login"])) // check if login button is pressed
{
    $userDataset = new UserDataset();
    $username = $_POST['username'];
//    echo "un: " . $username;
    $password = $_POST['password'];
//    echo "pw: " . $password;
//    call the verifyUserLogin in userDataset class to check if the inserted username and password is correct
    $correct = $userDataset->verifyUserLogin($username, $password);

    // if the inserted user details is correct
    if($correct){
//        echo "correct";
        //get an instance of the user details from the userDataset class
        $user = $userDataset->fetchUserDetails($_POST['username']);
        //create a session for the user
        $_SESSION["userID"] = $user->getUserID();
        $_SESSION["firstName"] = $user->getFirstName();


        // redirect the user to the profile page after logged in correctly
        header("Location: index.php");
    }else{// when wrong details entered
//        show error message when wrong details is used
        $view->loggedin = "Wrong username or password";
    }

}

// logout button pressed
if(isset($_GET["logout"])){
    $logout =  htmlentities($_GET['logout']);
//    var_dump($logout);
    if($logout == 'true'){
        //end the sessions and log user out
        unset($_SESSION["userID"]); //end the userID session
        unset($_SESSION["firstName"]); //end the firstName session


   session_destroy();
        header("Location: login.php"); //redirect user to login page after logging out
    }



}

require_once ('./Views/login.phtml');