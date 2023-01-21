<?php

require_once ("Models/UserDataset.php");

$view = new stdClass();
$view->pageTitle = "Register";

// start the session
session_start();

$userDataset = new UserDataset();
//when the register button is pressed
if(isset($_POST['submit-register']))
{
    $firstName = htmlentities($_POST['firstName']);
    $lastName = htmlentities($_POST['lastName']);
    $email = htmlentities($_POST['email']);
    $username = htmlentities($_POST['userName']);
    $password = htmlentities($_POST['passWord']);
    $confirmPassword = htmlentities($_POST['confirmPassword']);

        if ($username == 'userName')
        {
            if($password == $confirmPassword)
            {
//        password encryption
                $password = password_hash($_POST['passWord'], PASSWORD_DEFAULT);

//        inserting the users imputed details into the users table
                $regComplete = $userDataset->registerUser($firstName, $lastName, $email, $username, $password);

                if ($regComplete)
                {
                    $user = $userDataset->fetchUserDetails($_POST['firstName'])    ;

                    //login the user after successfully signing up
                    $_SESSION["userID"] = $user->getUserID();
                    $_SESSION["firstName"] = $user->getFirstName();
                    $_SESSION["loggedin"] = true;
                    header("Location: index.php");
                }

            }else
            {
                $view->register = "Password and Confirm password do not match";


            }
        }else
        {
            $view->userWrong = "username taken";
        }




}


require_once ("Views/register.phtml");
