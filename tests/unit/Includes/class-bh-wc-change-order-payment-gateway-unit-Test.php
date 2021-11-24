<?php
/**
 * @package BH_WC_Change_Order_Payment_Gateway_Unit_Name
 * @author  BrianHenryIE <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Change_Order_Payment_Gateway\Includes;

use BrianHenryIE\WC_Change_Order_Payment_Gateway\Admin\Admin;
use BrianHenryIE\WC_Change_Order_Payment_Gateway\Frontend\Frontend;
use WP_Mock\Matcher\AnyInstance;

/**
 * Class BH_WC_Change_Order_Payment_Gateway_Unit_Test
 * @coversDefaultClass \BH_WC_Change_Order_Payment_Gateway\Includes\BH_WC_Change_Order_Payment_Gateway
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

		new BH_WC_Change_Order_Payment_Gateway();
	}

	/**
	 * @covers ::define_admin_hooks
	 */
	public function test_admin_hooks() {

		\WP_Mock::expectActionAdded(
			'admin_enqueue_scripts',
			array( new AnyInstance( Admin::class ), 'enqueue_styles' )
		);

		\WP_Mock::expectActionAdded(
			'admin_enqueue_scripts',
			array( new AnyInstance( Admin::class ), 'enqueue_scripts' )
		);

		new BH_WC_Change_Order_Payment_Gateway();
	}

	/**
	 * @covers ::define_frontend_hooks
	 */
	public function test_frontend_hooks() {

		\WP_Mock::expectActionAdded(
			'wp_enqueue_scripts',
			array( new AnyInstance( Frontend::class ), 'enqueue_styles' )
		);

		\WP_Mock::expectActionAdded(
			'wp_enqueue_scripts',
			array( new AnyInstance( Frontend::class ), 'enqueue_scripts' )
		);

		new BH_WC_Change_Order_Payment_Gateway();
	}

}
