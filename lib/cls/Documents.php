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

    public function createDocument($name, $projid, $projownerid, $creatorid, $content) {
        $sql = <<< SQL
SELECT * from $this->tableName
where ProjID=? and Filename=?
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($projid, $name));

        if ($statement->rowCount() > 0) {
            return false;
        }

        $sql = <<< SQL
INSERT INTO $this->tableName (ProjID, ProjOwnerID, creatorID, Filename, versionNo, create_time, content)
values (?, ?, ?, ?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($projid, $projownerid, $creatorid, $name, 1, date("Y-m-d H:i:s"), $content));
    }

    public function updateDocument($name, $projid, $userid, $content) {
        $sql = <<< SQL
SELECT * from $this->tableName
where ProjID=? and Filename=?
ORDER BY versionNo DESC
LIMIT 1
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($projid, $name));

        if($statement->rowCount() === 0) {
            return false;
        }
        $version = 0;
        $projownerid = null;
        $parentid = null;
        foreach($statement as $row) {
            $projownerid = $row['ProjOwnerID'];
            $version = $row['versionNo'] + 1;
            $parentid = $row['DocID'];
        }

        $sql = <<<SQL
INSERT INTO $this->tableName (ProjID, ProjOwnerID, creatorID, Filename, versionNo, create_time, parentDocID, content)
values (?,?,?,?,?,?,?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($projid, $projownerid, $userid, $name, $version, date("Y-m-d H:i:s"), $parentid, $content));
    }

    public function getDocTree($name, $projid) {
        $sql = <<<SQL
SELECT * from $this->tableName
where ProjID=? and Filename=?
ORDER BY versionNo DESC
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($projid, $name));

        $result = array();
        foreach($statement as $row) {
            $result[] = new Document($row);
        }

        return $result;
    }

    public function deleteDoc($docid) {
        // get the document were deleting
        $sql = <<< SQL
SELECT * from $this->tableName
where DocID=?
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($docid));

        $deletedoc = null;
        foreach($statement as $row) {
            $deletedoc = new Document($row);
        }

        // if its the original document, then delete it and all of its children
        if ($deletedoc->getId() === 1) {
            $projid = $deletedoc->getProjid();
            $name = $deletedoc->getName();
            $sql = <<< SQL
DELETE from $this->tableName
where ProjID=? and Filename=?
SQL;

            $statement = $this->pdo()->prepare($sql);
            $statement->execute(array($projid, $name));
        } else {
            // if not, get the deleted document's child
            $projid = $deletedoc->getProjid();

            $sql = <<<SQL
SELECT * from $this->tableName
where parentDocID=? and ProjID=?
SQL;
            $statement = $this->pdo()->prepare($sql);
            $statement->execute(array($docid, $projid));

            $updatedoc = null;
            foreach($statement as $row) {
                $updatedoc = new Document($row);
            }

            // delete the document we want to delete
            $sql = <<<SQL
DELETE from $this->tableName
where DocID=?
SQL;

            $statement = $this->pdo()->prepare($sql);
            $statement->execute(array($docid));

            // then update the deleted doc's child to point to the deleted doc's parent
            $sql = <<<SQL
UPDATE $this->tableName
SET parentDocID=?
where DocID=?
SQL;

            $statement = $this->pdo()->prepare($sql);
            $statement->execute(array($deletedoc->getParentdocid(), $updatedoc->getId()));
        }
    }
}