<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/pdutie94
 * @since             1.0.0
 * @package           Tp_Wps
 *
 * @wordpress-plugin
 * Plugin Name:       TP WooCommerce Product Slider
 * Plugin URI:        https://github.com/pdutie94/tp-woocommerce-product-slider
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            TienPham
 * Author URI:        https://github.com/pdutie94
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tp-wps
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tp-wps-activator.php
 */
function activate_tp_wps() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tp-wps-activator.php';
	Tp_Wps_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tp-wps-deactivator.php
 */
function deactivate_tp_wps() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tp-wps-deactivator.php';
	Tp_Wps_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tp_wps' );
register_deactivation_hook( __FILE__, 'deactivate_tp_wps' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tp-wps.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tp_wps() {

	$plugin = new Tp_Wps();
	$plugin->run();

}
run_tp_wps();
