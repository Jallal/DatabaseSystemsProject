<?php
/** @file
 * @cond 
 * @brief Unit tests for the class UserView
 */

class UserViewTest extends \PHPUnit_Extensions_Database_TestCase
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
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/full.xml');
    }

    public function test_getName() {
        $row = array('id' => 12,
            'userid' => 'dude',
            'name' => 'The Dude',
            'email' => 'dude@ranch.com',
            'password' => '12345678',
            'joined' => '2015-01-15 23:50:26',
            'role' => '1');
        $user = new User($row);

        $view = new UserView(self::$site, $user, array('i'=>'8'));
        $this->assertEquals("Charles Owen", $view->getName());

        $view = new UserView(self::$site, $user, array());
        $this->assertEquals("The Dude", $view->getName());
    }

    public function test_presentSights() {
        // User 9 has no sights, so presentSights should return empty
        $view = new UserView(self::$site, null, array('i'=>'9'));
        $this->assertEquals("", $view->presentSights());

        // User 8 has one sight
        $view = new UserView(self::$site, null, array('i' => '8'));
        $html = $view->presentSights();
        $right = <<<HTML
<div class="options">
<h2>SIGHTS</h2>
<p><a href="sight.php?i=44">Tom Izzo</a></p>
</div>
HTML;

        $this->assertXmlStringEqualsXmlString($right, $html);

        // User 7 has two sights
        $view = new UserView(self::$site, null, array('i' => '7'));
        $html = $view->presentSights();
        $right = <<<HTML
<div class="options">
<h2>SIGHTS</h2>
<p><a href="sight.php?i=46">Belmont Tower</a></p>
<p><a href="sight.php?i=47">MSU Union</a></p>
</div>
HTML;

        $this->assertXmlStringEqualsXmlString($right, $html);
    }
	
}

/// @endcond
?>
