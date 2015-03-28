<?php
/**
 * Created by PhpStorm.
 * User: Zachary
 * Date: 3/15/2015
 * Time: 2:59 PM
 */

class User {
    private $id;        ///< ID for this user in the user table
    private $userid;    ///< User-supplied ID
    private $name;      ///< What we call you by
    private $email;     ///< Email address
    private $city;      ///< City the user is from
    private $state;     ///< State the user is from
    private $privacy;   ///< Privacy setting for the user
    Private $birthyear; ///< Year the person was born

    /**
     * Constructor
     * @param $row array Row from the user table in the database
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->userid = $row['userid'];
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->city = $row['city'];
        $this->state = $row['state'];
        $this->privacy = $row['privacy'];
        $this->birthyear = $row['birthyear'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getPrivacy()
    {
        return $this->privacy;
    }

    /**
     * @return mixed
     */
    public function getBirthyear()
    {
        return $this->birthyear;
    }
}