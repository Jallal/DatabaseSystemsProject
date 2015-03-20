<?php
/** @file
 * @cond 
 * @brief Unit tests for the class User
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
	public function test_construct() {
		$row = array('id' => 12,
			'userid' => 'dude',
			'name' => 'The Dude',
			'email' => 'dude@ranch.com',
			'password' => '12345678',
			'joined' => '2015-01-15 23:50:26',
			'role' => '1');
		$user = new User($row);
		$this->assertEquals(12, $user->getId());
		$this->assertEquals('dude', $user->getUserid());
		$this->assertEquals('The Dude', $user->getName());
		$this->assertEquals('dude@ranch.com', $user->getEmail());
		$this->assertEquals(strtotime('2015-01-15 23:50:26'), $user->getJoined());
		$this->assertEquals(1, $user->getRole());
	}
}

/// @endcond
?>
