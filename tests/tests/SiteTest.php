<?php
/** @file
 * @cond 
 * @brief Unit tests for the class Site
 */
class SiteTest extends \PHPUnit_Framework_TestCase
{
	public function test_setEmail() {
		$site = new Site();
		$site->setEmail("test@test.com");

		$this->assertEquals("test@test.com", $site->getEmail());
	}

	public function test_setRoot() {
		$site = new Site();
		$site->setRoot("http://webdev.cse.msu.edu/~madejekz/step5/");

		$this->assertEquals("http://webdev.cse.msu.edu/~madejekz/step5/", $site->getRoot());
	}

	public function test_getTablePrefix() {
		$site = new Site();
		$site->dbConfigure("this", "is", "a", "test");

		$this->assertEquals("test", $site->getTablePrefix());
	}

	public function test_localize() {
		$site = new Site();
		$localize = require 'localize.inc.php';
		if(is_callable($localize)) {
			$localize($site);
		}
		$this->assertEquals('test_', $site->getTablePrefix());
	}
}

/// @endcond
?>
