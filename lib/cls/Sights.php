<?php
/**
 * Created by PhpStorm.
 * User: Zachary
 * Date: 3/16/2015
 * Time: 2:15 PM
 */

class Sights extends Table {
    /**
     * Constructor
     * @param $site Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "sight");
    }

    /**
     * Get a sight by id
     * @param $id int ID of the sight
     * @returns Sight object if successful, null otherwise.
     */
    public function get($id) {
        $sql =<<<SQL
SELECT * from $this->tableName
where id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new Sight($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Get all sights for a given user
     * @param $id int user ID
     * @returns array of Sight objects
     */
    public function getSightsForUser($id) {
        $sql =<<<SQL
SELECT * from $this->tableName
where userid=?
order by name
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));

        $result = array();  // Empty initial array
        foreach($statement as $row) {
            $result[] = new Sight($row);
        }

        return $result;
    }

    /**
     * @param $userid int userid of user who made the sight
     * @param $name string name of the person sighted
     * @param $description string description of the sighting
     * @returns int id of the inserted sight
     */
    public function newSight($userid, $name, $description) {
        $sql =<<<SQL
INSERT INTO $this->tableName (userid, name, description, created)
VALUES (?, ?, ?, ?)
SQL;

        $created = date("Y-m-d H:i:s");
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        if ($statement->execute(array($userid, $name, $description, $created))) {
            return $pdo->lastInsertId();
        } else {
            return null;
        }
    }

    /**
     * @param int $id of the sight being deleted
     * @return boolean if the deletion was successful
     */
    public function deleteSight($id) {
        $sql =<<<SQL
DELETE FROM $this->tableName
WHERE id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        return $statement->execute(array($id));
    }
}