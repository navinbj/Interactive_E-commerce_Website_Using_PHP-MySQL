<?php

require_once('Database.php');

/**
 * The class Login connects to a database in order to establish communication with the customer table
 * and the get the email and password rows required for the customer login validation.
 */
class Login {
    protected $_dbHandle, $_dbInstance;

    /**
     * Login constructor.
     */
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * The method for returning an array of all registered customers' email address for the purpose of email validation.
     * @return array
     * @param $email
     * @param $password
     * @return bool
     */
    public function login($email, $password) {

        $sqlQuery = "SELECT * FROM Customers WHERE email = '$email'";
        $statement =$this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet = $row;    //storing the row of details of a customer into an array
        }

        // this first decrypts the password obtained from the database into a readable format and then checks if it matches with the password a customer has entered.
        $result = password_verify($password, $dataSet['password']);

        if ($result){
            return $dataSet;
        }
        else
        {
            //echo "Login failed";
        }
    }
}