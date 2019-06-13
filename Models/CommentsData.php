<?php
/**
 * Created by PhpStorm.
 * User: stc392
 * Date: 02/12/16
 * Time: 20:27
 *
 * The class CommentsData holds the information about the comment posted by a particular user for
 *  a particular book.
 */
class CommentsData {

    protected $_commentID, $_comment, $_iSBNNo, $_customerID, $_dateTime;

    /**
     * CommentsData constructor. The constructor for the objects of class CommentsData.
     * @param $dbRow
     */
    public function __construct($dbRow) {
        $this->_commentID = $dbRow['commentID'];
        $this->_comment = $dbRow['comment'];
        $this->_iSBNNo = $dbRow['iSBNNo'];
        $this->_customerID = $dbRow['customerID'];
        $this->_dateTime = $dbRow['dateTime'];
    }

    /**
     * @return mixed
     */
    public function getCommentID()
    {
        return $this->_commentID;
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
    public function getComment()
    {
        return $this->_comment;
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
    public function getDateTime()
    {
        return $this->_dateTime;
    }
}