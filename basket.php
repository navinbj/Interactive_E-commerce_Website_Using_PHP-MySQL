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
require_once ('Models/OrderHistoryDataSet.php');

$view = new stdClass();
$view->pageTitle = "Navin's Wordery";

$basketDataSet = new BasketDataSet();
$booksDataSet = new BooksDataSet();
$bookSingle = $booksDataSet;

/**
 * procedure for adding an item to the basket.
 */
if (isset($_POST['addToBasket']) )
{
    if (!$_SESSION['userSession']) {    //checking if a user is logged in or not
        //header("Location: login.php");  //if not logged in, then directing the user to a login page.
        echo "<div class=\"col-xs-12 warning\">";
        echo "Please login first!!";
        echo "</div>";
        header("refresh:2;http://localhost:8000/login.php");
    }
    else {
        $quantity = $_POST['quantity'];
        $customerID = $_SESSION['cusIDSession'];
        $bookID = $_GET['id'];
        $quantityAvailable = $bookSingle->fetchBookSingle($bookID)[0]->getQuantity();   //getting available quantity for each book.
        $basketDataSet->addBooksToBasket($quantity, $bookID, $customerID, $quantityAvailable);
    }
}

/**
 * procedure for fetching the item from the basket when specified the customer ID to the parameter
 */
$cusID = '';
if ($_SESSION['cusIDSession']) {
    $cusID = $_SESSION['cusIDSession'];
}
//echo "cus ID HERE: " . $cusID;
$view->basketDataSet = $basketDataSet->fetchBasketSingle($cusID);


/**
 * procedure for clearing the items from basket when specified the customer of that basket.
 */
if (isset($_POST['clearBasket'])) {
    $basketDataSet->clearAllBasket($cusID);
    header("Refresh: 0");
}

/**
 * procedure for removing a single item from the list of items in the basket.
 * The customer ID and the item ID which a customer wants to remove need to be specified as parameters.
 */
if (isset($_POST['removeItem']))
{
    $iSBNNo = '';
    if (isset($_POST['bookID'])) {
        $iSBNNo = $_POST['bookID'];
    }
    $basketDataSet->deleteItemFromBasket($cusID, $iSBNNo);

    echo "<div class=\"col-xs-12 message\">";
        echo "Item deleted: " . $iSBNNo;
    echo "</div>";
    header("refresh:2;http://localhost:8000/basket.php");
}

/**
 * procedure for updating the quantity of particular item in the basket.
 * The new quantity and the item ID need to be specified.
 */
if (isset($_POST['updateQuantity']))
{
    $iSBNNo = '';
    if (isset($_POST['bookID'])) {
        $iSBNNo = $_POST['bookID'];
    }
    echo "<br>";
    $updateQuantity = $_POST['quantityUpdate'];
    $basketDataSet->updateQuantity($updateQuantity, $iSBNNo, $cusID);
    header("refresh:0;http://localhost:8000/basket.php");
}

/**
 * procedure for checking out the item/items from the basket.
 * The basket will be cleared after the checkout and the stock level will be updated.
 */
if (isset($_POST['checkout']))
{
    foreach ($view->basketDataSet as $bookData)
    {
        $iSBNNo = $bookData->getISBNNo();
        $bookDataSet = new BooksDataSet();
        $bookSingle = $bookDataSet->fetchBookSingle($iSBNNo);   //storing the array of book IDS into a variable.

        $wantedQty = $bookData->getQuantity();
        $availableQty = $bookSingle[0]->getQuantity();

        //the quantity of the item in the basket is greater than the quantity available for the item
        if ($wantedQty > $availableQty) {
            echo "<div class=\"col-xs-12 purchaseWarning\">";
                echo "Sorry, Item not currently available!: " . $bookData->getISBNNo() . "<br>";
                echo "You want: " . $wantedQty . "<br>";
                echo "Currently Available: " . $availableQty;
            echo "</div>";
        }
        else {
            $customerID = $_SESSION['cusIDSession'];
            $bookID = $bookData->getISBNNo();
            $quantity = $bookData->getQuantity();
            $priceQty1 = $bookSingle[0]->getPrice();
            $totalPrice = $quantity * $priceQty1;

            date_default_timezone_set('GMT');
            $dateTime = date('m/d/Y h:i:s a', time());

            $orderHistoryDataSet = new OrderHistoryDataSet();
            //populating the item that are checked out into a OrderHistory table.
            $orderHistoryDataSet->populateCheckedOutItem($customerID, $iSBNNo, $quantity, $priceQty1, $totalPrice, $dateTime);

            $booksDataSet->updateQuantity($bookData->getISBNNo(), $bookData->getQuantity());
            $basketDataSet->deleteItemFromBasket($_SESSION['cusIDSession'], $bookData->getISBNNo());

            echo "<div class=\"col-xs-12 itemPurchasedMsg\">";
                echo "Item purchased: " . $bookData->getISBNNo(). "<br>";
                echo "Thank you for your purchase.";
            echo "</div>";
            header("refresh:3");
        }
    }
}

require_once('Views/basket.phtml');