<?php
/**
 * Plugin Name: hack4cause
 * Plugin URI:  https://mcnichols.design
 * Description: A new plugin to solve a challenge for our local community @ hack4acause
 * Version:     0.0.1
 * Author:      Team Dumpster Fire
 * Author URI:  https://mcnichols.design
 * Donate link: https://mcnichols.design
 * License:     GPLv2
 * Text Domain: hack4cause
 * Domain Path: /languages
 *
 * @link    https://mcnichols.design
 *
 * @package Hack4cause
 * @version 0.0.1
 *
 * Built using generator-plugin-wp (https://github.com/WebDevStudios/generator-plugin-wp)
 */

/**
 * Copyright (c) 2019 Team Dumpster Fire (email : allen@mcnichols.design)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


// Include additional php files here.
// require 'includes/something.php';

/**
 * Main initiation class.
 *
 * @since  0.0.1
 */
final class Hack4cause {

	/**
	 * Current version.
	 *
	 * @var    string
	 * @since  0.0.1
	 */
	const VERSION = '0.0.1';

	/**
	 * URL of plugin directory.
	 *
	 * @var    string
	 * @since  0.0.1
	 */
	protected $url = '';

	/**
	 * Path of plugin directory.
	 *
	 * @var    string
	 * @since  0.0.1
	 */
	protected $path = '';

	/**
	 * Plugin basename.
	 *
	 * @var    string
	 * @since  0.0.1
	 */
	protected $basename = '';

	/**
	 * Detailed activation error messages.
	 *
	 * @var    array
	 * @since  0.0.1
	 */
	protected $activation_errors = array();

	/**
	 * Singleton instance of plugin.
	 *
	 * @var    Hack4cause
	 * @since  0.0.1
	 */
	protected static $single_instance = null;

	/**
	 * Instance of H4_Hack4cause_Menu
	 *
	 * @since0.0.1
	 * @var H4_Hack4cause_Menu
	 */
	protected $hack4cause_menu;

	/**
	 * Instance of H4_Hack4cause_Methods
	 *
	 * @since0.0.1
	 * @var H4_Hack4cause_Methods
	 */
	protected $hack4cause_methods;

	/**
	 * Instance of H4_Hack4cause
	 *
	 * @since0.0.1
	 * @var H4_Hack4cause
	 */
	protected $hack4cause;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since   0.0.1
	 * @return  Hack4cause A single instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * Sets up our plugin.
	 *
	 * @since  0.0.1
	 */
	protected function __construct() {
		$this->basename = plugin_basename( __FILE__ );
		$this->url      = plugin_dir_url( __FILE__ );
		$this->path     = plugin_dir_path( __FILE__ );
	}

	/**
	 * Attach other plugin classes to the base plugin class.
	 *
	 * @since  0.0.1
	 */
	public function plugin_classes() {

		$this->hack4cause_menu = new H4_Hack4cause_Menu( $this );
		$this->hack4cause_methods = new H4_Hack4cause_Methods( $this );
		$this->hack4cause = new H4_Hack4cause( $this );
	} // END OF PLUGIN CLASSES FUNCTION

	/**
	 * Add hooks and filters.
	 * Priority needs to be
	 * < 10 for CPT_Core,
	 * < 5 for Taxonomy_Core,
	 * and 0 for Widgets because widgets_init runs at init priority 1.
	 *
	 * @since  0.0.1
	 */
	public function hooks() {
		add_action( 'init', array( $this, 'init' ), 0 );
	}

	/**
	 * Activate the plugin.
	 *
	 * @since  0.0.1
	 */
	public function _activate() {
		// Bail early if requirements aren't met.
		if ( ! $this->check_requirements() ) {
			return;
		}

		// Make sure any rewrite functionality has been loaded.
		flush_rewrite_rules();
	}

	/**
	 * Deactivate the plugin.
	 * Uninstall routines should be in uninstall.php.
	 *
	 * @since  0.0.1
	 */
	public function _deactivate() {
		// Add deactivation cleanup functionality here.
	}

