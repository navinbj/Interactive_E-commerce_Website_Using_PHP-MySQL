<?php
/**
 * Created by PhpStorm.
 * User: stc392
 * Date: 22/11/16
 * Time: 14:41
 *
 * The page for handling all the operations that are to do with sorting the books by the price ranges specified by a customer.
 */

require_once('Models/BooksDataSet.php');

$view = new stdClass();
$view->pageTitle = "Navin's Wordery";

$priceMin = $_POST['priceMin'];
$priceMax = $_POST['priceMax'];

$booksDataSet = new BooksDataSet();
$view->booksDataSet = $booksDataSet->sortBooksByPriceMinimum($priceMin);
$view->booksDataSet = $booksDataSet->sortBooksByPriceMaximum($priceMax);

require_once('Views/sortByPrice.phtml');