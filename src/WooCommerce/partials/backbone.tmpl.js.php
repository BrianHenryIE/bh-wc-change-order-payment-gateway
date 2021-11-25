<?php
/**
 * Almost identical to tmpl-wc-modal-add-products
 *
 * @package brianhenryie/wc-change-order-payment-gateway
 */

?>
<script type="text/template" id="tmpl-bh-wc-change-order-payment-gateway-modal-update-gateway">
	<div class="wc-backbone-modal">
		<div class="wc-backbone-modal-content">
			<section class="wc-backbone-modal-main" role="main" id="bh-wc-change-order-payment-gateway-modal-update-gateway-main">
				<header class="wc-backbone-modal-header">
					<h1><?php esc_html_e( 'Update payment gateway', 'bh-wc-change-order-payment-gateway' ); ?></h1>
					<button class="modal-close modal-close-link dashicons dashicons-no-alt">
						<span class="screen-reader-text"><?php esc_html_e( 'Close modal panel', 'bh-wc-change-order-payment-gateway' ); ?></span>
					</button>
				</header>
				<article>
					<form action="" method="post">
						<?php wp_nonce_field( 'bh_wc_order_update_payment_gateway_727', '_wpnonce_bh_wc_order_update_payment_gateway' ); ?>
						<div class="bh-wc-change-order-payment-gateway-modal-gateway-selector">
							<p><?php esc_html_e( 'Choose the payment gateway you wish to set for this order.', 'bh-wc-change-order-payment-gateway' ); ?></p>

							<select name="update_gateway_id">
								<?php
								/**
								 * Each installed payment gateway instance.
								 *
								 * @var WC_Payment_Gateway $gateway
								 */
								foreach ( WC()->payment_gateways()->payment_gateways() as $gateway ) {
									echo '<option data-description="' . esc_attr( wp_kses_post( wpautop( $gateway->get_method_description() ) ) ) . '" value="' . esc_attr( $gateway->id ) . '">' . esc_html( $gateway->get_method_title() ) . '</li>';
								}
								?>
							</select>
							<input type="hidden" name="gateway_id" value="{{{ data.gateway_id }}}"/>
						</div>
					</form>
				</article>
				<footer>
					<div class="inner">
						<button id="btn-ok" class="button button-primary button-large">
							<?php esc_html_e( 'Update payment gateway', 'bh-wc-change-order-payment-gateway' ); ?>
						</button>
					</div>
				</footer>
			</section>
		</div>
	</div>
	<div class="wc-backbone-modal-backdrop modal-close"></div>
</script>
