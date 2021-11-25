(function( $ ) {
	'use strict';

	// TODO: date: similar meta-boxes....js has a datepicker function to enhance the text inputs.

	/**
	 * copied from: Order Items Panel
	 */
	var bh_wc_meta_boxes_order_payment_gateway = {

		init: function() {
			$( '.woocommerce-order-data__meta' )
				.on( 'click', '.edit_gateway', this.update_gateway );

			$( document.body )
				.on( 'wc_backbone_modal_loaded', this.backbone.init )
				.on( 'wc_backbone_modal_response', this.backbone.response );
		},

		block: function() {
			$( '#bh-wc-change-order-payment-gateway-modal-update-gateway-main' ).block(
				{
					message: null,
					overlayCSS: {
						background: '#fff',
						opacity: 0.6
					}
				}
			);
		},

		unblock: function() {
			$( '#bh-wc-change-order-payment-gateway-modal-update-gateway-main' ).unblock();
		},

		update_gateway: function() {

			$( this ).WCBackboneModal(
				{
					template: 'bh-wc-change-order-payment-gateway-modal-update-gateway'
				}
			);

			return false;
		},

		backbone: {

			init: function( e, target ) {
				if ( 'bh-wc-change-order-payment-gateway-modal-update-gateway' === target ) {
					$( document.body ).trigger( 'wc-enhanced-select-init' );

				}
			},

			// AJAX update?
			response: function( e, target, data ) {

				if ( 'bh-wc-change-order-payment-gateway-modal-update-gateway' === target ) {

					// TODO: compare to previous to save an unnecessary update operation.
					var new_gateway_id = data.update_gateway_id;

					return bh_wc_meta_boxes_order_payment_gateway.backbone.backend_update_payment_gateway( new_gateway_id );
				}
			},

			backend_update_payment_gateway: function( new_gateway_id ) {
				bh_wc_meta_boxes_order_payment_gateway.block();

				var nonce = document.getElementById( '_wpnonce_bh_wc_order_update_payment_gateway' ).value;

				var data = {
					action   : 'bh_wc_order_update_payment_gateway',
					nonce : nonce,
					data     : { 'new_gateway_id': new_gateway_id, 'order_id' : woocommerce_admin_meta_boxes.post_id }
				};

				$.ajax(
					{
						type: 'POST',
						action: 'bh_wc_order_update_payment_gateway',
						url: ajaxurl, // Always defined by WordPress.
						data: data,
						success: function( response ) {
							if ( response.success ) {
								window.location.reload();

								// TODO: AJAX update things:

								// $( '#woocommerce-order-items' ).find( '.inside' ).empty();
								// $( '#woocommerce-order-items' ).find( '.inside' ).append( response.data.html );
								//
								// // Update notes.
								// if ( response.data.notes_html ) {
								// $( 'ul.order_notes' ).empty();
								// $( 'ul.order_notes' ).append( $( response.data.notes_html ).find( 'li' ) );
								// }
								//
								// bh_wc_meta_boxes_order_payment_gateway.reloaded_items();
								// bh_wc_meta_boxes_order_payment_gateway.unblock();
							} else {
								bh_wc_meta_boxes_order_payment_gateway.unblock();
								window.alert( response.data.error );
							}
						},
						dataType: 'json'
					}
				);
			}
		}
	};

	var a       = document.createElement( 'a' );
	a.href      = '#'
	a.innerText = 'Edit'; // TODO: localization.
	a.setAttribute( 'class', 'edit_gateway' );
	var container = document.getElementsByClassName( 'woocommerce-order-data__meta' )[0];
	container.appendChild( a );

	bh_wc_meta_boxes_order_payment_gateway.init();

})( jQuery );
