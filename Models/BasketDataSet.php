<?php

require_once('Database.php');
require_once('BasketData.php');
require_once('BooksDataSet.php');

/**
 * The class BasketDataSet connects to a database in order to establish communication with customers and books table.
 * The class will then executes the certain SQL queries depending on the foreign keys of a table.
 */
class BasketDataSet {
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * @param $email
     * @param $quantity
     * @param $iSBNNo
     * @return $dataset
     * The method for populating the combination of data from Customers and Books table being obtained via the primary keys of respective tables.
     */
    public function addBooksToBasket($quantity, $iSBNNo, $customerID, $productQuantity)
    {
        $selectQuery = "SELECT * FROM Basket WHERE customerID = $customerID AND iSBNNo = '$iSBNNo'";
        $statement = $this->_dbHandle->prepare($selectQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];  //an array to hold the basket information in a row.
        while ($row = $statement->fetch()) {
            $dataSet[] = new BasketData($row);
        }
        $arraySize  = sizeof($dataSet);     //saving the returned rows numbers into a variable.

        if ($arraySize == 1 ) {     //if it returns a row that means the the book already exists.

            $selectQuery2 = "SELECT quantity FROM Basket WHERE customerID = $customerID AND iSBNNo = '$iSBNNo'";  //get the quantity of the book I want to add to a basket if it exists.
            $statement = $this->_dbHandle->prepare($selectQuery2); // prepare a PDO statement
            $statement->execute(); // execute the PDO statement

            $quantityDataSet = [];  //an array to hold the quantities in a row.
            while ($row = $statement->fetch()) {
                $quantityDataSet = $row;    //the array now holds the returned rows of quantity.
            }

            if ($quantityDataSet['quantity'] + $quantity <= $productQuantity) {     //if the quantity user wants to update is less than or equal to the available quantity, then update.
                $updateQuery = "UPDATE Basket SET quantity = quantity + $quantity WHERE iSBNNo = '$iSBNNo' AND customerID = $customerID";

                echo "<div class=\"col-xs-12 warning\">";
//                  echo "Cannot add! the book with id ".$iSBNNo." already exists. The quantity will be incremented";
                    echo "Quantity incremented for book: " .$iSBNNo;
                echo "</div>";
                $this->_dbHandle->exec($updateQuery);
            }
            else {
                echo "<div class=\"col-xs-12 warning\">";
                    echo "Quantity limit exceeded!! <br>";
//                    $wantedQty = $quantity + $productQuantity;
                    $wantedQty = $quantity + $quantityDataSet['quantity'];
                    echo "You want: " . $wantedQty . "<br>";
                    echo "Available: " . $productQuantity;
                echo "</div>";
            }
        }
        else
        {
            $insertQuery = "INSERT INTO Basket SET quantity = $quantity, iSBNNo = (SELECT iSBNNo FROM Books WHERE iSBNNo = '$iSBNNo'), customerID = (SELECT customerID FROM Customers WHERE customerID = $customerID)";
            $statement = $this->_dbHandle->prepare($insertQuery);
            $statement->execute();
        }
        return $dataSet;
    }


    /**
     * @param $basketID
     * @return array
     * The method for fetching the specific number of items (books) from the database tabke Basket along with the information saved about the certain item or a user.
     */
    public function fetchBasketSingle($customerID)
    {
        $sqlQuery = "SELECT * FROM Basket WHERE customerID=$customerID";

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new BasketData($row);
        }
        return $dataSet;
    }


    /**
     * @param $customerID
     * The method for clearing all the items from customer's basket when passed the valid customer id.
     */
    public  function clearAllBasket($customerID) {
        $sqlQuery = "DELETE FROM Basket WHERE customerID = $customerID";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    /**
     * @param $iSBNNo
     * @param $customerID
     * The method for deleting the item from the basket when passed the valid item and customer ids.
     */
    public function deleteItemFromBasket($customerID, $iSBNNo) {
        $sqlQuery = "DELETE FROM Basket WHERE customerID = $customerID AND iSBNNo = '$iSBNNo'";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    /**
     * @param $quantity
     * @param $iSBNNo
     * The method for updating the quantity of a particular item when passed the new quantity and the book ISBN number.
     */
    public function updateQuantity($quantity, $iSBNNo, $customerID) {
        $sqlQuery = "UPDATE Basket Set quantity = $quantity WHERE iSBNNo = '$iSBNNo' AND customerID = $customerID";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }
}