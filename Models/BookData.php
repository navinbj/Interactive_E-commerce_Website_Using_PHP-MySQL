<?php
/**
 * Created by PhpStorm.
 * User: stc392
 * Date: 22/11/16
 * Time: 14:38
 *
 * The class BookData stores every bit of information about a particular book retrieved from a database.
 */

class BookData {

    protected $_title, $_author, $_yearPublished, $_genre, $_price, $_image, $_iSBNNo, $_quantity, $_description;

    public function __construct($dbRow) {
        $this->_title = $dbRow['title'];
        $this->_author = $dbRow['author'];
        $this->_yearPublished = $dbRow['yearPublished'];
        $this->_genre = $dbRow['genre'];
        $this->_price = $dbRow['price'];
        $this->_image = $dbRow['image'];
        $this->_iSBNNo = $dbRow['iSBNNo'];
        $this->_quantity = $dbRow['quantity'];
        $this->_description = $dbRow['description'];
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->_author;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * @return mixed
     */
    public function getYearPublished()
    {
        return $this->_yearPublished;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->_genre;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->_price;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->_image;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->_description;
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
    public function getQuantity()
    {
        return $this->_quantity;
    }
}