<?php
/**
 * Plugin Name:       Multiple Currency Switcher for WooCommerce
 * Description:       This is a description of the plugin.
 * Version:           1.0.1
 * Author:            Hashtechy
 * Author URI:        https://hashtechy.com/
 * Text Domain:       multiple-currency-switcher
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MULTIPLE_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_VERSION', '1.0.1' );
define( 'MULTIPLE_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_BASENAME', plugin_basename(__FILE__) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-multiple-currency-switcher-for-woocommerce-activator.php
 */
function activate_multiple_currency_switcher_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-multiple-currency-switcher-for-woocommerce-activator.php';
	Multiple_Currency_Switcher_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-multiple-currency-switcher-for-woocommerce-deactivator.php
 */
function deactivate_multiple_currency_switcher_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-multiple-currency-switcher-for-woocommerce-deactivator.php';
	Multiple_Currency_Switcher_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_multiple_currency_switcher_for_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_multiple_currency_switcher_for_woocommerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-multiple-currency-switcher-for-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.1
 */
function run_multiple_currency_switcher_for_woocommerce() {

	$plugin = new Multiple_Currency_Switcher_For_Woocommerce();
	$plugin->run();

}
run_multiple_currency_switcher_for_woocommerce();
