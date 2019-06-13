<?php
/**
 * Created by PhpStorm.
 * User: stc392
 * Date: 02/12/16
 * Time: 20:27
 *
 * The class OrderHistoryData holds the information about the products that are purchased by a customer.
 */
class OrderHistoryData {

    protected $_orderID, $_customerID, $_iSBNNo, $_quantity, $_pricePerQty, $_totalPrice, $_dataTime;

    /**
     * OrderHistoryData constructor. The constructor for the objects of class OrderHistoryData.
     * @param $dbRow
     */
    public function __construct($dbRow) {
        $this->_orderID = $dbRow['orderID'];
        $this->_customerID = $dbRow['customerID'];
        $this->_iSBNNo = $dbRow['iSBNNo'];
        $this->_quantity = $dbRow['quantity'];
        $this->_pricePerQty = $dbRow['pricePerQty'];
        $this->_totalPrice = $dbRow['totalPrice'];
        $this->_dateTime = $dbRow['dateTime'];
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
    public function getDateTime()
    {
        return $this->_dateTime;
    }

    /**
     * @return mixed
     */
    public function getISBNNo()
    {
        return $this->_iSBNNo;
    }

    /**
     * @return mixed
     */
    public function getOrderID()
    {
        return $this->_orderID;
    }

    /**
     * @return mixed
     */
    public function getPricePerQty()
    {
        return $this->_pricePerQty;
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
    public function getTotalPrice()
    {
        return $this->_totalPrice;
    }
}