<?php
/**
 * Created by PhpStorm.
 * User: stc392
 * Date: 22/11/16
 * Time: 14:41
 */

require_once('Models/CustomersDataSet.php');
session_start();

$view = new stdClass();
$view->pageTitle = "Navin's Wordery";

$customerDataSet = new CustomersDataSet();
$cusID = $_SESSION['cusIDSession'];
$view->customerDataSet = $customerDataSet->fetchCustomerDetails($cusID);

/**
 * Checking for the requirements needed to update the password of a customer.
 */
if (isset($_POST['reset'])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];
    $passwordEncrypt = password_hash($newPassword, PASSWORD_DEFAULT);

//    echo "Old: $currentPassword" . " " .  "new: $newPassword" . " " . "Confirm: $confirmNewPassword";

    if ($_POST['currentPassword'] == "" || $_POST['newPassword'] == "" || $_POST['confirmNewPassword'] == "") {
         echo "<div class=\"col-xs-12 warning\">";
            echo "Input missing! please make sure all fields are filled in.";
         echo "</div>";
         header("refresh:2");
     }
     else if($newPassword != $confirmNewPassword) {
         echo "<div class=\"col-xs-12 warning\">";
            echo "**ERROR: new passwords do not match! <br>";
            echo "Please try again!";
         echo "</div>";
     }
     else {
         $customerDataSet->resetPassword($currentPassword, $passwordEncrypt, $cusID);
         header("refresh:2");
     }
}

/**
 * Checking for the requirements needed to update the address of a customer.
 */
if (isset($_POST['saveAddress']))
{
    $address = $_POST['address'];
    if ($address == "") {
        echo "<div class=\"col-xs-12 warning\">";
            echo "Please enter something!!";
        echo "</div>";
        header("refresh:2");    //refreshing the page after 2 seconds
    }
    else {
        $customerDataSet->updateAddress($address, $cusID);
        echo "<div class=\"col-xs-12 message\">";
            echo "Your address has been successfully updated!";
        echo "</div>";
        header("refresh:2");
    }
}

/**
 * Checking for the requirements needed to update the postcode of a customer.
 */
if (isset($_POST['savePostcode'])) {
    $postcode = $_POST['postcode'];
    if ($postcode == "") {
        echo "<div class=\"col-xs-12 warning\">";
            echo "Please enter something!!";
        echo "</div>";
        header("refresh:2;http://localhost:8000/myAccount.php");
    }
    else {
        $customerDataSet->updatePostcode($postcode, $cusID);
        echo "<div class=\"col-xs-12 message\">";
            echo "Your postcode has been successfully updated!";
        echo "</div>";
        header("refresh:2");
    }
}

/**
 * Checking for the requirements needed to reset the mobile number of a customer.
 */
if (isset($_POST['saveMobile'])) {
    $mobile = $_POST['mobileNo'];
    $num_length = strlen((string)$mobile);      //storing the length of the characters of mobile number into a local variable by casting the data type to string.

    if ($num_length < 1) {
        echo "<div class=\"col-xs-12 warning\">";
            echo "Please enter something!!";
        echo "</div>";
        header("refresh:2");
    }
    else if ($num_length != 11) {
        echo "<div class=\"col-xs-12 warning\">";
            echo "ERROR: Incorrect mobile number, must be 11 digits!";
        echo "</div>";
    }
    else if ($customerDataSet->checkMobile($mobile) > 0) {
        echo "<div class=\"col-xs-12 warning\">";
            echo "ERROR: mobile number already in use!";
        echo "</div>";
    }
    else {
        $customerDataSet->updateMobile($mobile, $cusID);
        echo "<div class=\"col-xs-12 message\">";
            echo "Your mobile number has been successfully updated!";
        echo "</div>";
        header("refresh:2");
    }
}

/**
 * Checking for the requirements needed to reset the email address of a customer.
 */
if (isset($_POST['saveEmail'])) {
    $email = $_POST['email'];
    if ($email == "") {
        echo "<div class=\"col-xs-12 warning\">";
            echo "Please enter something!!";
            echo "</div>";
        header("refresh:2");
    }
    else if ($customerDataSet->checkEmail($email) > 0) {
        echo "<div class=\"col-xs-12 warning\">";
            echo "ERROR: Email already in use!";
        echo "</div>";
    }
    else {
        $customerDataSet->updateEmail($email, $cusID);
        echo "<div class=\"col-xs-12 message\">";
            echo "Your email has been successfully updated!";
        echo "</div>";
        header("refresh:2");
    }
}

require_once('Views/myAccount.phtml');