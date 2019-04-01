<?php
/**
 * Hack4cause.
 *
 * @since   0.0.1
 * @package Hack4cause
 */
class Hack4cause_Test extends WP_UnitTestCase {

	/**
	 * Test if our class exists.
	 *
	 * @since  0.0.1
	 */
	function test_class_exists() {
		$this->assertTrue( class_exists( 'Hack4cause') );
	}

	/**
	 * Test that our main helper function is an instance of our class.
	 *
	 * @since  0.0.1
	 */
	function test_get_instance() {
		$this->assertInstanceOf(  'Hack4cause', hack4cause() );
	}

	/**
	 * Replace this with some actual testing code.
	 *
	 * @since  0.0.1
	 */
	function test_sample() {
		$this->assertTrue( true );
	}
}
