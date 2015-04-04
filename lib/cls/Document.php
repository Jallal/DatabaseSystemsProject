<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 4/3/15
 * Time: 5:42 PM
 */

class Document {
    private $id;             ///< ID for this sight in the sight table
    private $projid;           ///< name for the person sighted in the sight table
    private $projownerid;    ///< description of the sighting
    private $creatorid;        ///< date and time of the sighting
    private $filename;         ///< id of the person sighted
    private $version;
    private $create_time;
    private $parentdocid;
    /**
     * Constructor
     * @param $row Row from the sight table in the database
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->projid = $row['projid'];
        $this->projownerid = $row['projownerid'];
        $this->creatorid = strtotime($row['creatorid']);
        $this->filename = $row['filename'];
        $this->version = $row['version'];
        $this->create_time = $row['create_time'];
        $this->parentdocid = $row['parentdocid'];
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
        return $this->filename;
    }
}