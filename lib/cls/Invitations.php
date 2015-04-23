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
WHERE (a.ProjID = b.ProjID) and (a.collaboratorID=? and b.collaboratorID=?)
SQL;
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid,$collab));
        if($statement->rowCount() > 0) {
            return true;
        }

        return false;
    }
}