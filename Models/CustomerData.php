<?php
/**
 * Created by PhpStorm.
 * User: stc392
 * Date: 22/11/16
 * Time: 14:38
 */

/**
 * The class for storing all the customers' information retrieved from database, especially
 * the email and password which will be later used for the validation when a customer wants to login to the system.
 */
class CustomerData {

    protected $_customerID, $_firstname, $_surname, $_address, $_postcode, $_mobile, $_email, $_password;

    public function __construct($dbRow) {
        $this->_customerID = $dbRow['customerID'];
        $this->_firstname = $dbRow['firstname'];
        $this->_surname = $dbRow['surname'];
        $this->_address = $dbRow['address'];
        $this->_postcode = $dbRow['postcode'];
        $this->_mobile = $dbRow['mobile'];
        $this->_email = $dbRow['email'];
        $this->_password = $dbRow['password'];
    }

    /**
     * @return mixed
     */
    public function getCustomerID()
    {
        return $this->_customerID;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->_firstname;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->_surname;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->_postcode;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->_mobile;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->_password;
    }
}