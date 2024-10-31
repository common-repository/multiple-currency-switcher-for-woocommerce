<?php

/**
 * Fired during plugin activation
 *
 * @link       https://https://hashtechy.com/
 * @since      1.0.1
 *
 * @package    Multiple_Currency_Switcher_For_Woocommerce
 * @subpackage Multiple_Currency_Switcher_For_Woocommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.1
 * @package    Multiple_Currency_Switcher_For_Woocommerce
 * @subpackage Multiple_Currency_Switcher_For_Woocommerce/includes
 * @author     Hashtechy <hello@hashtechy.com>
 */
class Multiple_Currency_Switcher_For_Woocommerce_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.1
	 */
	public static function activate() {

		if ( !class_exists( 'WooCommerce' ) ) {

			$message = sprintf( 
				esc_html__( 'Sorry, but this plugin requires the WooCommerce Parent Plugin to be installed and active. %1$s&raquo; Return to Plugins.%2$s', 'woocommerce_currency' ),
				'<a href="' . admin_url( 'plugins.php' ) . '">',
				'</a>'
			);
			
			wp_die( $message );
		}

		$multiple_currency_switcher = get_option( 'multiple_currency_switcher' );
		
		if ( empty( $multiple_currency_switcher ) ) {
			
			$woocommerce_currency_default = get_option( 'woocommerce_currency' );
			
			$default_options = array(
				'_enable_currency' => 'yes',
				
				'_enable_auto_fixed_price_rate' => 'yes',

				'_enable_currency_position' => '_position_right',

				'_main_title' => 'SELECT YOUR CURRENCY',
				
			

				'_main_title_color' => '#161717',

				'_main_color' => '#faf9fa',

				'_main_background_color' => '#2271b1',

				'_main_current_currency_background_color' => '#dc0909',

				'_default_country_selected' => [
					'0' => $woocommerce_currency_default
				],
				'_currency_position_set' => [
					$woocommerce_currency_default => 'left'
				],
				'_current_currency_rate' => [
					$woocommerce_currency_default => '1'
				],
				'_current_currency_exchange_rate' => [
					$woocommerce_currency_default => '1'
				],
				'_current_currency_number_decimals' => [
					$woocommerce_currency_default => '2'
				],

				'_default_currency' => [
					'0' => $woocommerce_currency_default
				],
				'_select_currency_number_decimals_' => [
					$woocommerce_currency_default => '2'
				],
			);

			update_option( 'multiple_currency_switcher', $default_options );
		}
		
	}

}
