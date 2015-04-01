<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 3/31/15
 * Time: 6:16 PM
 */

class Interests extends Table {



    /**
     * Constructor
     * @param $site Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "User_Interests");
    }

    public function newUserInterest($userid,$interest){

        if (strlen($interest)<1) {
            return null;
        }


        // Add a record to the User table
        $sql = <<<SQL
INSERT INTO $this->tableName(userid,interest)
values(?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($userid,$interest));

    }


    public function existUserInterest($userid,$interest){


        $sql =<<<SQL
SELECT * from $this->tableName
where userid=? AND interest=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid, $interest));
        if($statement->rowCount() === 0) {
            return false;
        }

        return true;

    }

    public function UpdateUserInterest($user,$interest){
        $userid = $user->getUserid();


        if(!($this->existUserInterest($userid,$interest))){

           return  $this->newUserInterest($userid,$interest);
        }

        $sql = <<<SQL
UPDATE $this->tableName
SET interest=?
WHERE userid=?
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($interest,$userid));

    }



    public function UserInterests($userid)
    {

        $sql = <<<SQL
SELECT * from $this->tableName
where userid=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid));
        if ($statement->rowCount() === 0) {
            return false;
        }
        $countries = $statement->fetchAll();

        $result = array();  // Empty initial array
        foreach ($countries as $row) {
            $result[] = new  Interest($row);
        }


        return $result;
    }


}