<?php
/**
 * hack4cause Hack4cause Menu Tests.
 *
 * @since   0.0.1
 * @package Hack4cause
 */
class H4_Hack4cause_Menu_Test extends WP_UnitTestCase {

	/**
	 * Test if our class exists.
	 *
	 * @since  0.0.1
	 */
	function test_class_exists() {
		$this->assertTrue( class_exists( 'H4_Hack4cause_Menu') );
	}

	/**
	 * Test that we can access our class through our helper function.
	 *
	 * @since  0.0.1
	 */
	function test_class_access() {
		$this->assertInstanceOf( 'H4_Hack4cause_Menu', hack4cause()->hack4cause-menu' );
	}

	/**
	 * Test to make sure the CPT now exists.
	 *
	 * @since  0.0.1
	 */
	function test_cpt_exists() {
		$this->assertTrue( post_type_exists( 'h4-hack4cause-menu' ) );
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
