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
        $this->id = $row['DocID'];
        $this->projid = $row['ProjID'];
        $this->projownerid = $row['ProjOwnerID'];
        $this->creatorid = $row['creatorID'];
        $this->filename = $row['Filename'];
        $this->version = $row['versionNo'];
        $this->create_time = strtotime($row['create_time']);
        $this->parentdocid = $row['parentDocID'];
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