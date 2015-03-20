<?php
/**
 * @file
 * @brief Base class for all table classes
 */

/**
 * Base class for all table classes
 */
class Table {
    protected $site;        ///< The Site object
    protected $tableName;   ///< The table name to use

    /**
     * Constructor
     * @param Site $site The site object
     * @param $name string base table name
     */
    public function __construct(Site $site, $name) {
        $this->site = $site;
        $this->tableName = $site->getTablePrefix() . $name;
    }

    /**
     * Get the database table name
     * @return string table name
     */
    public function getTableName() {
        return $this->tableName;
    }

    /**
     * Database connection function
     * @returns PDO object that connects to the database
     */
    public function pdo() {
        return $this->site->pdo();
    }
}