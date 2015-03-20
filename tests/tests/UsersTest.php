<?php
/** @file
 * @cond 
 * @brief Unit tests for the class Users
 */

class UsersTest extends \PHPUnit_Extensions_Database_TestCase
{
    private static $site;

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
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/user.xml');
    }

    public function test_construct() {
        $users = new Users(self::$site);
        $this->assertInstanceOf('Users', $users);
    }

    public function test_login() {
        $users = new Users(self::$site);

        // Test a valid login based on user ID
        $user = $users->login("dudette", "87654321");
        $this->assertInstanceOf("User", $user);
        $this->assertEquals("dudess@dude.com", $user->getEmail());
        $this->assertEquals("The Dudess", $user->getName());
        $this->assertEquals(1, $user->getRole());
        $this->assertEquals("dudette", $user->getUserid());
        $this->assertEquals(1421988626, $user->getJoined());

        // Test a valid login based on email address
        $user = $users->login("dudess@dude.com", "87654321");
        $this->assertInstanceOf("User", $user);

        // Test a failed login
        $user = $users->login("dudess@dude.com", "wrongpw");
        $this->assertNull($user);
    }

    public function test_get() {
        $users = new Users(self::$site);

        // test valid id
        $user = $users->get(7);
        $this->assertInstanceOf("User", $user);
        $this->assertEquals("dudess@dude.com", $user->getEmail());
        $this->assertEquals("The Dudess", $user->getName());
        $this->assertEquals(1, $user->getRole());
        $this->assertEquals("dudette", $user->getUserid());
        $this->assertEquals(1421988626, $user->getJoined());

        // test invalid id
        $user = $users->get(1);
        $this->assertNull($user);
    }
	
}

/// @endcond
?>
