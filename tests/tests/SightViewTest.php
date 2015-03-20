<?php
/** @file
 * @brief Unit tests for the class SightView
 * @cond
 */

class SightViewTest extends \PHPUnit_Extensions_Database_TestCase
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

    public function test_construct() {
        $view = new SightView(self::$site, array('i' => '46'));
        $this->assertInstanceOf('SightView', $view);
    }

    public function test_getName() {
        $view = new SightView(self::$site, array('i' => '46'));
        $this->assertEquals("Belmont Tower", $view->getName());
    }

    public function test_getDescription() {
        $view = new SightView(self::$site, array('i' => '46'));
        $this->assertEquals("You know it doesn't move, right?", $view->getDescription());
    }

    public function test_presentSuper()
    {
        $view = new SightView(self::$site, array('i' => '46'));
        $super = $view->presentSuper();

        $right = <<<HTML
<div class="options">
<h2>SUPER SIGHTER</h2>
<p><a href="./?i=7">The Dudess</a></p>
<p>Since 6-25-2014</p>
</div>
HTML;

        //echo htmlentities($right);
        //echo htmlentities($super);
        $this->assertXmlStringEqualsXmlString($right, $super);

        $view = new SightView(self::$site, array('i' => '44'));
        $super = $view->presentSuper();

        $right = <<<HTML
<div class="options">
<h2>SUPER SIGHTER</h2>
<p><a href="./?i=8">Charles Owen</a></p>
<p>Since 6-15-1995</p>
</div>
HTML;

        //echo htmlentities($right);
        //echo htmlentities($super);
        $this->assertXmlStringEqualsXmlString($right, $super);


    }
}

/// @endcond
?>