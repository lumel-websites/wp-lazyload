<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/kgkrishnalmt
 * @since             1.0.0
 * @package           Wp_Lazyload
 *
 * @wordpress-plugin
 * Plugin Name:       WP Lazyload
 * Plugin URI:        https://github.com/lumel-websites/wp-lazyload
 * Description:       Easily embed videos and iframes with lazy loading for faster performance. Supports YouTube, Vimeo, Wistia, and GIFs, offering inline playback or popup modes. Fully responsive and user-friendly.

 * Version:           1.0.0
 * Author:            K Gopal Krishna
 * Author URI:        https://github.com/kgkrishnalmt/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-lazyload
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_LAZYLOAD_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-lazyload-activator.php
 */
function activate_wp_lazyload() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-lazyload-activator.php';
	Wp_Lazyload_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-lazyload-deactivator.php
 */
function deactivate_wp_lazyload() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-lazyload-deactivator.php';
	Wp_Lazyload_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_lazyload' );
register_deactivation_hook( __FILE__, 'deactivate_wp_lazyload' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-lazyload.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_lazyload() {

	$plugin = new Wp_Lazyload();
	$plugin->run();

}
run_wp_lazyload();
