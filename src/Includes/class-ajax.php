<?php
/**
 * AJAX UI: catch, validate, and pass the AJAX requests.
 *
 * @see https://developer.wordpress.org/plugins/javascript/ajax/
 *
 * @package brianhenryie/wc-change-order-payment-gateway
 */

namespace BrianHenryIE\WC_Change_Order_Payment_Gateway\Includes;

use BrianHenryIE\WC_Change_Order_Payment_Gateway\API\API_Interface;
use Exception;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

/**
 * Handles the AJAX request: valudates input, passes data to the API class, returns success or failure to the web client.
 */
class AJAX {

	use LoggerAwareTrait;

	/**
	 * The class that handles the heavy lifting. This AJAX class is just a UI.
	 *
	 * @var API_Interface
	 */
	protected API_Interface $api;

	/**
	 * Constructor. No logic.
	 *
	 * @param API_Interface   $api Access to the plugin's main functions.
	 * @param LoggerInterface $logger A PSR logger.
	 */
	public function __construct( API_Interface $api, LoggerInterface $logger ) {
		$this->setLogger( $logger );
		$this->api = $api;
	}

	/**
	 * Outputs JSON response (i.e. not void).
	 */
	public function order_update_payment_gateway(): void {

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'bh_wc_order_update_payment_gateway_727' ) ) {
			wp_send_json_error();
		}

		if ( ! isset( $_POST['data'] )
			|| ! isset( $_POST['data']['order_id'] )
			|| ! isset( $_POST['data']['new_gateway_id'] )
		) {
			wp_send_json_error();
		}

		// TODO: Check current user capabilities.

		$order_id               = intval( $_POST['data']['order_id'] );
		$new_payment_gateway_id = sanitize_title( wp_unslash( $_POST['data']['new_gateway_id'] ) );

		try {
			$result = $this->api->update_order_payment_gateway( $order_id, $new_payment_gateway_id );
			if ( $result ) {
				wp_send_json( array( 'success' => true ) );
			} else {
				wp_send_json_error( array( 'error' => 'Failed to update the order\'s payment gateway.' ) );
			}
		} catch ( Exception $e ) {
			wp_send_json_error( array( 'error' => $e->getMessage() ) );
		}
	}

}
