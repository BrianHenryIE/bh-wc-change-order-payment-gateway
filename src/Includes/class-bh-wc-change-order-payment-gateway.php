<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * frontend-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package brianhenryie/wc-change-order-payment-gateway
 */

namespace BrianHenryIE\WC_Change_Order_Payment_Gateway\Includes;

use BrianHenryIE\WC_Change_Order_Payment_Gateway\API\API_Interface;
use BrianHenryIE\WC_Change_Order_Payment_Gateway\API\Settings_Interface;
use BrianHenryIE\WC_Change_Order_Payment_Gateway\WooCommerce\Admin_Order_UI;
use Psr\Log\LoggerInterface;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * frontend-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package brianhenryie/wc-change-order-payment-gateway
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */
class BH_WC_Change_Order_Payment_Gateway {

	/**
	 * PSR logger for the plugin.
	 *
	 * @var LoggerInterface
	 */
	protected LoggerInterface $logger;

	/**
	 * The plugin's settings. (just the version so far).
	 *
	 * @var Settings_Interface
	 */
	protected Settings_Interface $settings;

	/**
	 * The class that will handle the main changes the plugin performs.
	 *
	 * @var API_Interface
	 */
	protected API_Interface $api;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the frontend-facing side of the site.
	 *
	 * @since    1.0.0
	 *
	 * @param API_Interface      $api The main functions of the plugin.
	 * @param Settings_Interface $settings The plugin's settings.
	 * @param LoggerInterface    $logger A PSR logger.
	 */
	public function __construct( API_Interface $api, Settings_Interface $settings, LoggerInterface $logger ) {

		$this->logger   = $logger;
		$this->settings = $settings;
		$this->api      = $api;

		$this->set_locale();
		$this->define_woocommerce_admin_order_ui_hooks();
		$this->define_ajax_functions();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	protected function set_locale(): void {

		$plugin_i18n = new I18n();

		add_action( 'init', array( $plugin_i18n, 'load_plugin_textdomain' ) );

	}

	/**
	 * Register the JS and CSS for the admin order page.
	 *
	 * @since    1.0.0
	 */
	protected function define_woocommerce_admin_order_ui_hooks(): void {

		$plugin_admin = new Admin_Order_UI( $this->settings, $this->logger );

		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_scripts' ) );
	}

	/**
	 * Instantiate an AJAX class to listen for AJAX requests and pass to an API class to handle.
	 *
	 * @since    1.0.0
	 */
	protected function define_ajax_functions(): void {

		$ajax = new AJAX( $this->api, $this->logger );

		add_action( 'wp_ajax_bh_wc_order_update_payment_gateway', array( $ajax, 'order_update_payment_gateway' ) );
	}

}
