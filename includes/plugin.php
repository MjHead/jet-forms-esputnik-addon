<?php
namespace JF_ESP;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Main file
 */
class Plugin {

	/**
	 * Instance.
	 *
	 * Holds the plugin instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @var Plugin
	 */
	public static $instance = null;
	/**
	 * Instance.
	 *
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Register autoloader.
	 */
	private function register_autoloader() {
		require JF_ESP_PATH . 'includes/autoloader.php';
		Autoloader::run();
	}

	/**
	 * Initialize plugin parts
	 *
	 * @return void
	 */
	public function init_components() {
		add_filter( 'jet-form-builder/actions/register', array(  ) );
	}

	/**
	 * Plugin constructor.
	 */
	private function __construct() {

		$this->register_autoloader();

		add_action( 'jet-form-builder/actions/register', function( $manager ) {
			$manager->register_action_type( new Form_Action() );
		}, 10 );

		add_action( 'jet-form-builder/editor-assets/before', function() {
			wp_enqueue_script(
				'jf-esp-action',
				JF_ESP_URL . 'assets/js/action.js',
				array(),
				'1.0.0',
				true
			);
		} );

	}

}

Plugin::instance();
