<?php
/**
 * Plain old objcet for settings: the plugin version (for caching assets) and settings for logging.
 *
 * @package brianhenryie/wc-change-order-payment-gateway
 */

namespace BrianHenryIE\WC_Change_Order_Payment_Gateway\API;

use BrianHenryIE\WC_Change_Order_Payment_Gateway\BrianHenryIE\WP_Logger\API\Logger_Settings_Interface;
use BrianHenryIE\WC_Change_Order_Payment_Gateway\BrianHenryIE\WP_Logger\WooCommerce\WooCommerce_Logger_Interface;
use Psr\Log\LogLevel;

/**
 * Reads from `define`d constants where available, returns presumably the same value anyway.
 */
class Settings implements Settings_Interface, Logger_Settings_Interface, WooCommerce_Logger_Interface {

	/**
	 * The current plugin version.
	 *
	 * @see Settings_Interface::get_plugin_version()
	 *
	 * @return string
	 */
	public function get_plugin_version(): string {
		return defined( 'BH_WC_CHANGE_ORDER_PAYMENT_GATEWAY_VERSION' ) ? BH_WC_CHANGE_ORDER_PAYMENT_GATEWAY_VERSION : '1.0.0';
	}

	/**
	 * Minimum log level to record.
	 *
	 * @see Logger_Settings_Interface::get_log_level()
	 *
	 * @return string
	 */
	public function get_log_level(): string {
		return LogLevel::INFO;
	}

	/**
	 * Used by the logger for displaying the plugin name.
	 *
	 * @see Logger_Settings_Interface::get_plugin_name()
	 *
	 * @return string
	 */
	public function get_plugin_name(): string {
		return 'Change Order Payment Gateway';
	}

	/**
	 * Used by the logger for naming files and urls.
	 *
	 * @see Logger_Settings_Interface::get_plugin_slug()
	 * @return string
	 */
	public function get_plugin_slug(): string {
		return 'bh-wc-change-order-payment-gateway';
	}

	/**
	 * Used by the logger to match error messages' sources to this plugin.
	 *
	 * @see Logger_Settings_Interface::get_plugin_basename()
	 *
	 * @return string
	 */
	public function get_plugin_basename(): string {
		return 'bh-wc-change-order-payment-gateway/bh-wc-change-order-payment-gateway.php';
	}

}
