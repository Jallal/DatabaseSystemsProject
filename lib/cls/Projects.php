<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 4/3/15
 * Time: 5:42 PM
 */



class Projects  extends Table {
    /**
     * Constructor
     * @param $site Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "Project");
    }


    public function AllUserProjects($userid) {
        $sql=<<<SQL
SELECT *from $this->tableName
WHERE ownerid=?
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
            $result[] = new  Project($row);
        }


        return $result;
    }

    public function ProjectsCount($id) {
        $sql=<<<SQL
SELECT count(*) AS COUNT from $this->tableName
WHERE ownerid=?
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