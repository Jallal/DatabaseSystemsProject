<?php
/** @file
 * @brief Unit tests for the class Sights
 * @cond
 */

class SightsTest extends \PHPUnit_Extensions_Database_TestCase
{
    private static $site;
    private $insertedSightId;

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
        $sights = new Sights(self::$site);
        $this->assertInstanceOf('Sights', $sights);
    }

    public function test_get() {
        $sights = new Sights(self::$site);

        // Test a valid get based on id
        $sight = $sights->get(44);
        $this->assertEquals(44, $sight->getId());
        $this->assertEquals(8, $sight->getUserid());
        $this->assertEquals('Tom Izzo', $sight->getName());
        $this->assertEquals('What a coach!', $sight->getDescription());
        $this->assertEquals(strtotime("1995-06-15 11:50:26"), $sight->getCreated());

        // Test a failed get
        $sight = $sights->get(54);
        $this->assertNull($sight);
    }

    public function test_getSightsForUser() {
        $sights = new Sights(self::$site);

        // User 9 has no sights
        $result = $sights->getSightsForUser(9);
        $this->assertEmpty($result);

        // User 8 has one sight
        $result = $sights->getSightsForUser(8);
        $this->assertEquals(1, count($result));
        $this->assertEquals("Tom Izzo", $result[0]->getName());

        // User 7 has two
        $result = $sights->getSightsForUser(7);
        $this->assertEquals(2, count($result));
        $this->assertEquals("Belmont Tower", $result[0]->getName());
        $this->assertEquals("MSU Union", $result[1]->getName());
    }

    public function test_newSight() {
        $sights = new Sights(self::$site);

        $insertId = $sights->newSight(7, "test", "test");
        $this->assertNotNull($insertId);
        $this->insertedSightId = $insertId;
    }

    public function test_deleteSight() {
        $sights = new Sights(self::$site);
        $this->assertTrue($sights->deleteSight($this->insertedSightId));
    }
}

/// @endcond
?>