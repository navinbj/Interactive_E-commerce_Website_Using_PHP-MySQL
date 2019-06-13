<?php
/**
 * Created by PhpStorm.
 * User: stc392
 * Date: 22/11/16
 * Time: 14:41
 */
session_start();
require_once ('Models/OrderHistoryDataSet.php');
require_once ('Models/BooksDataSet.php');

$view = new stdClass();
$view->pageTitle = "Navin's Wordery";

$orderHistoryDataSet = new OrderHistoryDataSet();
$customerID = '';
if (isset($_SESSION['cusIDSession']))
{
    $customerID = $_SESSION['cusIDSession'];
}
$view->orderHistoryDataSet = $orderHistoryDataSet->fetchOrderHistory($customerID);

require_once ('Views/orderHistory.phtml');