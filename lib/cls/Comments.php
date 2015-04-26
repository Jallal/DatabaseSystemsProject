<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 4/3/15
 * Time: 5:43 PM
 */


class Comments  extends Table {
    /**
     * Constructor
     * @param $site Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "COMMENT");
    }

    public function getCommentsbyDOCid($DOCid) {

        $sql =<<<SQL
SELECT * FROM $this->tableName
where DocID=?
SQL;

        $pdo =$this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($DOCid));


        $result = array();
        foreach($statement as $row) {
            $result[] = new  Comment($row);
        }

        return $result;

    }

    public function getCommentbyUID($Uid) {

        $sql =<<<SQL
SELECT * FROM $this->tableName
where CommenterID=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($Uid));

        $result = array();
        foreach($statement as $row) {
            $result[] = new  Comment($row);
        }

        return $result;


    }



    public function createCommentsForDOC($userid,$DocID,$message)  {
        $datetime =  date("Y-m-d h:i:s");

        $sql =<<<SQL
INSERT INTO $this->tableName(CommenterID, DocID,Timestamp ,Message)
values(?, ?,?,?);

SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        if($statement->execute(array($userid,$DocID,$datetime,$message)))
        {
            return true;
        }
        else{
            false;
        }

    }

    public function deleteCommentForDOC($userid,$DocID)  {



        $sql =<<<SQL
DELETE FROM $this->tableName WHERE CommenterID=? AND $DocID=?

SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        if($statement->execute(array($userid,$DocID)))
        {
            return true;
        }
        else{
            false;
        }

    }






}