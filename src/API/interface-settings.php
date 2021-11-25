<?php
/**
 * Defines the settings the plugin needs.
 *
 * @package brianhenryie/wc-change-order-payment-gateway
 */

namespace BrianHenryIE\WC_Change_Order_Payment_Gateway\API;

use BrianHenryIE\WC_Change_Order_Payment_Gateway\WooCommerce\Admin_Order_UI;

interface Settings_Interface {

	/**
	 * The plugin's version in Semver format.
	 *
	 * @used-by Admin_Order_UI::enqueue_scripts()
	 * @used-by Admin_Order_UI::enqueue_styles()
	 *
	 * @return string
	 */
	public function get_plugin_version():string;
}
