<?php

require_once('Database.php');
require_once('CustomerData.php');

/**
 * The class CustomerDataSet connects to a database in order to establish communication with the customer table
 * from where the data is collected and retrieved.
 */
class CustomersDataSet {
    protected $_dbHandle, $_dbInstance;

    /**
     * CustomersDataSet constructor.
     */
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * @param $firstname
     * @param $surname
     * @param $address
     * @param $postcode
     * @param $mobile
     * @param $email
     * @param $password
     * The method for populating the customer data into a database obtained from the HTML form during the registration.
     * The SQL INSERT query is used to populate each filed of customers table.
     */
    public function populateCustomers($firstname, $surname, $address, $postcode, $mobile, $email, $password)
    {

        $sqlQuery = "INSERT INTO Customers (firstname, surname, address, postcode, mobile, email, password) VALUES ('$firstname', '$surname', '$address', '$postcode', '$mobile', '$email', '$password')";

        $statement =$this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    /**
     * The method for fetching all the customer details when specified the customer ID in a parameter.
     * @return array
     */
    public function fetchCustomerDetails($cusID)
    {
        $sqlQuery = "SELECT * FROM Customers WHERE customerID = '$cusID'";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];  //an array to hold the book information in a row.
        while ($row = $statement->fetch()) {
            $dataSet[] = new CustomerData($row);
        }
        return $dataSet;
    }

    /**
     * @param $currentPassword
     * @param $newPassword
     * @param $cusID
     * @return array|mixed
     * The method for resetting the password of a user using an update query.
     */
    public function resetPassword($currentPassword, $newPassword, $cusID) {
        $sqlQuery = "SELECT * FROM Customers WHERE customerID = $cusID";
        $statement =$this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet = $row;    //storing the row of details of a customer into an array
        }

        // this first decrypts the password obtained from the database into a readable format and then checks if it matches with the password a customer has entered.
        $result = password_verify($currentPassword, $dataSet['password']);
        //var_dump($result);

        if ($result){
            $updateQuery = "UPDATE Customers SET password = '$newPassword' WHERE customerID = $cusID";
            $statement = $this->_dbHandle->prepare($updateQuery); // prepare a PDO statement
            $statement->execute(); // execute the PDO statement

            echo "<div class=\"col-xs-12 message\">";
                echo "Password reset successful!";
            echo "</div>";

            return $dataSet;
        }
        else
        {
            echo "<div class=\"col-xs-12 warning\">";
                echo "  ***Cannot Reset: your old password is invalid";
            echo "</div>";
        }
    }

    /**
     * The function for returning simply the rows of columns when specified the email.
     * @param $email
     * @return int
     */
    public  function checkEmail($email) {
        $sqlQuery = "SELECT * FROM Customers WHERE email = '$email'";
        $statement =$this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        return $statement->rowCount();
    }

    /**
     * The function for returning simply the rows of columns when specified the mobile number.
     * @param $mobile
     * @return int
     */
    public  function checkMobile($mobile) {
        $sqlQuery = "SELECT * FROM Customers WHERE mobile = '$mobile'";
        $statement =$this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        return $statement->rowCount();
    }

    /**
     * @param $address
     * @param $customerID
     * The function for updating the address of a customer when specified the new address and the customer ID as the parameters.
     */
    public function updateAddress($address, $customerID) {
        $sqlQuery = "UPDATE Customers SET address = '$address' WHERE customerID = $customerID";
        $statement =$this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    /**
     * @param $postcode
     * @param $customerID
     * The function for updating the postcode of a customer when specified the new postcode and the customer ID as the parameters.
     */
    public function updatePostcode($postcode, $customerID) {
        $sqlQuery = "UPDATE Customers SET postcode = '$postcode' WHERE customerID = $customerID";
        $statement =$this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    /**
     * @param $mobile
     * @param $customerID
     * The function for updating the mobile number of a customer when specified the new mobile number and the customer ID as the parameters.
     */
    public function updateMobile($mobile, $customerID) {
        $sqlQuery = "UPDATE Customers SET mobile = '$mobile' WHERE customerID = $customerID";
        $statement =$this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    /**
     * @param $email
     * @param $customerID
     * The function for updating the email of a customer when specified the new email and the customer ID as the parameters.
     */
    public function updateEmail($email, $customerID) {
        $sqlQuery = "UPDATE Customers SET email = '$email' WHERE customerID = $customerID";
        $statement =$this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
    }
}