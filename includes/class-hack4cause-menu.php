<?php
/**
 * hack4cause Hack4cause Menu.
 *
 * @since   0.0.1
 * @package Hack4cause
 */



/**
 * hack4cause Hack4cause Menu post type class.
 *
 * @since 0.0.1
 *
 * @see   https://github.com/WebDevStudios/CPT_Core
 */

include(plugin_dir_path( __FILE__ ).'../vendor/webdevstudios/cpt-core/CPT_Core.php');

class H4_Hack4cause_Menu extends CPT_Core {
	/**
	 * Parent plugin class.
	 *
	 * @var Hack4cause
	 * @since  0.0.1
	 */
	protected $plugin = null;
	/**
	 * Constructor.
	 *
	 * Register Custom Post Types.
	 *
	 * See documentation in CPT_Core, and in wp-includes/post.php.
	 *
	 * @since  0.0.1
	 *
	 * @param  Hack4cause $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();

		// Register this cpt.
		// First parameter should be an array with Singular, Plural, and Registered name.
		parent::__construct(
			array(
				esc_html__( 'Hack4cause', 'hack4cause' ),
				esc_html__( 'Hack4cause', 'hack4cause' ),
				'h4-hack4cause-menu',
			),
			array(
				'supports' => array(
					'title',
					'editor',
					'excerpt',
					'thumbnail',
				),
				'menu_icon' => 'dashicons-heart', // https://developer.wordpress.org/resource/dashicons/
				'public'    => true,
			)
		);
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  0.0.1
	 */
	public function hooks() {
	}

	/**
	 * Registers admin columns to display. Hooked in via CPT_Core.
	 *
	 * @since  0.0.1
	 *
	 * @param  array $columns Array of registered column names/labels.
	 * @return array          Modified array.
	 */
	public function columns( $columns ) {
		$new_column = array();
		return array_merge( $new_column, $columns );
	}

	/**
	 * Handles admin column display. Hooked in via CPT_Core.
	 *
	 * @since  0.0.1
	 *
	 * @param array   $column   Column currently being rendered.
	 * @param integer $post_id  ID of post to display column for.
	 */
	public function columns_display( $column, $post_id ) {
		switch ( $column ) {
		}
	}
}
