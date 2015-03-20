<?php
/** @file
 * @brief Empty unit testing template/database version
 * @cond 
 * @brief Unit tests for the class 
 */

class SightsControllerTest extends \PHPUnit_Extensions_Database_TestCase
{
    private static $site;
    private static $insertedSightId;

    public static function setUpBeforeClass() {
        self::$site = new Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }

    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        return $this->createDefaultDBConnection(self::$site->pdo(), 'madejekz');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/sight.xml');
    }

    public function test_construct() {
        $row = array('id' => 12,
            'userid' => 'dude',
            'name' => 'The Dude',
            'email' => 'dude@ranch.com',
            'password' => '12345678',
            'joined' => '2015-01-15 23:50:26',
            'role' => '1');
        $user = new User($row);
        $controller = new SightsController(self::$site, $user, array());
        $this->assertInstanceOf('SightsController', $controller);
        $this->assertEquals("/~madejekz/step5", $controller->getPage());
    }

    public function test_insert() {
        $row = array('id' => 12,
            'userid' => 'dude',
            'name' => 'The Dude',
            'email' => 'dude@ranch.com',
            'password' => '12345678',
            'joined' => '2015-01-15 23:50:26',
            'role' => '1');

        $insert = array('name' => 'Test',
            'description' => 'Test Sight');
        $user = new User($row);
        $controller = new SightsController(self::$site, $user, array());
        $controller->insert($insert);
        $this->assertNotNull($controller->getLastInsertedId());
        self::$insertedSightId = $controller->getLastInsertedId();
    }

    public function test_deleteSight() {
        $row = array('id' => 12,
            'userid' => 'dude',
            'name' => 'The Dude',
            'email' => 'dude@ranch.com',
            'password' => '12345678',
            'joined' => '2015-01-15 23:50:26',
            'role' => '1');
        $user = new User($row);
        $deleteThis = array('d' => self::$insertedSightId);
        $controller = new SightsController(self::$site, $user, $deleteThis);
        $this->assertTrue($controller->didDeleteWork());
    }
}

/// @endcond
?>
