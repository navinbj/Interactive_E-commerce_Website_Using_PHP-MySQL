<?php
/**
 * Created by PhpStorm.
 * User: stc392
 * Date: 02/12/16
 * Time: 20:27
 *
 * The class BasketData holds the information about the number of books a user has
 * in his basket.
 */


class BasketData {

    protected $_basketID, $_quantity, $_iSBNNo, $_customerID;

    /**
     * BasketData constructor. The constructor for the objects of class BasketData.
     * @param $dbRow
     */
    public function __construct($dbRow) {
        $this->_basketID = $dbRow['basketID'];
        $this->_quantity = $dbRow['quantity'];
        $this->_iSBNNo = $dbRow['iSBNNo'];
        $this->_customerID = $dbRow['customerID'];
    }

    /**
     * @return mixed
     */
    public function getBasketID()
    {
        return $this->_basketID;
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
    public function getQuantity()
    {
        return $this->_quantity;
    }

    /**
     * @return mixed
     */
    public function getISBNNo()
    {
        return $this->_iSBNNo;
    }
}