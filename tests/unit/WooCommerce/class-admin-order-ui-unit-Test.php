<?php
/**
 * Tests for WooCommerce.
 *
 * @see Admin_Order_UI
 *
 * @package bh-wc-change-order-payment-gateway
 * @author Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Change_Order_Payment_Gateway\WooCommerce;

use BrianHenryIE\ColorLogger\ColorLogger;
use BrianHenryIE\WC_Change_Order_Payment_Gateway\API\Settings_Interface;
use BrianHenryIE\WC_Change_Order_Payment_Gateway\WooCommerce\Admin_Order_UI;

/**
 * Class Admin_Test
 *
 * @coversDefaultClass \BrianHenryIE\WC_Change_Order_Payment_Gateway\WooCommerce\Admin_Order_UI
 */
class Admin_Order_UI_Test extends \Codeception\Test\Unit {

	protected function setup(): void {
		parent::setup();
		\WP_Mock::setUp();
	}

	protected function tearDown(): void {
		parent::tearDown();
		\WP_Mock::tearDown();
	}

	/**
	 * The plugin name. Unlikely to change.
	 *
	 * @var string Plugin name.
	 */
	private $plugin_name = 'bh-wc-change-order-payment-gateway';

	/**
	 * The plugin version, matching the version these tests were written against.
	 *
	 * @var string Plugin version.
	 */
	private $version = '1.0.0';

	/**
	 * Verifies enqueue_styles() calls wp_enqueue_style() with appropriate parameters.
	 * Verifies the .css file exists.
	 *
	 * @covers ::enqueue_styles
	 * @see wp_enqueue_style()
	 */
	public function test_enqueue_styles() {

		global $plugin_root_dir;

		// Return any old url.
		\WP_Mock::userFunction(
			'plugin_dir_url',
			array(
				'return' => $plugin_root_dir . '/WooCommerce/',
			)
		);

		$css_file = $plugin_root_dir . '/WooCommerce/css/bh-wc-change-order-payment-gateway-admin.css';

		\WP_Mock::userFunction(
			'wp_enqueue_style',
			array(
				'times' => 1,
				'args'  => array( $this->plugin_name, $css_file, array(), $this->version, 'all' ),
			)
		);

		$settings = $this->makeEmpty( Settings_Interface::class, array( 'get_plugin_version' => $this->version ) );
		$logger   = new ColorLogger();
		$admin    = new Admin_Order_UI( $settings, $logger );

		$admin->enqueue_styles();

		$this->assertFileExists( $css_file );
	}

	/**
	 * Verifies enqueue_scripts() calls wp_enqueue_script() with appropriate parameters.
	 * Verifies the .js file exists.
	 *
	 * @covers ::enqueue_scripts
	 * @see wp_enqueue_script()
	 */
	public function test_enqueue_scripts() {

		global $plugin_root_dir;

		// Return any old url.
		\WP_Mock::userFunction(
			'plugin_dir_url',
			array(
				'return' => $plugin_root_dir . '/WooCommerce/',
			)
		);

		$handle    = $this->plugin_name;
		$src       = $plugin_root_dir . '/WooCommerce/js/bh-wc-change-order-payment-gateway-admin.js';
		$deps      = array( 'jquery' );
		$ver       = $this->version;
		$in_footer = true;

		\WP_Mock::userFunction(
			'wp_enqueue_script',
			array(
				'times' => 1,
				'args'  => array( $handle, $src, $deps, $ver, $in_footer ),
			)
		);

		\WP_Mock::userFunction(
			'wp_nonce_field'
		);
		$mock = new class() {
			public function payment_gateways() {
				return new class() {
					public function payment_gateways() {
						return array();
					}
				};
			}
		};
		\WP_Mock::userFunction(
			'WC',
			array(
				'return' => $mock,

			)
		);
		\WP_Mock::userFunction(
			'wp_add_inline_script'
		);

		$settings = $this->makeEmpty( Settings_Interface::class, array( 'get_plugin_version' => $this->version ) );
		$logger   = new ColorLogger();
		$admin    = new Admin_Order_UI( $settings, $logger );

		$admin->enqueue_scripts();

		$this->assertFileExists( $src );
	}
}
