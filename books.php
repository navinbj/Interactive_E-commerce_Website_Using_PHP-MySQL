<?php
/**
 * Created by PhpStorm.
 * User: stc392
 * Date: 22/11/16
 * Time: 14:41
 */

require_once('Models/BooksDataSet.php');

$view = new stdClass();
$view->pageTitle = "Navin's Wordery";

$booksDataSet = new BooksDataSet();
$view->booksDataSet = $booksDataSet->fetchAllBooks();

require_once('Views/books.phtml');
