<?php
/**
 * Created by PhpStorm.
 * User: Zachary
 * Date: 4/22/2015
 * Time: 7:52 PM
 */

class Invitations extends Table {
    public function __construct(Site $site) {
        parent::__construct($site, "Invitation");
    }

    public function allUserInvitations($userid) {
        $sql=<<<SQL
SELECT *from $this->tableName
WHERE collaboratorID=? and status='pending'
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid));
        if ($statement->rowCount() === 0) {
            return false;
        }
        $invites = $statement->fetchAll();


        $result = array();  // Empty initial array
        foreach ($invites as $row) {
            $result[] = new  Invitation($row);
        }


        return $result;
    }

    public function acceptRequest($projid, $userid) {
        $sql = <<<SQL
UPDATE $this->tableName
SET status='true'
WHERE ProjID=? and collaboratorID=?
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($projid, $userid));
    }



    public function RemoveRequest($projid, $userid){

        $sql=<<<SQL
DELETE FROM $this->tableName
WHERE (ProjID=? AND collaboratorID=?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($projid, $userid));

    }

    public function isCollaborator($userid, $collab) {
        $sql = <<<SQL
SELECT *
from $this->tableName
WHERE (OwnerID=? and collaboratorID=?) OR (OwnerID=? and collaboratorID=?) OR
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid,$collab,$collab,$userid));
        if($statement->rowCount() > 0) {
            return true;
        }

        $sql = <<<SQL
SELECT a.*
from $this->tableName a, $this->tableName b
WHERE (a.ProjID = b.ProjID) and (a.collaboratorID=? and b.collaboratorID=?) and (a.status='true' and b.status='true')
SQL;
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid,$collab));
        if($statement->rowCount() > 0) {
            return true;
        }

        return false;
    }



    public function allProjectColaborators($projID) {
        $sql=<<<SQL
SELECT *from $this->tableName
WHERE ProjID=? and status='true' and collaboratorID<>OwnerID
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($projID));
        if ($statement->rowCount() === 0) {
            return false;
        }
        $invites = $statement->fetchAll();
        $result = array();  // Empty initial array
        foreach ($invites as $row) {
            $result[] = new  Invitation($row);
        }


        return $result;
    }






    public function RemoveAllProjectColaborators($projID) {
        $sql=<<<SQL
DELETE  from $this->tableName
WHERE ProjID=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        if($statement->execute(array($projID))){
            return true;
        }else{
            return false;
        }

    }
    public function myProjColaborations($userid) {
        $sql=<<<SQL
SELECT *from $this->tableName
WHERE collaboratorID=? and status='true' and ProjID <>OwnerID
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid));
        if ($statement->rowCount() === 0) {
            return false;
        }
        $invites = $statement->fetchAll();


        $result = array();  // Empty initial array
        foreach ($invites as $row) {
            $result[] = new  Invitation($row);
        }


        return $result;
    }

    public function addUserToMyProj($ownerid,$inviteeid,$projid,$stat) {

        $sql=<<<SQL
INSERT INTO $this->tableName(ProjID,OwnerID,collaboratorID,status)  values(?,?,?,?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        if($statement->execute(array($projid,$ownerid,$inviteeid,$stat))) {
            return true;
        }

        return false;
    }

}