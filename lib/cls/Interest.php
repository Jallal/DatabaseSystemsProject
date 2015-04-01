<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 4/1/15
 * Time: 12:21 AM
 */

class Interest {

    private $interest;             ///< ID for this sight in the sight table///< date and time of the sighting
    private $userid;         ///< id of the person sighted

    /**
     * Constructor
     * @param $row Row from the sight table in the database
     */
    public function __construct($row) {
        $this->interest = $row['interest'];
        $this->userid = $row['userid'];
    }

    public function getInterest()
    {
        return $this->interest;
    }

    public function getUerID()
    {
        return $this->userid;
    }





}