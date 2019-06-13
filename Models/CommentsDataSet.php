<?php

require_once('Database.php');
require_once('CommentsData.php');


/**
 * The class CommentsDataSet connects to a database in order to establish communication with BooksComments table.
 * The class will then execute the certain SQL queries depending on the foreign keys of a table.
 */
class CommentsDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * @param $comment
     * @param $iSBNNo
     * @param $customerID
     * The function for adding comments to the certain book when specified the comment, book ID and customer ID to the parameters.
     */
    public function addComment($comment, $iSBNNo, $customerID, $dateTime) {
        $sqlQuery = "INSERT INTO BooksComments (comment, iSBNNo, customerID, dateTime) VALUES ('$comment', '$iSBNNo', $customerID, '$dateTime')";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    /**
     * @param $iSBNNo
     * @return array
     * The function for fetching the comments from database into the generic page when specified te book ID to a parameter.
     */
    public function fetchAllComments($iSBNNo) {
        $sqlQuery = "SELECT * FROM BooksComments WHERE iSBNNo = '$iSBNNo'";

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];  //an array to hold the comments information in a row.
        while ($row = $statement->fetch()) {
            $dataSet[] = new CommentsData($row);
        }
        //echo sizeof($dataSet);
        return $dataSet;
    }

    /**
     * @param $commentID
     * @param $customerID
     * The function for deleting the comment when specified the customer who posted the comment and the unique ID of comment to the parameters.
     */
    public function deleteComment($commentID, $customerID) {
        $deleteQuery = "DELETE FROM BooksComments WHERE commentID = $commentID AND customerID = $customerID";
        $statement = $this->_dbHandle->prepare($deleteQuery);
        $statement->execute();
    }
}