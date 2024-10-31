<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://https://hashtechy.com/
 * @since      1.0.1
 *
 * @package    Multiple_Currency_Switcher_For_Woocommerce
 * @subpackage Multiple_Currency_Switcher_For_Woocommerce/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.1
 * @package    Multiple_Currency_Switcher_For_Woocommerce
 * @subpackage Multiple_Currency_Switcher_For_Woocommerce/includes
 * @author     Hashtechy <hello@hashtechy.com>
 */
class Multiple_Currency_Switcher_For_Woocommerce {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      Multiple_Currency_Switcher_For_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.1
	 */
	public function __construct() {
		if ( defined( 'MULTIPLE_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_VERSION' ) ) {
			$this->version = MULTIPLE_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_VERSION;
		} else {
			$this->version = '1.0.1';
		}
		$this->plugin_name = 'multiple-currency-switcher-for-woocommerce';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Multiple_Currency_Switcher_For_Woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Multiple_Currency_Switcher_For_Woocommerce_i18n. Defines internationalization functionality.
	 * - Multiple_Currency_Switcher_For_Woocommerce_Admin. Defines all hooks for the admin area.
	 * - Multiple_Currency_Switcher_For_Woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.1
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-multiple-currency-switcher-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-multiple-currency-switcher-for-woocommerce-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-multiple-currency-switcher-for-woocommerce-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-multiple-currency-switcher-for-woocommerce-public.php';

		$this->loader = new Multiple_Currency_Switcher_For_Woocommerce_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Multiple_Currency_Switcher_For_Woocommerce_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.1
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Multiple_Currency_Switcher_For_Woocommerce_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Multiple_Currency_Switcher_For_Woocommerce_Admin( $this->get_plugin_name(), $this->get_version() );
		$multiple_currency_switcher = get_option('multiple_currency_switcher');
		
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', 			$plugin_admin, 'multiple_currency_switcher_admin_menu_page' );
		$this->loader->add_filter( 'plugin_action_links_'.MULTIPLE_CURRENCY_SWITCHER_FOR_WOOCOMMERCE_BASENAME, $plugin_admin, 'multiple_currency_switcher_setting_links' );
		$this->loader->add_filter( 'woocommerce_general_settings', $plugin_admin, 'multiple_currency_woocommerce_general_settings' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Multiple_Currency_Switcher_For_Woocommerce_Public( $this->get_plugin_name(), $this->get_version() );
		$multiple_currency_switcher = get_option('multiple_currency_switcher');
		
		if ( isset( $multiple_currency_switcher['_enable_currency'] ) && 'yes' === $multiple_currency_switcher['_enable_currency'] ) { 
			
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
			
			// user data update
			$this->loader->add_action( 'init',  $plugin_public, 'user_data_update' );

			// auto change price ajax filter
			$this->loader->add_action( 'wp_ajax_multiple_currency_switcher_data', 		 $plugin_public, 'multiple_currency_switcher_data' );
			$this->loader->add_action( 'wp_ajax_nopriv_multiple_currency_switcher_data', $plugin_public, 'multiple_currency_switcher_data' );
			
			// Simple, grouped and external products
			$this->loader->add_filter( 'woocommerce_product_get_price', 		$plugin_public, 'multiple_currency_custom_price', 99, 2 );
			$this->loader->add_filter( 'woocommerce_product_get_regular_price', $plugin_public, 'multiple_currency_custom_price', 99, 2 );
			
			// Variations 
			$this->loader->add_filter( 'woocommerce_product_variation_get_regular_price', $plugin_public, 'multiple_currency_custom_price', 99, 2 );
			$this->loader->add_filter( 'woocommerce_product_variation_get_price', 		  $plugin_public, 'multiple_currency_custom_price', 99, 2 );

			// Variable (price range)
			$this->loader->add_filter( 'woocommerce_variation_prices_price', 		 $plugin_public, 'multiple_currency_variable_price', 99, 3 );
			$this->loader->add_filter( 'woocommerce_variation_prices_regular_price', $plugin_public, 'multiple_currency_variable_price', 99, 3 );

			// Handling price caching (see explanations at the end)
			$this->loader->add_filter( 'woocommerce_get_variation_prices_hash', $plugin_public, 'add_price_multiplier_to_variation_prices_hash', 99, 3 );

			// product price decimal number filter
			$this->loader->add_filter( 'wc_get_price_decimals', 				$plugin_public, 'multiple_currency_custom_price_decimals', 10, 1 );

			// product price symbol position filter
			$this->loader->add_filter( 'pre_option_woocommerce_currency_pos', 	$plugin_public, 'multiple_currency_currency_position' );
			
			// shop page filter
			$this->loader->add_action( 'woocommerce_before_shop_loop', 			$plugin_public, 'multiple_currency_switcher_shop_data' );

			// single product page filter
			if ( isset( $multiple_currency_switcher['_enable_single_product_page'] ) && 'yes' === $multiple_currency_switcher['_enable_single_product_page'] ) { 			
				$this->loader->add_action( 'woocommerce_share', $plugin_public, 'multiple_currency_switcher_shop_data' );
			}
			// cart page filter
			if ( isset( $multiple_currency_switcher['_enable_cart_page'] ) && 'yes' === $multiple_currency_switcher['_enable_cart_page'] ) { 			
				$this->loader->add_action( 'woocommerce_before_cart_table', $plugin_public, 'multiple_currency_switcher_shop_data' );
			}
			
			// checkout page filter
			if ( isset( $multiple_currency_switcher['_enable_check_out_page'] ) && 'yes' === $multiple_currency_switcher['_enable_check_out_page'] ) { 
				$this->loader->add_action( 'woocommerce_checkout_before_customer_details', $plugin_public, 'multiple_currency_switcher_shop_data' );
			}
		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.1
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.1
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.1
	 * @return    Multiple_Currency_Switcher_For_Woocommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.1
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
