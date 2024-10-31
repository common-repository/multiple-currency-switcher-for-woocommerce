<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://https://hashtechy.com/
 * @since      1.0.1
 *
 * @package    Multiple_Currency_Switcher_For_Woocommerce
 * @subpackage Multiple_Currency_Switcher_For_Woocommerce/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.1
 * @package    Multiple_Currency_Switcher_For_Woocommerce
 * @subpackage Multiple_Currency_Switcher_For_Woocommerce/includes
 * @author     Hashtechy <hello@hashtechy.com>
 */
class Multiple_Currency_Switcher_For_Woocommerce_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.1
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'multiple-currency-switcher-for-woocommerce',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
