<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 4/26/15
 * Time: 7:01 PM
 */

class SearchbyInterest {
    private $userid;
    private $interest;



    public function __construct($row) {
        $this->userid = $row['userid'];
        $this->interest = $row['interest'];
    }

    public function getuserid()
    {
        return $this->userid;
    }



    public function getUserInterest()
    {
        return $this->interest;
    }

}