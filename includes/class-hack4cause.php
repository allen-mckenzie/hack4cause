<?php
/**
 * Hack4cause Hack4cause.
 *
 * @since   0.0.1
 * @package Hack4cause
 */

/**
 * Hack4cause Hack4cause class.
 *
 * @since 0.0.1
 */
class H4_Hack4cause {
	/**
	 * Parent plugin class.
	 *
	 * @var    Hack4cause
	 * @since  0.0.1
	 */
	protected $plugin = null;

	/**
	 * Option key, and option page slug.
	 *
	 * @var    string
	 * @since  0.0.1
	 */
	protected static $key = 'hack4cause_hack4cause';

	/**
	 * Options page metabox ID.
	 *
	 * @var    string
	 * @since  0.0.1
	 */
	protected static $metabox_id = 'hack4cause_hack4cause_metabox';

	/**
	 * Options Page title.
	 *
	 * @var    string
	 * @since  0.0.1
	 */
	protected $title = '';

	/**
	 * Options Page hook.
	 *
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor.
	 *
	 * @since  0.0.1
	 *
	 * @param  Hack4cause $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();

		// Set our title.
		$this->title = esc_attr__( 'Hack4cause', 'hack4cause' );
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  0.0.1
	 */
	public function hooks() {

		// Hook in our actions to the admin.
		add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );
	}

	/**
	 * Add custom fields to the options page.
	 *
	 * @since  0.0.1
	 */
	public function add_options_page_metabox() {

		// Add our CMB2 metabox.
		$cmb = new_cmb2_box( array(
			'id'           => self::$metabox_id,
			'title'        => $this->title,
			'object_types' => array( 'options-page' ),

			/*
			 * The following parameters are specific to the options-page box
			 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
			 */

			'option_key'   => self::$key, // The option key and admin menu page slug.
			// 'icon_url'        => 'dashicons-palmtree', // Menu icon. Only applicable if 'parent_slug' is left empty.
			// 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
			// 'parent_slug'     => 'themes.php', // Make options page a submenu item of the themes menu.
			// 'capability'      => 'manage_options', // Cap required to view options-page.
			// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
			// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
			// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
			// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
		) );

		// Add your fields here.
		$cmb->add_field( array(
			'name'    => __( 'Test Text', 'hack4cause' ),
			'desc'    => __( 'field description (optional)', 'hack4cause' ),
			'id'      => 'test_text', // No prefix needed.
			'type'    => 'text',
			'default' => __( 'Default Text', 'hack4cause' ),
		) );

	}

	/**
	 * Wrapper function around cmb2_get_option.
	 *
	 * @since  0.0.1
	 *
	 * @param  string $key     Options array key.
	 * @param  mixed  $default Optional default value.
	 * @return mixed           Option value
	 */
	public static function get_value( $key = '', $default = false ) {
		if ( function_exists( 'cmb2_get_option' ) ) {

			// Use cmb2_get_option as it passes through some key filters.
			return cmb2_get_option( self::$key, $key, $default );
		}

		// Fallback to get_option if CMB2 is not loaded yet.
		$opts = get_option( self::$key, $default );

		$val = $default;

		if ( 'all' == $key ) {
			$val = $opts;
		} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
			$val = $opts[ $key ];
		}

		return $val;
	}
}
