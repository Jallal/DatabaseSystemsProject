<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 4/3/15
 * Time: 5:42 PM
 */

class Project {
    private $id;             ///< ID for this sight in the sight table
    private $name;           ///< name for the person sighted in the sight table
    private $ownerid;         ///< id of the person sighted

    /**
     * Constructor
     * @param $row Row from the sight table in the database
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->name = $row['title'];
        $this->ownerid = $row['ownerid`'];

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
    public function getOwnerId()
    {
        return  $this->ownerid;
    }


}