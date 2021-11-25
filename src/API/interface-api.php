<?php
/**
 * Defines the main method[s] of the plugin.
 *
 * @package brianhenryie/wc-change-order-payment-gateway
 */

namespace BrianHenryIE\WC_Change_Order_Payment_Gateway\API;

/**
 * Given an order id and a payment gateway id, update the order.
 */
interface API_Interface {

	/**
	 * The main function of the plugin: given an order id, change its payment method.
	 *
	 * @used-by AJAX::order_update_payment_gateway()
	 *
	 * @param int    $order_id The id of the order to update.
	 * @param string $new_gateway_id The id of the gateway the order should have.
	 *
	 * @return bool Was the order updated?
	 */
	public function update_order_payment_gateway( int $order_id, string $new_gateway_id ): bool;

}
