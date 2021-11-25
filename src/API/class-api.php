<?php
/**
 * The server-side logic of the plugin: change the payment gateway for a given order.
 *
 * @package brianhenryie/wc-change-order-payment-gateway
 */

namespace BrianHenryIE\WC_Change_Order_Payment_Gateway\API;

use Exception;
use WC_Payment_Gateway;

/**
 * Fetches the order, fetches the payment gateways, validates the input, updates the order's payment gateway.
 */
class API implements API_Interface {

	/**
	 * Simple method to update the gateway of an order.
	 * Adds a note to the order.
	 *
	 * @used-by AJAX::order_update_payment_gateway()
	 *
	 * @param int    $order_id The WooCommerce order id we should update.
	 * @param string $new_gateway_id The id of the gateway the order should have.
	 * @throws Exception When updating the order's payment gateway is not possible.
	 * @return bool true if successful.
	 */
	public function update_order_payment_gateway( int $order_id, string $new_gateway_id ): bool {

		$order = wc_get_order( $order_id );

		if ( ! ( $order instanceof \WC_Order ) ) {
			$message = "Provided order id failed to return a valid order object: {$order_id}";
			throw new Exception( $message );
		}

		$all_gateways = WC()->payment_gateways()->payment_gateways();

		if ( ! isset( $all_gateways[ $new_gateway_id ] ) ) {
			$message = "Expected gateway is not a registered gateway: {$new_gateway_id}";
			throw new Exception( $message );
		}

		$existing_gateway_id = $order->get_payment_method();
		/**
		 *The instance of the currently set payment gateway.
		 *
		 * @var WC_Payment_Gateway $existing_gateway
		 */
		$existing_gateway      = $all_gateways[ $existing_gateway_id ];
		$existing_gateway_name = $existing_gateway->get_method_title();

		/**
		 *  The instance of the payment gateway we wish to set.
		 *
		 * @var WC_Payment_Gateway $new_gateway
		 */
		$new_gateway      = $all_gateways[ $new_gateway_id ];
		$new_gateway_name = $new_gateway->get_method_title();

		if ( $existing_gateway === $new_gateway ) {
			$message = "New gateway is the same as the old gateway: {$new_gateway_id}";
			throw new Exception( $message );
		}

		$order->set_payment_method( $new_gateway_id );

		$note = "Payment gateway changed from <i>{$existing_gateway_name}</i> to <i>{$new_gateway_name}</i>.";

		$order->add_order_note( $note, 0, true );
		$order->save();

		return true;
	}
}
