<?php

require_once('Database.php');
require_once('OrderHistoryData.php');
/**
 * The class OrderHistoryDataSet connects to a database in order to establish communication with customers and books table.
 * The class will then executes the certain SQL queries depending on the foreign keys of a table.
 */
class OrderHistoryDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * @param $customerID
     * @param $iSBNNo
     * @param $quantity
     * @param $pricePerQty
     * @param $totalPrice
     * @param $dateTime
     * The function for populating the checked out items into the OrderHistory table.
     */
    public function populateCheckedOutItem($customerID, $iSBNNo, $quantity, $pricePerQty, $totalPrice, $dateTime)
    {
        $insertQuery = "INSERT INTO OrderHistory (customerID, iSBNNo, quantity, pricePerQty, totalPrice, dateTime) VALUES($customerID, '$iSBNNo', $quantity, $pricePerQty, $totalPrice, '$dateTime')";
        $statement = $this->_dbHandle->prepare($insertQuery);
        $statement->execute();
    }

    /**
     * @param $customerID
     * @return array
     * The function for returning the order history of a particular customer when specified the customer ID to a parameter.
     */
    public function fetchOrderHistory($customerID) {
        $selectQuery = "SELECT * FROM OrderHistory WHERE customerID = $customerID";

        $statement = $this->_dbHandle->prepare($selectQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new OrderHistoryData($row);
        }
        return $dataSet;
    }
}