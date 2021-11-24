<?php
/**
 * Class Plugin_Test. Tests the root plugin setup.
 *
 * @package BH_WC_Change_Order_Payment_Gateway
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Change_Order_Payment_Gateway;

use BrianHenryIE\WC_Change_Order_Payment_Gateway\Includes\BH_WC_Change_Order_Payment_Gateway;

/**
 * Verifies the plugin has been instantiated and added to PHP's $GLOBALS variable.
 */
class Plugin_Integration_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * Test the main plugin object is added to PHP's GLOBALS and that it is the correct class.
	 */
	public function test_plugin_instantiated() {

		$this->assertArrayHasKey( 'bh_wc_change_order_payment_gateway', $GLOBALS );

		$this->assertInstanceOf( BH_WC_Change_Order_Payment_Gateway::class, $GLOBALS['bh_wc_change_order_payment_gateway'] );
	}

}
