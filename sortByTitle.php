<?php
/**
 * Created by PhpStorm.
 * User: stc392
 * Date: 22/11/16
 * Time: 14:41
 *
 * The page for handling all the operations that are to do with sorting the books by the book titles specified by a customer.
 */

require_once('Models/BooksDataSet.php');

$view = new stdClass();
$view->pageTitle = "Navin's Wordery";

$title = $_POST['bookTitle'];

$booksDataSet = new BooksDataSet();
$view->booksDataSet = $booksDataSet->sortBooksByTitle($title);    //calling a method from class BooksDataSet that returns the sorted results for book titles in an array.

require_once('Views/sortByTitle.phtml');