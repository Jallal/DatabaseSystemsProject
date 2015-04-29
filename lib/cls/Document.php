<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 4/3/15
 * Time: 5:42 PM
 */

class Document {
    private $id;
    private $projid;
    private $projownerid;
    private $creatorid;
    private $filename;
    private $version;
    private $create_time;
    private $parentdocid;
    private $content;
    private $size;
    private $type;

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
        $this->content = $row['content'];
        $this->size = $row['size'];
        $this->type = $row['type'];
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getProjid()
    {
        return $this->projid;
    }

    /**
     * @return mixed
     */
    public function getProjownerid()
    {
        return $this->projownerid;
    }

    /**
     * @return mixed
     */
    public function getCreatorid()
    {
        return $this->creatorid;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return int
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     * @return mixed
     */
    public function getParentdocid()
    {
        return $this->parentdocid;
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