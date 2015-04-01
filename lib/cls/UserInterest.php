<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 3/31/15
 * Time: 6:12 PM
 */

class UserInterest {

       ///< ID for this user in the user table
    private $userid;    ///< User-supplied ID
    private $interest;      ///< What we call you by

    /**
     * Constructor
     * @param $row array Row from the user table in the database
     */
    public function __construct($row) {
        $this->interest = $row['interest'];
        $this->userid = $row['userid'];

    }

    /**
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @return mixed
     */
    public function getInterest ()
    {
        return $this->interest ;
    }

}