<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 4/3/15
 * Time: 5:43 PM
 */

class Comment {
    private $commenterid;             ///< ID for this sight in the sight table
    private $docid;           ///< name for the person sighted in the sight table
    private $message;    ///< description of the sighting
    private $timestamp;        ///< date and time of the sighting
        ///< id of the person sighted
    /**
     * Constructor
     * @param $row Row from the sight table in the database
     */
    public function __construct($row) {
        $this->commenterid = $row['CommenterID'];
        $this->docid = $row['DocID'];
        $this->message = $row['Message'];
        $this->timestamp = strtotime($row['Timestamp']);

    }

    /**
     * @return mixed
     */
    public function getcommenterId()
    {
        return $this->commenterid;
    }

    /**
     * @return mixed
     */
    public function getdocid()
    {
        return $this->docid;
    }
    public function getmessage()
    {
        return $this->message;
    }
    public function gettimestamp()
    {
        return $this->timestamp;
    }


}