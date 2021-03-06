<?php
/**
 * Created by PhpStorm.
 * User: madejekz
 * Date: 3/30/2015
 * Time: 9:25 PM
 */

class Friendship extends Table {

    /**
     * Constructor
     * @param $site Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "Friendship");
    }

    public function addRequest($sender, $receiver) {
        if ($sender == $receiver) {
            return;
        }
        $sql = <<<SQL
INSERT INTO $this->tableName(senderid, recipientid, status)
VALUES (?, ?, 'pending')
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($sender, $receiver));
    }



public function RemoveFriend($receiver, $sender){

    $sql=<<<SQL
DELETE FROM $this->tableName
WHERE (senderid=? AND recipientid=?) or (senderid=? and recipientid=?)
SQL;

    $statement = $this->pdo()->prepare($sql);
    $statement->execute(array($receiver, $sender, $sender, $receiver));

}

    public function acceptRequest($receiver, $sender) {
        $sql = <<<SQL
UPDATE $this->tableName
SET status='true'
WHERE senderid=? and recipientid=?
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($sender, $receiver));
    }





    public function getPendingForUser($id) {
        $sql=<<<SQL
SELECT * from $this->tableName
WHERE recipientid=? and status='pending'
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));

        $users = new Users($this->site);

        $result = array();  // Empty initial array
        foreach($statement as $row) {
            $user = $users->get($row['senderid']);
            $result[] = $user;
        }

        return $result;
    }

    public function getCurrentFriends($id) {
        $sql=<<<SQL
SELECT * from $this->tableName
WHERE (senderid=? or recipientid=?) and status='true'
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id,$id));

        $users = new Users($this->site);

        $result = array();  // Empty initial array
        foreach($statement as $row) {
            if ($row['recipientid'] !== $id) {
                $user = $users->get($row['recipientid']);
                $result[] = $user;
            } elseif($row['senderid'] !== $id) {
                $user = $users->get($row['senderid']);
                $result[] = $user;
            }
        }

        return $result;
    }

    public function doesfreindshipExist($id,$freindsId) {
        $sql=<<<SQL
SELECT * from $this->tableName
WHERE ((senderid=? and recipientid=?) OR (senderid=? and recipientid=?)) and status='true'
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id,$freindsId,$freindsId,$id));
        if($statement->rowCount() === 0) {
            return false;
        }

        return true;
    }

    public function doesPendingExist($id,$freindsId) {
        $sql=<<<SQL
SELECT * from $this->tableName
WHERE ((senderid=? and recipientid=?) OR (senderid=? and recipientid=?)) and status='pending'
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id,$freindsId,$freindsId,$id));
        if($statement->rowCount() === 0) {
            return false;
        }

        return true;
    }


    public function CountFriends($id) {
        $sql=<<<SQL
SELECT count(*) AS COUNT from $this->tableName
WHERE (senderid=? or recipientid=?) and status='true'
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id,$id));
        $count = 0;
        if($statement->rowCount() === 0) {
            return $count;
        }
        foreach($statement as $row) {
            $count = $row['COUNT'];

        }

        return  $count;
    }
}