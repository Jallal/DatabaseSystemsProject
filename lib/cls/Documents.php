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


    public function get($id) {
        $sql =<<<SQL
SELECT * from $this->tableName
where DocID=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new Document($statement->fetch(PDO::FETCH_ASSOC));
    }

    public function AllProjectDocuments($Projid) {
        $sql = <<<SQL
SELECT
    d.*
FROM
        $this->tableName d
    INNER JOIN
        ( SELECT
              ProjID, Filename, MAX(versionNo) AS latest
          FROM
              $this->tableName
          GROUP BY
              Filename
        ) AS groupedp
      ON  groupedp.Filename = d.Filename
      AND groupedp.latest = d.versionNo
      AND d.ProjID=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($Projid));
        if ($statement->rowCount() === 0) {
            return false;
        }
        $countries = $statement->fetchAll();

        $result = array();  // Empty initial array
        foreach ($countries as $row) {
            $result[] = new Document($row);
        }


        return $result;
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

    public function createDocument($name, $projid, $projownerid, $creatorid, $content, $size, $type) {
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
INSERT INTO $this->tableName (ProjID, ProjOwnerID, creatorID, Filename, versionNo, create_time, content, size, type)
values (?, ?, ?, ?, ?, ?, ?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($projid, $projownerid, $creatorid, $name, 1, date("Y-m-d H:i:s"), $content, $size, $type));
        return true;
    }

    public function updateDocument($name, $projid, $userid, $content, $size, $type) {
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
INSERT INTO $this->tableName (ProjID, ProjOwnerID, creatorID, Filename, versionNo, create_time, parentDocID, content, size, type)
values (?,?,?,?,?,?,?,?,?,?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($projid, $projownerid, $userid, $name, $version, date("Y-m-d H:i:s"), $parentid, $content, $size, $type));
        return true;
    }

    public function getDocTree($name, $projid) {
        $sql = <<<SQL
SELECT DocID, Filename, versionNo, creatorID, create_time, parentDocID from $this->tableName
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

    public function deleteDoc($docid, $userid) {
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

        if ($deletedoc->getCreatorid() !== $userid) {
            return array(false,$deletedoc);
        }


        // if its the original document, then delete it and all of its children
        if (intval($deletedoc->getVersion()) === 1) {
            $projid = intval($deletedoc->getProjid());
            $name = $deletedoc->getName();
            $sql = <<< SQL
DELETE from $this->tableName
where ProjID=? and Filename=?
SQL;

            $statement = $this->pdo()->prepare($sql);
            $statement->execute(array($projid, $name));
            return array(true, $deletedoc);
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
            if ($updatedoc !== null) {
                $sql = <<<SQL
UPDATE $this->tableName
SET parentDocID=?
where DocID=?
SQL;

                $statement = $this->pdo()->prepare($sql);
                $statement->execute(array($deletedoc->getParentdocid(), $updatedoc->getId()));
            }
            return array(true, $deletedoc);
        }
    }
}