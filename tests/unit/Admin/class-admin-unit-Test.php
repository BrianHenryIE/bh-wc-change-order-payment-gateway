<?php
/**
 * Tests for Admin.
 *
 * @see Admin
 *
 * @package bh-wc-change-order-payment-gateway
 * @author Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Change_Order_Payment_Gateway\Admin;

/**
 * Class Admin_Test
 *
 * @coversDefaultClass \BH_WC_Change_Order_Payment_Gateway\Admin\Admin
 */
class Admin_Test extends \Codeception\Test\Unit {

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
				'return' => $plugin_root_dir . '/admin/',
			)
		);

		$css_file = $plugin_root_dir . '/admin/css/bh-wc-change-order-payment-gateway-admin.css';

		\WP_Mock::userFunction(
			'wp_enqueue_style',
			array(
				'times' => 1,
				'args'  => array( $this->plugin_name, $css_file, array(), $this->version, 'all' ),
			)
		);

		$admin = new Admin();

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
				'return' => $plugin_root_dir . '/admin/',
			)
		);

		$handle    = $this->plugin_name;
		$src       = $plugin_root_dir . '/admin/js/bh-wc-change-order-payment-gateway-admin.js';
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

		$admin = new Admin( $this->plugin_name, $this->version );

		$admin->enqueue_scripts();

		$this->assertFileExists( $src );
	}
}
