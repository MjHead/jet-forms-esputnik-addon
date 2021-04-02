<?php
/**
 * Plugin Name: JetFormBuilder eSputnik integration
 * Plugin URI:  https://crocoblock.com/
 * Description: Add eSputnik integration for the JetFoem builder plugin
 * Version:     1.0.0
 * Author:      Crocoblock
 * Author URI:  https://crocoblock.com/
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

add_action( 'plugins_loaded', function() {

	define( 'JF_ESP_VERSION', '1.0.0' );

	define( 'JF_ESP__FILE__', __FILE__ );
	define( 'JF_ESP_PATH', plugin_dir_path( JF_ESP__FILE__ ) );
	define( 'JF_ESP_URL', plugins_url( '/', JF_ESP__FILE__ ) );

	require JF_ESP_PATH . 'includes/plugin.php';

} );
