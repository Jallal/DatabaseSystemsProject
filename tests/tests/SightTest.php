<?php
/** @file
 * @brief Unit tests for the class Sight
 * @cond
 */
class SightTest extends \PHPUnit_Framework_TestCase
{
	public function test_construct() {
		$row = array('id' => 22,
			'userid' => 7,
			'name' => "Sparty",
			'description' => "The greatest mascot on Earth",
			'created' => '2015-01-22 12:50:26');
		$sight = new Sight($row);

		$this->assertEquals(22, $sight->getId());
		$this->assertEquals(7, $sight->getUserid());
		$this->assertEquals('Sparty', $sight->getName());
		$this->assertEquals('The greatest mascot on Earth', $sight->getDescription());
		$this->assertEquals(strtotime('2015-01-22 12:50:26') , $sight->getCreated());
	}
}

/// @endcond
?>
