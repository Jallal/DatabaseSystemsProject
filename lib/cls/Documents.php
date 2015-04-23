<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 4/3/15
 * Time: 5:42 PM
 */




class Documents extends Table {
    /**
     * Constructor
     * @param $site Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "Document");
    }




    public function AllUserDocuments($userid) {
        $sql=<<<SQL
SELECT * from $this->tableName
WHERE creatorid=?
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
            $result[] = new  Document($row);
        }


        return $result;
    }

    public function DocumentsCount($id) {
        $sql=<<<SQL
SELECT count(*) AS COUNT from $this->tableName
WHERE creatorid=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        $count = 0;
        if($statement->rowCount() === 0) {
            return $count;
        }
        foreach($statement as $row) {
            $count = $row['COUNT'];

        }

        return  $count;
    }

    public function createDocument($name, $projid, $projownerid, $creatorid) {
        $sql = <<< SQL
INSERT INTO $this->tableName (ProjID, ProjOwnerID, creatorID, Filename, versionNo, create_time)
values (?, ?, ?, ?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($projid, $projownerid, $creatorid, $name, 1, date("Y-m-d H:i:s")));
    }

}