<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 3/27/15
 * Time: 12:53 PM
 */

class Search {

    private $id;        ///< ID for this the sight in the table
    private $name;      ///< The name of the sight
    private $privacy;
    private $userid;



    public function __construct($row) {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->userid = $row['userid'];
        $this->privacy = $row['privacy'];
    }

    public function getId()
    {
        return $this->id;
    }
    public function getuserid()
    {
        return $this->userid;
    }


    public function getName()
    {
        return $this->name;
    }

    public function getPrivacy() {
        return $this->privacy;
    }



}