<?php
/**
 * @package BH_WC_Change_Order_Payment_Gateway_Unit_Name
 * @author  BrianHenryIE <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Change_Order_Payment_Gateway\Includes;

use BrianHenryIE\ColorLogger\ColorLogger;
use BrianHenryIE\WC_Change_Order_Payment_Gateway\Admin\Admin;
use BrianHenryIE\WC_Change_Order_Payment_Gateway\API\API_Interface;
use BrianHenryIE\WC_Change_Order_Payment_Gateway\API\Settings_Interface;
use BrianHenryIE\WC_Change_Order_Payment_Gateway\Frontend\Frontend;
use BrianHenryIE\WC_Change_Order_Payment_Gateway\WooCommerce\Admin_Order_UI;
use WP_Mock\Matcher\AnyInstance;

/**
 * Class BH_WC_Change_Order_Payment_Gateway_Unit_Test
 *
 * @coversDefaultClass \BrianHenryIE\WC_Change_Order_Payment_Gateway\Includes\BH_WC_Change_Order_Payment_Gateway
 */
class BH_WC_Change_Order_Payment_Gateway_Unit_Test extends \Codeception\Test\Unit {

	protected function setup(): void {
		parent::setup();
		\WP_Mock::setUp();
	}

	protected function tearDown(): void {
		parent::tearDown();
		\WP_Mock::tearDown();
	}

	/**
	 * @covers ::set_locale
	 */
	public function test_set_locale_hooked() {

		\WP_Mock::expectActionAdded(
			'init',
			array( new AnyInstance( I18n::class ), 'load_plugin_textdomain' )
		);

		$api      = $this->makeEmpty( API_Interface::class );
		$settings = $this->makeEmpty( Settings_Interface::class );
		$logger   = new ColorLogger();
		new BH_WC_Change_Order_Payment_Gateway( $api, $settings, $logger );
	}

	/**
	 * @covers ::define_woocommerce_admin_order_ui_hooks
	 */
	public function test_woocommerce_admin_order_ui_hooks() {

		\WP_Mock::expectActionAdded(
			'admin_enqueue_scripts',
			array( new AnyInstance( Admin_Order_UI::class ), 'enqueue_styles' )
		);

		\WP_Mock::expectActionAdded(
			'admin_enqueue_scripts',
			array( new AnyInstance( Admin_Order_UI::class ), 'enqueue_scripts' )
		);

		$api      = $this->makeEmpty( API_Interface::class );
		$settings = $this->makeEmpty( Settings_Interface::class );
		$logger   = new ColorLogger();
		new BH_WC_Change_Order_Payment_Gateway( $api, $settings, $logger ); }

}
