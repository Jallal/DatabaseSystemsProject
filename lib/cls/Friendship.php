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
        $sql = <<<SQL
INSERT INTO $this->tableName(senderid, recipientid, status)
VALUES (?, ?, 'pending')
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($sender, $receiver));
    }

    public function acceptRequest($sender, $receiver) {
        $sql = <<<SQL
UPDATE $this->tableName
SET status='true'
WHERE senderid=? and recipientid=?
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($sender, $receiver));

        $sql=<<<SQL
INSSERT INTO $this->tableName(senderid, recipientid, status)
VALUES(?, ?, 'true')
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($receiver, $sender));
    }
}