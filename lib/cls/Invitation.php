<?php
/**
 * Created by PhpStorm.
 * User: Zachary
 * Date: 4/22/2015
 * Time: 7:47 PM
 */

class Invitation {
    private $projid;
    private $ownerid;
    private $collaboratorid;
    private $status;

    public function __construct($row) {
        $this->projid = $row['ProjID'];
        $this->ownerid = $row['OwnerID'];
        $this->collaboratorid = $row['collaboratorID'];
        $this->status = $row['status'];
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
    public function getOwnerid()
    {
        return $this->ownerid;
    }

    /**
     * @return mixed
     */
    public function getCollaboratorid()
    {
        return $this->collaboratorid;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }


}