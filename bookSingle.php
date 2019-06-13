<?php
/**
 * Created by PhpStorm.
 * User: stc392
 * Date: 22/11/16
 * Time: 14:41
 */
session_start();
require_once('Models/BooksDataSet.php');
require_once ('Models/BasketDataSet.php');
require_once ('Models/CommentsDataSet.php');
require_once ('Models/CustomersDataSet.php');

$view = new stdClass();
$view->pageTitle = "Navin's Wordery";

$basketDataSet = new BasketDataSet();
$booksDataSet = new BooksDataSet();
$commentsDataSet = new CommentsDataSet();

$view->booksDataSet = $booksDataSet->fetchBookSingle($_GET['id'])[0];
$view->commentsDataSet = $commentsDataSet->fetchAllComments($_GET['id']);


$cusID = $_SESSION['cusIDSession'];
$bookID = $_GET['id'];

/**
 * The procedure for submitting a comment to the product page.
 */
if (isset($_POST['submitComment']))
{
    date_default_timezone_set('GMT');
    $dateTime = date('m/d/Y h:i:s a', time());
//    echo "The current server timezone is: " . $date;

    $comment = $_POST['comment'];
    if($comment == "")
    {
        echo "<div class=\"col-xs-12 warning\">";
            echo "Please enter something!";
        echo "</div>";
    }
    else if (!$_SESSION['userSession'])
    {
        echo "<div class=\"col-xs-12 warning\">";
            echo "Your need to be logged in to post comments";
        echo "</div>";
    }
    else {
        $commentsDataSet->addComment($comment, $bookID, $cusID, $dateTime);
        echo "<div class=\"col-xs-12 message\">";
            echo "Comment submitted! Thank you for your time.";
        echo "</div>";
        header("Refresh: 2");
    }
}

/**
 * The procedure for deleting the comment posted by a customer.
 */
if (isset($_POST['deleteComment']))
{
    $commentID = '';
    $customerID = '';

    if (isset($_POST['commentID'])) {
        $commentID = $_POST['commentID'];
    }
    if (isset($_SESSION['userSession'])) {
        $customerID = $_SESSION['cusIDSession'];
    }
    $commentsDataSet->deleteComment($commentID, $customerID);
    echo "<div class=\"col-xs-12 message\">";
    echo "Comment successfully deleted! ";
    echo "</div>";
    header("Refresh: 2");
}

require_once('Views/bookSingle.phtml');