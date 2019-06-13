<?php
/**
 * Created by PhpStorm.
 * User: stc392
 * Date: 22/11/16
 * Time: 14:38
 */

require_once('Database.php');
require_once('BookData.php');

class BooksDataSet
{
    protected $_dbHandle, $_dbInstance;

    /**
     * BooksDataSet constructor.
     */
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * The method for fetching all the books from a database table using a select SQL query.
     * @return array
     */
    public function fetchAllBooks()
    {
        $sqlQuery = 'SELECT * FROM Books';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];  //an array to hold the book information in a row.
        while ($row = $statement->fetch()) {
            $dataSet[] = new BookData($row);
        }
        //echo sizeof($dataSet);
        return $dataSet;
    }

    /**
     * The method for fetching the information about a single book when the book id is passed.
     * @param $id
     * @return array
     */
    public function fetchBookSingle($id)
    {
        $sqlQuery = "SELECT * FROM Books WHERE iSBNNo='$id'";

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new BookData($row);
        }
        return $dataSet;
    }

    /**
     * The method for returning as many books as there is in a database when it satisfies the author name
     * passed as an argument.
     * @param $author
     * @return array
     */

    public function sortBooksByAuthor($author) {
        $sqlQuery = "SELECT * FROM Books WHERE author LIKE '%$author%'";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new BookData($row);
        }
        return $dataSet;
    }

    /**
     * The method for returning as many books as there are in a database provided that it is somehow similar
     * to the type of genre passed as an argument.
     * @param $genre
     * @return array
     */
    public function sortBooksByGenre($genre) {
        $sqlQuery = "SELECT * FROM Books WHERE genre LIKE '%$genre%'";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new BookData($row);
        }
        return $dataSet;
    }

    /**
     * The method for returning as many books as there are in a database with the price less than the one
     * specified in an argument.
     * @param $price
     * @return array
     */
    public function sortBooksByPriceMinimum ($price) {
        $sqlQuery = "SELECT * FROM Books WHERE price < $price";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new BookData($row);
        }
        return $dataSet;
    }

    /**
     * The method for returning as many books as there are in a database with the price more than the one
     * specified in an argument.
     * @param $price
     * @return array
     */
    public function sortBooksByPriceMaximum ($price) {
        $sqlQuery = "SELECT * FROM Books WHERE price > '$price'";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new BookData($row);
        }
        return $dataSet;
    }

    /**
     * @param $title
     * @return array
     * The method for returining as many books as there are in a database provided that the book titles are somewhat similar
     * to the title names passed as an argument.
     */
    public function sortBooksByTitle($title) {
        $sqlQuery = "SELECT * FROM Books WHERE title LIKE '%$title%'";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new BookData($row);
        }
        return $dataSet;
    }

    /**
     * @param $quantity
     * @param $iSBNNo
     * The method for updating the quantity of particular item after the customer has checked out.
     */
    public function updateQuantity($iSBNNo, $quantity)
    {
        $sqlQuery = "UPDATE Books SET quantity = quantity - $quantity  WHERE iSBNNo= '$iSBNNo'";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }
}