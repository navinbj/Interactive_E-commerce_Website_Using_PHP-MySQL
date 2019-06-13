<?php
/**
 * Created by PhpStorm.
 * User: stc392
 * Date: 21/11/16
 * Time: 13:49
 *
 * The controller page for handling all the operations that are to do with login.
 */

$view = new stdClass();
$view->pageTitle = "Navin's Wordery";
require_once('Models/Login.php');

$login = new Login();   //creating a new instance of class Login

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $login->login($username, $password);      //calling the login method of class Login, the username and password will be stored into a local variable result.

    if ($result) {
//        session_start();    //if login detail is correct, the user session will be started.
        header("refresh:2;http://localhost:8000/index.php");        //if the user details are correct, it takes 2 minutes to refresh the page and then take a user back to home page.
        echo "<div class=\"col-xs-12 message\">";
            echo "Welcome $username";
        echo "</div>";

        $_SESSION['userSession'] = $_POST['username'];      //saving a user's username into a session variable.
        $_SESSION['cusIDSession'] = $result['customerID'];      //saving customerID into a session variable.
        //var_dump($_SESSION);
    }
    else {
        header("refresh:2");
        echo "<div class=\"col-xs-12 warning\">";
            echo "  ***Sorry, Your username or password is invalid, please try again";
        echo "</div>";
    }
}
require_once('Views/login.phtml');
