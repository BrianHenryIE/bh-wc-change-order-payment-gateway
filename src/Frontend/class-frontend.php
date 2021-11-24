<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    BH_WC_Change_Order_Payment_Gateway
 * @subpackage BH_WC_Change_Order_Payment_Gateway/frontend
 */

namespace BrianHenryIE\WC_Change_Order_Payment_Gateway\Frontend;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the frontend-facing stylesheet and JavaScript.
 *
 * @package    BH_WC_Change_Order_Payment_Gateway
 * @subpackage BH_WC_Change_Order_Payment_Gateway/frontend
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */
class Frontend {

	/**
	 * Register the stylesheets for the frontend-facing side of the site.
	 *
	 * @hooked wp_enqueue_scripts
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles(): void {
		$version = defined( 'BH_WC_CHANGE_ORDER_PAYMENT_GATEWAY_VERSION' ) ? BH_WC_CHANGE_ORDER_PAYMENT_GATEWAY_VERSION : time();

		wp_enqueue_style( 'bh-wc-change-order-payment-gateway', plugin_dir_url( __FILE__ ) . 'css/bh-wc-change-order-payment-gateway-frontend.css', array(), $version, 'all' );

	}

	/**
	 * Register the JavaScript for the frontend-facing side of the site.
	 *
	 * @hooked wp_enqueue_scripts
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts(): void {
		$version = defined( 'BH_WC_CHANGE_ORDER_PAYMENT_GATEWAY_VERSION' ) ? BH_WC_CHANGE_ORDER_PAYMENT_GATEWAY_VERSION : time();

		wp_enqueue_script( 'bh-wc-change-order-payment-gateway', plugin_dir_url( __FILE__ ) . 'js/bh-wc-change-order-payment-gateway-frontend.js', array( 'jquery' ), $version, false );

	}

}
