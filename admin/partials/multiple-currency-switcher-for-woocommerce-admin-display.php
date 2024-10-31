<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://https://hashtechy.com/
 * @since      1.0.1
 *
 * @package    Multiple_Currency_Switcher_For_Woocommerce
 * @subpackage Multiple_Currency_Switcher_For_Woocommerce/admin/partials
 */

class Multiple_Currency_Switcher_For_Woocommerce_Admin_Display
{
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
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name  = $plugin_name;
        $this->version      = $version;
    }

    public function multiple_currency_switcher_admin() {
        
        if ( !class_exists( 'WooCommerce' ) ) {
            $message = sprintf( 
                esc_html__( 'Sorry, but this plugin requires the WooCommerce Parent Plugin to be installed and active. %1$s&raquo; Return to Plugins.%2$s', 'woocommerce_currency' ),
                '<a href="' . admin_url( 'plugins.php' ) . '">',
                '</a>'
            );
            
            wp_die( $message );
        }

        ?>
        <div class="wrap">

            <h1><?php _e( 'Currency Settings Page', 'multiple-currency-switcher' ); ?></h1>

            <div class="multiple-currency-switcher-tabs">

                <?php
                    $current_tab        = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : '';
                    $first_tab_active   = !isset( $_GET['tab'] ) ? 'nav-tab-active' : '';
                ?>

                <nav class="nav-tab-wrapper  woo-nav-tab-wrapper">
                    <a class="nav-link nav-tab <?php echo sanitize_key( $first_tab_active ); ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=multiple-currency-switcher' ) ); ?>">
                        <?php _e( 'Settings', 'multiple-currency-switcher'); ?>
                    </a>
                    <a class="nav-link nav-tab <?php echo 'design-settings' === $current_tab ? 'nav-tab-active' : '' ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=multiple-currency-switcher&tab=design-settings' ) ); ?>">
                        <?php _e( 'Design Settings', 'multiple-currency-switcher' ); ?>
                    </a>
                </nav>
            </div>

            <form method="post" class="multiple-currency-switcher-form" action="options.php">
                <?php
                    settings_fields( 'multiple_currency_switcher_settings' );
                    $multiple_currency_switcher = get_option( 'multiple_currency_switcher' );                    
                    $currency_position_array = [
                        "left"          => _( 'Left' ),
                        "right"         => _( 'Right' ),
                        "left_space"    => _( 'Left with space' ),
                        "right_space"   => _( 'Right with space' )
                    ];
                ?>

                <table <?php echo ('design-settings' === $current_tab) ? 'class="hidden"' : ''; ?> >
                    <tbody>
                       <tr>
                            <td>
                                <label for="multiple-currency-switcher-label"><?php _e( 'Enable WooCommerce Currency', 'multiple-currency-switcher' ); ?></label>
                            </td>
                            <td>
                                <fieldset>                                
                                    <label class="multiple-currency-switcher">
									    <input type="checkbox" class="checkbox" name="multiple_currency_switcher[_enable_currency]" value="yes" <?php echo ( isset( $multiple_currency_switcher['_enable_currency'] ) && 'yes' === esc_attr( $multiple_currency_switcher['_enable_currency'] ) ) ? ' checked="checked"' : ''; ?> />
									    <div class="multiple-currency-slider"></div>
								    </label>
                                </fieldset>
                            </td>	
						</tr>

                        <!-- Page Section  --> 
                        <tr>
                            <td>
                                <label for="multiple-currency-switcher-label"><?php _e( 'Cart Page', 'multiple-currency-switcher' ); ?></label>
                            </td>
                            <td>
                                <fieldset>                                
                                    <label class="multiple-currency-switcher">
									    <input type="checkbox" class="checkbox" name="multiple_currency_switcher[_enable_cart_page]" value="yes"<?php echo ( isset( $multiple_currency_switcher['_enable_cart_page'] ) && 'yes' === esc_attr( $multiple_currency_switcher['_enable_cart_page'] ) ) ? ' checked="checked"' : ''; ?> />
									    <div class="multiple-currency-slider"></div>
								    </label>
                                </fieldset>
                            </td>	
						</tr>

                        <tr>
                            <td>
                                <label for="multiple-currency-switcher-label"><?php _e( 'Check Out Page', 'multiple-currency-switcher' ); ?></label>
                            </td>
                            <td>
                                <fieldset>                                
                                    <label class="multiple-currency-switcher">
									    <input type="checkbox" class="checkbox" name="multiple_currency_switcher[_enable_check_out_page]" value="yes" <?php echo ( isset( $multiple_currency_switcher['_enable_check_out_page'] ) && 'yes' === esc_attr( $multiple_currency_switcher['_enable_check_out_page'] ) ) ? ' checked="checked"' : ''; ?> />
									    <div class="multiple-currency-slider"></div>
								    </label>
                                </fieldset>
                            </td>	
						</tr>

                        <tr>
                            <td>
                                <label for="multiple-currency-switcher-label"><?php _e( 'Single Product Page', 'multiple-currency-switcher' ); ?></label>
                            </td>
                            <td>
                                <fieldset>                                
                                    <label class="multiple-currency-switcher">
									    <input type="checkbox" class="checkbox" name="multiple_currency_switcher[_enable_single_product_page]" value="yes" <?php echo ( isset( $multiple_currency_switcher['_enable_single_product_page'] ) && 'yes' === esc_attr( $multiple_currency_switcher['_enable_single_product_page'] ) ) ? ' checked="checked"' : ''; ?> />
									    <div class="multiple-currency-slider"></div>
								    </label>
                                </fieldset>
                            </td>	
						</tr>
                        
                        <!-- Price Section  -->
                        <tr>
                            <td>
                                <label for="multiple-currency-switcher-label"><?php _e( 'Fixed Price Rate', 'multiple-currency-switcher' ); ?></label>
                            </td>
                            <td>
                                <fieldset>                                
                                    <label class="multiple-currency-switcher">
									    <input type="checkbox" class="checkbox multiple-currency-fixed-price-rate" name="multiple_currency_switcher[_enable_fixed_price_rate]" value="yes" <?php echo ( isset( $multiple_currency_switcher['_enable_fixed_price_rate'] ) && 'yes' === esc_attr( $multiple_currency_switcher['_enable_fixed_price_rate'] ) ) ? ' checked="checked"' : ''; ?> />
									    <div class="multiple-currency-slider"></div>
								    </label>
                                </fieldset>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="multiple-currency-switcher-label"><?php _e( 'Auto Fixed Price Rate', 'multiple-currency-switcher' ); ?></label>
                            </td>
                            <td>
                                <fieldset>                                
                                    <label class="multiple-currency-switcher">
									    <input type="checkbox" class="checkbox multiple-currency-fixed-price-rate" name="multiple_currency_switcher[_enable_auto_fixed_price_rate]" value="yes" <?php echo ( isset( $multiple_currency_switcher['_enable_auto_fixed_price_rate'] ) && 'yes' === esc_attr( $multiple_currency_switcher['_enable_auto_fixed_price_rate'] ) ) ? 'checked="checked"' : ''; ?> />
									    <div class="multiple-currency-slider"></div>
								    </label>
                                </fieldset>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="btn_add_curr_new">
                                    <label for="currency-new-row-add">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 24 24" width="20px" fill="currentcolor"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M18 13h-5v5c0 .55-.45 1-1 1s-1-.45-1-1v-5H6c-.55 0-1-.45-1-1s.45-1 1-1h5V6c0-.55.45-1 1-1s1 .45 1 1v5h5c.55 0 1 .45 1 1s-.45 1-1 1z"/></svg>
                                    </label>
                                    </la>
                                    <input type="button"  id="currency-new-row-add" value="<?php _e( 'Add New Country', 'multiple-currency-switcher' ) ?>">
                                </div>
                            </td>
                        </tr>                            
                    </tbody>
                </table>

                <!-- Currency Table Section-->
                <table <?php echo ( 'design-settings' === $current_tab ) ? 'class="hidden"' : 'class="table "'; ?> >
                    <thead>
                        <tr>
                            <th scope="col" colspan="2"><?php _e( 'Default Currency', 'multiple-currency-switcher' ) ?></th>
                            <th scope="col"><?php _e( 'Currency', 'multiple-currency-switcher' ) ?></th>
                            <th scope="col"><?php _e( 'Position', 'multiple-currency-switcher' ) ?></th>
                            <th scope="col"><?php _e( 'Rate', 'multiple-currency-switcher' ) ?></th>
                            <th scope="col"><?php _e( 'Rate Exchange', 'multiple-currency-switcher' ) ?></th>
                            <th scope="col"><?php _e( 'Number of Decimals', 'multiple-currency-switcher' ) ?></th>
                            <th scope="col"><?php _e( 'Delete', 'multiple-currency-switcher' ) ?></th>
                        </tr>
                    </thead>
                    <tbody class="multiple-currency-switcher-tbody">
                        <?php
                            if ( !empty( $multiple_currency_switcher ) && !empty( $multiple_currency_switcher['_default_country_selected'] ) )
                            {
                        
                                foreach ( $multiple_currency_switcher['_default_country_selected'] as $key => $value ) {  ?>
                                    
                                    <tr>
                                        <td>
                                            <label for="multiple-currency-switcher-label"><?php _e( 'Default Currency', 'multiple-currency-switcher' ); ?></label>
                                        </td>
                                        <td>
                                            <fieldset>                                
                                                <label class="multiple-currency-switcher">
                                                    <input type="checkbox" class="checkbox default-currency" name="multiple_currency_switcher[_default_currency][]" value="<?php echo esc_html( $multiple_currency_switcher['_default_country_selected'][$key] ); ?>" <?php echo ( isset( $multiple_currency_switcher['_default_currency'][0] ) && esc_attr( $multiple_currency_switcher['_default_country_selected'][$key] ) === esc_attr( $multiple_currency_switcher['_default_currency'][0] ) ) ? 'checked="checked"' : ''; ?> >
                                                    <div class="multiple-currency-slider"></div>
                                                </label>
                                            </fieldset>
                                        </td>	

                                        <td>
                                            <fieldset>
                                                <select class="form-select multiple-currency-selected" name="multiple_currency_switcher[_default_country_selected][]" aria-label="Default select example">
                                                    <?php
                                                        $currency_code_options = get_woocommerce_currencies();

                                                        foreach ( $currency_code_options as $country_code => $country_name )
                                                        {
                                                            $country_name_selected = isset( $multiple_currency_switcher['_default_country_selected'][$key] ) && esc_attr( $country_code ) == esc_attr( $multiple_currency_switcher['_default_country_selected'][$key] ) ? 'selected="selected"' : '';
                                                            ?>
                                                                <option value="<?php echo esc_attr( $country_code ) ?>" <?php echo esc_attr( $country_name_selected  ); ?> > <?php echo esc_attr( $country_name ); ?> ( <?php echo get_woocommerce_currency_symbol( $country_code ); ?> ) </option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </fieldset>
                                        </td>
                                        <td>
                                            <fieldset>
                                                <select class="form-select multiple-currency-position-selected" name="multiple_currency_switcher[_currency_position_set][<?php echo esc_attr( $value ); ?>]" aria-label="Default select example">
                                                    <?php
                                                        foreach ( $currency_position_array as $currency_position_key => $currency_position_name )
                                                        {
                                                            $currency_position_selected = isset( $multiple_currency_switcher['_currency_position_set'][$value] ) && esc_attr( $currency_position_key ) == esc_attr( $multiple_currency_switcher['_currency_position_set'][$value] ) ? 'selected="selected"' : '';
                                                            ?>
                                                                <option value="<?php echo esc_attr( $currency_position_key ); ?>" <?php echo esc_attr( $currency_position_selected ); ?> ><?php echo esc_attr( $currency_position_name ); ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </fieldset>
                                        </td>

                                        <td>
                                            <fieldset>
                                                <input type="text" name="multiple_currency_switcher[_current_currency_rate][<?php echo esc_attr( $value ); ?>]" class="form-control current-currency-rate" placeholder="<?php _e( 'Rate', 'multiple-currency-switcher' ) ?>" value="<?php echo isset( $multiple_currency_switcher['_current_currency_rate'][$value] ) ? esc_html( $multiple_currency_switcher['_current_currency_rate'][$value] ) : ''; ?>">
                                            </fieldset>
                                        </td>

                                        <td>
                                            <fieldset>
                                                <input type="text" name="multiple_currency_switcher[_current_currency_exchange_rate][<?php echo esc_attr( $value ); ?>]" class="form-control current-currency-exchange-rate" placeholder="<?php _e( 'Exchange', 'multiple-currency-switcher' ) ?>" value="<?php echo isset( $multiple_currency_switcher['_current_currency_exchange_rate'][$value] ) ? esc_html( $multiple_currency_switcher['_current_currency_exchange_rate'][$value] ) : ''; ?>">
                                            </fieldset>
                                        </td>

                                        <td>
                                            <fieldset>
                                                <input type="text" name="multiple_currency_switcher[_current_currency_number_decimals][<?php echo esc_attr( $value ); ?>]" class="form-control current-currency-number-decimals" placeholder="<?php _e( 'Number of Decimals', 'multiple-currency-switcher' ) ?>" value="<?php echo isset( $multiple_currency_switcher['_main_title_color'] ) ? esc_html( $multiple_currency_switcher['_current_currency_number_decimals'][$value] ) : ''; ?>">
                                            </fieldset>
                                        </td>
                                        <td>
                                            <fieldset class="delete_cry">
                                                <button class='delete-country'><?php _e( 'Delete', 'multiple-currency-switcher' ); ?></button>
                                            </fieldset>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } 
                        ?>
                    </tbody>
                </table>

                <!-- Style Table Section  -->
                <table <?php echo ( 'design-settings' !== $current_tab ) ? 'class="hidden"' : 'class="design_setting"'; ?>>
                    <tbody>
                        <tr>
                            <td class="multiple-currency-radio-ul">
								<ul>
									<li class="multiple-currency-radio-li">
										<input type="radio" class="multiple-currency-radio-button" name="multiple_currency_switcher[_enable_currency_position]" id="woocommerce-currency-style3" value="_position_left" <?php echo ( isset( $multiple_currency_switcher['_enable_currency_position'] ) && "_position_left" === esc_attr( $multiple_currency_switcher['_enable_currency_position'] ) ) ? ' checked="checked"' : ''; ?> />
										<label for="woocommerce-currency-style3" class="multiple-currency-radio-label"><?php _e( 'Position Left', 'multiple-currency-switcher' ) ?></label>
										<div class="multiple-currency-radio-check"></div>
									</li>
									<li class="multiple-currency-radio-li">
										<input type="radio" class="multiple-currency-radio-button" name="multiple_currency_switcher[_enable_currency_position]" id="woocommerce-currency-style4" value="_position_right" <?php echo ( isset( $multiple_currency_switcher['_enable_currency_position'] ) && "_position_right" === esc_attr( $multiple_currency_switcher['_enable_currency_position'] ) ) ? ' checked="checked"' : ''; ?> />
										<label for="woocommerce-currency-style4" class="multiple-currency-radio-label"><?php _e( 'Position Right', 'multiple-currency-switcher' ) ?></label>
										<div class="multiple-currency-radio-check"></div>
									</li>
								</ul>
							</td>
                        </tr>

                        <tr>
							<td>
								<ul>
									<li class="multiple-currency-switcher-input-section">
										<label for="" class="woocommerce-currency-label-input-section"><?php _e( 'Title',  'multiple-currency-switcher' ); ?></label>
										<input type="text" class="multiple-currency-switcher-form-input" name="multiple_currency_switcher[_main_title]" placeholder="<?php _e( 'Please enter your title',  'multiple-currency-switcher' ); ?>" value="<?php echo isset( $multiple_currency_switcher['_main_title'] ) ? esc_html( $multiple_currency_switcher['_main_title'] ) : ''; ?>">
									</li>
								</ul>
							</td>
						</tr>

                        <tr>
							<td width="50%">
								<ul>
									<li class="multiple-currency-switcher-input-section">
										<label for="" class="woocommerce-currency-label-input-section"><?php _e( 'Text Color',  'multiple-currency-switcher' ); ?></label>
										<input type="color" class="multiple-currency-switcher-form-input" name="multiple_currency_switcher[_main_title_color]" value="<?php echo isset( $multiple_currency_switcher['_main_title_color'] ) ? esc_html( $multiple_currency_switcher['_main_title_color'] ) : ''; ?>">
									</li>
								</ul>
							</td>
                            <td width="50%">
								<ul>
									<li class="multiple-currency-switcher-input-section">
										<label for="" class="woocommerce-currency-label-input-section"><?php _e( 'Current Currency Text Color',  'multiple-currency-switcher' ); ?></label>
										<input type="color" class="multiple-currency-switcher-form-input" name="multiple_currency_switcher[_main_color]" value="<?php echo isset( $multiple_currency_switcher['_main_color'] ) ? esc_html( $multiple_currency_switcher['_main_color'] ) : ''; ?>">
									</li>
								</ul>
							</td>
						</tr>

                        <tr>
							<td width="50%">
								<ul>
									<li class="multiple-currency-switcher-input-section">
										<label for="" class="woocommerce-currency-label-input-section"><?php _e( 'Background Color',  'multiple-currency-switcher' ); ?></label>
										<input type="color" class="multiple-currency-switcher-form-input" name="multiple_currency_switcher[_main_background_color]" value="<?php echo isset( $multiple_currency_switcher['_main_background_color'] ) ? esc_html( $multiple_currency_switcher['_main_background_color'] ) : ''; ?>">
									</li>
								</ul>
							</td>
                            <td width="50%">
								<ul>
									<li class="multiple-currency-switcher-input-section">
										<label for="" class="woocommerce-currency-label-input-section"><?php _e( 'Current Currency Background Color',  'multiple-currency-switcher' ); ?></label>
										<input type="color" class="multiple-currency-switcher-form-input" name="multiple_currency_switcher[_main_current_currency_background_color]" value="<?php echo isset( $multiple_currency_switcher['_main_current_currency_background_color'] ) ? esc_html( $multiple_currency_switcher['_main_current_currency_background_color'] ) : ''; ?>">
									</li>
								</ul>
							</td>
						</tr>
                    </tbody>
                </table>

                <?php submit_button( __( 'Save Changes', 'multiple-currency-switcher' ), 'primary large' ); ?>
            </form>
        </div>
        <?php
    }
}
