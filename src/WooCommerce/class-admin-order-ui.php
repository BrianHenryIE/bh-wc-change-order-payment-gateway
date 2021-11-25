<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package brianhenryie/wc-change-order-payment-gateway
 */

namespace BrianHenryIE\WC_Change_Order_Payment_Gateway\WooCommerce;

use BrianHenryIE\WC_Change_Order_Payment_Gateway\API\Settings_Interface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package brianhenryie/wc-change-order-payment-gateway
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */
class Admin_Order_UI {
	use LoggerAwareTrait;

	/**
	 * The plugin version is used for caching the JS and CSS.
	 *
	 * @see Settings_Interface::get_plugin_version()
	 *
	 * @var Settings_Interface
	 */
	protected Settings_Interface $settings;


	/**
	 * Constructor.
	 *
	 * @param Settings_Interface $settings The plugin's settings.
	 * @param LoggerInterface    $logger A PSR logger.
	 */
	public function __construct( Settings_Interface $settings, LoggerInterface $logger ) {
		$this->setLogger( $logger );
		$this->settings = $settings;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @hooked admin_enqueue_scripts
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles(): void {

		// TODO: check we are on a single order edit page.

		$version = $this->settings->get_plugin_version();

		wp_enqueue_style( 'bh-wc-change-order-payment-gateway', plugin_dir_url( __FILE__ ) . 'css/bh-wc-change-order-payment-gateway-admin.css', array(), $version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @hooked admin_enqueue_scripts
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts(): void {

		// TODO: check we are on a single order edit page.

		$version = $this->settings->get_plugin_version();

		$handle = 'bh-wc-change-order-payment-gateway';
		wp_enqueue_script( $handle, plugin_dir_url( __FILE__ ) . 'js/bh-wc-change-order-payment-gateway-admin.js', array( 'jquery' ), $version, true );

		// The following (if done correctly) would set the script type as text/javascript... does that matter?
		ob_start();
		include dirname( __FILE__, 2 ) . '/WooCommerce/partials/backbone.tmpl.js.php';
		$script = ob_get_flush();

		if ( false === $script ) {
			$this->logger->error( 'ob_get_flush was empty' );
			return;
		}

		wp_add_inline_script(
			$handle,
			$script,
			'before'
		);
	}

}
