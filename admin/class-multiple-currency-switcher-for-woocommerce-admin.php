<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://hashtechy.com/
 * @since      1.0.1
 *
 * @package    Multiple_Currency_Switcher_For_Woocommerce
 * @subpackage Multiple_Currency_Switcher_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Multiple_Currency_Switcher_For_Woocommerce
 * @subpackage Multiple_Currency_Switcher_For_Woocommerce/admin
 * @author     Hashtechy <hello@hashtechy.com>
 */
?>
<?php
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/multiple-currency-switcher-for-woocommerce-admin-display.php';
class Multiple_Currency_Switcher_For_Woocommerce_Admin extends Multiple_Currency_Switcher_For_Woocommerce_Admin_Display {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.1
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name 	= $plugin_name;
		$this->version 		= $version;
		
		register_setting( 'multiple_currency_switcher_settings', 'multiple_currency_switcher' );
		$multiple_currency_switcher = get_option( 'multiple_currency_switcher' );

		if( !empty( $multiple_currency_switcher['_default_currency'] ) ) {
			update_option( 'woocommerce_currency', $multiple_currency_switcher['_default_currency'][0] );
		}
	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/multiple-currency-switcher-for-woocommerce-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'select2-min', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/multiple-currency-switcher-for-woocommerce-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'select2-min', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, false );
		
		$currency_position_option_array = $currency_code_options_array = array();
		$enable_auto_fixed_price_rate 	= $currency_code_options = '';
		$multiple_currency_switcher 	= get_option( 'multiple_currency_switcher' );

		if ( isset( $multiple_currency_switcher['_enable_auto_fixed_price_rate'] ) && 'yes' === $multiple_currency_switcher['_enable_auto_fixed_price_rate'] ) {
			$enable_auto_fixed_price_rate = $multiple_currency_switcher['_enable_auto_fixed_price_rate'];
		}

		$currency_position_array = [
			"left" 			=> _( 'Left' ),
			"right" 		=> _( 'Right' ),
			"left_space" 	=> _( 'Left with space' ),
			"right_space" 	=> _( 'Right with space' )
		];
		
		foreach( $currency_position_array as $key => $value ) {
			$currency_position_option_array[] = '<option value=' .esc_attr( $key ). ' > '.esc_attr( $value ).' </option>';
		}

		if( function_exists( 'get_woocommerce_currencies' ) ) {
			$currency_code_options = get_woocommerce_currencies();
		}
		
		
		if( $currency_code_options ) {
			foreach ( $currency_code_options as $country_code => $country_name ) {
				$currency_code_options_array[] = '<option value=' . esc_attr( $country_code ) . ' >' . esc_attr( $country_name ) . ' ( ' . get_woocommerce_currency_symbol( $country_code ) . ' )' . '</option>';
			}
		}

		wp_localize_script(
			$this->plugin_name,
			'multiple_currency_admin_data',
			array(
				'currencyPositionOptions' 	=> $currency_position_option_array,
				'currencyCodeOptions' 		=> $currency_code_options_array  ,
				'enableAutoFixedPriceRate' 	=> $enable_auto_fixed_price_rate,
				'defaultCurrencyLabel' 		=> __( 'Default Currency', 'woocommerce-currency' )
			)
		);
	}

	public function multiple_currency_switcher_admin_menu_page()
    {
        add_menu_page(
            __( 'Multiple Currency Switcher', 'multiple-currency-switcher' ),
            __( 'Multiple Currency Switcher', 'multiple-currency-switcher' ),
            'manage_options',
            'multiple-currency-switcher',
            array( $this, 'multiple_currency_switcher_admin' ),
            'dashicons-shield'
        );
    }

	
	/**
	 * Remove currency, decimal, position, setting in backend
	*/
	public function multiple_currency_woocommerce_general_settings( $datas ) {
		
		foreach ( $datas as $k => $data ) {
			
			if ( isset( $data['id'] ) ) {
				
				if ( $data['id'] == 'woocommerce_currency' || $data['id'] == 'woocommerce_price_num_decimals' || $data['id'] == 'woocommerce_currency_pos' ) {
					unset( $datas[ $k ] );
				}
				
				if ( $data['id'] == 'pricing_options' ) {
					$datas[ $k ]['desc'] = esc_html__( 'The following options affect how prices are displayed on the frontend.  Multiple Currency Switcher For Woocommerce is Active. Please go to ', 'multiple-currency-switcher' ) . '<a href="' . admin_url( '?page=multiple-currency-switcher' ) . '">' . esc_html__( 'Multiple Currency Switcher Setting Page', 'multiple-currency-switcher' ) . '</a>' ;
				}
			}
		}

		return $datas;
	}

	public function multiple_currency_switcher_setting_links( $actions ) {
    
		$setting_links = array(
            '<a href="' . admin_url('admin.php?page=multiple-currency-switcher') . '">'.__('Settings', 'woocommerce-currency').'</a>',
        );
    
        $actions = array_merge( $actions, $setting_links );
        return $actions;
    }
}
