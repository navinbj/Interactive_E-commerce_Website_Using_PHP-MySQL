<?php
/**
 * Created by PhpStorm.
 * User: stc392
 * Date: 28/11/16
 * Time: 13:52
 *
 * The page for destroying the session when the customer logs out from the system.
 */

session_start();
session_destroy();

header("refresh:3;http://localhost:8000/login.php");            //refreshes the page in 3 seconds and then takes a user back to login page.
echo 'logging out.....' . $_SESSION['userSession']. "<br>";
echo 'Thank you for visiting us, see you soon again!';

?>
