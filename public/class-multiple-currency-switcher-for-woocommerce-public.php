<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://hashtechy.com/
 * @since      1.0.1
 *
 * @package    Multiple_Currency_Switcher_For_Woocommerce
 * @subpackage Multiple_Currency_Switcher_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Multiple_Currency_Switcher_For_Woocommerce
 * @subpackage Multiple_Currency_Switcher_For_Woocommerce/public
 * @author     Hashtechy <hello@hashtechy.com>
 */
class Multiple_Currency_Switcher_For_Woocommerce_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The option data of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $get_option;

	/**
	 * The option curent data of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $get_current_option;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.1
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name 	= $plugin_name;
		$this->version 		= $version;
		$this->get_option 	= get_option( 'multiple_currency_switcher' );
	}

	public function user_data_update() {

		if( !is_admin() ) {
			
			$current = $this->get_current_option = get_user_meta( get_current_user_id(), 'multiple_currency_switcher_current_price', true );
			if( $current ) {
				update_option( 'woocommerce_currency', $current['currency_decimals'] );
			}
		}
		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Multiple_Currency_Switcher_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Multiple_Currency_Switcher_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/multiple-currency-switcher-for-woocommerce-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Multiple_Currency_Switcher_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Multiple_Currency_Switcher_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/multiple-currency-switcher-for-woocommerce-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'multiple_currency_switcher_object', array( 
			'ajax_url' => admin_url( 'admin-ajax.php' ) 
		) );
	}
		
	// ajax function
	public function multiple_currency_switcher_data() {

		$current_country 	= sanitize_text_field ( $_POST['currentCountry'] );
		$currency_price 	= $this->get_option['_current_currency_rate'][$current_country];

		// $currency_price = $this->multiple_currency_price_update_api( $current_country );				
		$currency_price_currency_decimals = array(
			'currency_price' 	=>  $currency_price,
			'currency_decimals' => 	$current_country,
		);

		// set curent currency
		update_option( 'woocommerce_currency', $current_country );
		
		// update currency price
		update_user_meta( get_current_user_id(), 'multiple_currency_switcher_current_price', $currency_price_currency_decimals );

		// return data to ajax
		wp_send_json_success( $currency_price );
		wp_die();
	}

	// main switcher data add
	public function multiple_currency_switcher_shop_data() { 
		
		$main_title_color 						= isset( $this->get_option['_main_title_color'] ) 							? $this->get_option['_main_title_color'] : '';
		$main_title 							= isset( $this->get_option['_main_title'] ) 								? $this->get_option['_main_title'] : '';
		$main_color 							= isset( $this->get_option['_main_color'] ) 								? $this->get_option['_main_color'] : '';
		$main_background_color 					= isset( $this->get_option['_main_background_color'] ) 						? $this->get_option['_main_background_color'] : '';
		$main_current_currency_background_color = isset( $this->get_option['_main_current_currency_background_color'] ) 	? $this->get_option['_main_current_currency_background_color'] : '';
		$currency_position 						= isset( $this->get_option['_enable_currency_position'] ) 					? $this->get_option['_enable_currency_position'] : '';
		
		if( $currency_position === '_position_left' ) {

			$currency_position_class	= 'position_left';
		} else{
			$currency_position_class 	= 'position_right';
		} ?>
		
		<div class="sidebar_toggle position_cmn <?php echo $currency_position_class; ?>">
			<div class="sidebar_wrapper">
				<strong style="color:<?php echo esc_attr( $main_title_color ); ?>" ><?php echo esc_attr(  $main_title ); ?></strong>
				
				<?php 
					$currency_code_options = get_woocommerce_currencies();
					$woocommerce_currency = get_option( 'woocommerce_currency' );

					foreach( $this->get_option['_default_country_selected'] as $key => $value ) {
						
						$currency_position_selected = isset( $value ) && $woocommerce_currency == $value ? $main_current_currency_background_color : $main_background_color ;
						?>
							<p class="multiple-currency-switcher-sidebar" style="color:<?php echo esc_attr( $main_color ); ?>;  background-color:<?php echo esc_attr( $currency_position_selected ); ?>" data-id='<?php echo esc_attr( $value ); ?>'><span class="wmc-currency-symbol"><?php echo esc_attr( $value ); ?></span><?php echo esc_attr( $currency_code_options[$value] ); ?></p>
						<?php
					}
				?>
			</div>
		</div>

		<?php
	}


	// set currency price
	public function get_price_multiplier() {
		
		$currency_price = isset( $this->get_current_option['currency_price'] ) ? $this->get_current_option['currency_price'] : '';
		
		if( $currency_price && !is_admin()) {
			return $currency_price;
		}else{
			return 1;
		}; 
	}
	
	// Simple, grouped and external products
	public function multiple_currency_custom_price( $price, $product ) {
		
		if( !is_admin() ) {
			return (float) $price * $this->get_price_multiplier();
		} else{
			return (float) $price;
		}
	}
	
	// Variable (price range)
	public function multiple_currency_variable_price( $price, $variation, $product ) {
		
		if( !is_admin() ) {
			return (float) $price * $this->get_price_multiplier();
		} else{
			return (float) $price;
		}
	}

	// Handling price caching (see explanations at the end)
	public function add_price_multiplier_to_variation_prices_hash( $price_hash, $product, $for_display ) {
		
		if( !is_admin() ) {
			$price_hash[] = $this->get_price_multiplier();
		} 
		return $price_hash;
	}

	// price number of decimals
	public function multiple_currency_custom_price_decimals( $decimals ){
		
		global $product;
		$currency_decimals = isset( $this->get_current_option['currency_decimals'] ) ? $this->get_current_option['currency_decimals'] : '';
		
		if( $currency_decimals && !is_admin() ) {

			return isset( $this->get_option['_current_currency_number_decimals'][$currency_decimals] ) ? $this->get_option['_current_currency_number_decimals'][$currency_decimals] : '';
		}else{
			return 2;
		}
	}
	
	// change currency price symbol position 
	public function multiple_currency_currency_position(){

		$currency_decimals = isset( $this->get_current_option['currency_decimals'] ) ? $this->get_current_option['currency_decimals'] : '';
		
		if( $currency_decimals && !is_admin() ) {

			return isset( $this->get_option['_currency_position_set'][$currency_decimals] ) ? $this->get_option['_currency_position_set'][$currency_decimals] : '';
		}else{
			return 'right';
		}
	}

}
