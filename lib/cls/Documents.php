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
        if($statement->rowCount() === 0) {
            return false;
        }
        foreach($statement as $row) {
            $count = $row['COUNT'];

        }

        return  $count;
    }

}