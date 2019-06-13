<?php
/**
 * Created by PhpStorm.
 * User: stc392
 * Date: 22/11/16
 * Time: 14:41
 *
 * The page for handling all the operations that are to do with sorting the books by the particular author specified by a customer.
 */

require_once('Models/BooksDataSet.php');

$view = new stdClass();
$view->pageTitle = "Navin's Wordery";

$author = $_POST['author'];

$booksDataSet = new BooksDataSet();
$view->booksDataSet = $booksDataSet->sortBooksByAuthor($author);    //calling a method from class BooksDataSet that returns the sorted results for authors in an array.

require_once('Views/sortByAuthor.phtml');