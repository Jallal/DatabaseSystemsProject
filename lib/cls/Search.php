<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 3/27/15
 * Time: 12:53 PM
 */

class Search {

    private $id;        ///< ID for this the sight in the table
    private $name;      ///< The name of the sight



    public function __construct($row) {
        $this->id = $row['id'];
        $this->name = $row['name'];

    }

    public function getId()
    {
        return $this->id;
    }



    public function getName()
    {
        return $this->name;
    }



}