	/**
	 * Init hooks
	 *
	 * @since  0.0.1
	 */
	public function init() {

		// Bail early if requirements aren't met.
		if ( ! $this->check_requirements() ) {
			return;
		}

		// Load translated strings for plugin.
		load_plugin_textdomain( 'hack4cause', false, dirname( $this->basename ) . '/languages/' );
		wp_register_style( 'hack4causeStylesheet', plugins_url( 'style.css', __FILE__ ) );
		wp_enqueue_style( 'hack4causeStylesheet' );
		include 'includes/class-hack4cause-menu.php';
		include 'includes/class-hack4cause.php';
		include 'includes/class-hack4cause-methods.php';
		// Initialize plugin classes.
		$this->plugin_classes();
	}

	/**
	 * Check if the plugin meets requirements and
	 * disable it if they are not present.
	 *
	 * @since  0.0.1
	 *
	 * @return boolean True if requirements met, false if not.
	 */
	public function check_requirements() {

		// Bail early if plugin meets requirements.
		if ( $this->meets_requirements() ) {
			return true;
		}

		// Add a dashboard notice.
		add_action( 'all_admin_notices', array( $this, 'requirements_not_met_notice' ) );

		// Deactivate our plugin.
		add_action( 'admin_init', array( $this, 'deactivate_me' ) );

		// Didn't meet the requirements.
		return false;
	}

	/**
	 * Deactivates this plugin, hook this function on admin_init.
	 *
	 * @since  0.0.1
	 */
	public function deactivate_me() {

		// We do a check for deactivate_plugins before calling it, to protect
		// any developers from accidentally calling it too early and breaking things.
		if ( function_exists( 'deactivate_plugins' ) ) {
			deactivate_plugins( $this->basename );
		}
	}

	/**
	 * Check that all plugin requirements are met.
	 *
	 * @since  0.0.1
	 *
	 * @return boolean True if requirements are met.
	 */
	public function meets_requirements() {

		// Do checks for required classes / functions or similar.
		// Add detailed messages to $this->activation_errors array.
		return true;
	}

	/**
	 * Adds a notice to the dashboard if the plugin requirements are not met.
	 *
	 * @since  0.0.1
	 */
	public function requirements_not_met_notice() {

		// Compile default message.
		$default_message = sprintf( __( 'hack4cause is missing requirements and has been <a href="%s">deactivated</a>. Please make sure all requirements are available.', 'hack4cause' ), admin_url( 'plugins.php' ) );

		// Default details to null.
		$details = null;

		// Add details if any exist.
		if ( $this->activation_errors && is_array( $this->activation_errors ) ) {
			$details = '<small>' . implode( '</small><br /><small>', $this->activation_errors ) . '</small>';
		}

		// Output errors.
		?>
		<div id="message" class="error">
			<p><?php echo wp_kses_post( $default_message ); ?></p>
			<?php echo wp_kses_post( $details ); ?>
		</div>
		<?php
	}

	/**
	 * Magic getter for our object.
	 *
	 * @since  0.0.1
	 *
	 * @param  string $field Field to get.
	 * @throws Exception     Throws an exception if the field is invalid.
	 * @return mixed         Value of the field.
	 */
	public function __get( $field ) {
		switch ( $field ) {
			case 'version':
				return self::VERSION;
			case 'basename':
			case 'url':
			case 'path':
			case 'hack4cause_menu':
			case 'hack4cause_methods':
			case 'hack4cause':
				return $this->$field;
			default:
				throw new Exception( 'Invalid ' . __CLASS__ . ' property: ' . $field );
		}
	}
}

/**
 * Grab the Hack4cause object and return it.
 * Wrapper for Hack4cause::get_instance().
 *
 * @since  0.0.1
 * @return Hack4cause  Singleton instance of plugin class.
 */
function hack4cause() {
	return Hack4cause::get_instance();
}

// Kick it off.
add_action( 'plugins_loaded', array( hack4cause(), 'hooks' ) );
// Activation and deactivation.
register_activation_hook( __FILE__, array( hack4cause(), '_activate' ) );
register_deactivation_hook( __FILE__, array( hack4cause(), '_deactivate' ) );
