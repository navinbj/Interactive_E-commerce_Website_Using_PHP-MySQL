<?php
/**
 * Created by PhpStorm.
 * User: stc392
 * Date: 21/11/16
 * Time: 13:49
 */

$view = new stdClass();

$view->pageTitle = "Navin's Wordery";
//require_once('Views/register.phtml');
require_once('Models/CustomersDataSet.php');

$customerDataSet = new CustomersDataSet();

$firstname = $_POST['firstname'];
$surname = $_POST['surname'];
$address = $_POST['address'];
$postcode = $_POST['postcode'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

$num_length = strlen((string)$mobile);      //storing the length of the characters of mobile number into a local variable by casting the data type to string.
$passwordEncrypt = password_hash($password, PASSWORD_DEFAULT);  //encrypts the password the user has entered using a hash function

/**
 * Checking for the requirements needed to insert the customer details into a database.
 */
if (isset($_POST['Submit'])) {

    if ($_POST['firstname'] == "" || $_POST['surname'] == "" || $_POST['address'] == "" || $_POST['postcode'] == "" || $_POST['mobile'] == "" || $_POST['email'] == "" || $_POST['password'] == "")
    {
        echo "<div class=\"col-xs-12 warning\">";
            echo "**ERROR: cannot complete registration, please make sure all fields are filled in!";
        echo "</div>";
    }

    else if ($customerDataSet->checkMobile($mobile) > 0) {
        echo "<div class=\"col-xs-12 warning\">";
            echo "**ERROR: mobile number already in use!";
            echo "<br>";
            echo "Please try to register with a different one!";
        echo "</div>";
    }

    else if ($num_length != 11) {
        echo "<div class=\"col-xs-12 warning\">";
            echo "**ERROR: Incorrect mobile number, must be 11 digits";
        echo "</div>";
    }

    else if ($customerDataSet->checkEmail($email) > 0) {
        echo "<div class=\"col-xs-12 warning\">";
            echo "**ERROR: Email already in use!";
            echo "<br>";
            echo "Please try to register with a different one!";
        echo "</div>";
    }
    else if ($password!= $confirmPassword) {
        echo "<div class=\"col-xs-12 warning\">";
            echo "**ERROR: passwords do not match! <br>";
            echo "Please try again!";
        echo "</div>";
    }
    else {
        $customerDataSet->populateCustomers($firstname, $surname, $address, $postcode, $mobile, $email, $passwordEncrypt);
        header("refresh:2;http://localhost:8000/login.php");
        echo "<div class=\"col-xs-12 success\">";
            echo "Registration Complete!!";
        echo "</div>";
    }
}
require_once('Views/register.phtml'); ?>