<?php

class Sight {
    private $id;             ///< ID for this sight in the sight table
    private $name;           ///< name for the person sighted in the sight table
    private $description;    ///< description of the sighting
    private $created;        ///< date and time of the sighting
    private $userid;         ///< id of the person sighted

    /**
     * Constructor
     * @param $row Row from the sight table in the database
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->description = $row['description'];
        $this->created = strtotime($row['created']);
        $this->userid = $row['userid'];
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

}