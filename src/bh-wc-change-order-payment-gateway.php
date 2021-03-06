<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package brianhenryie/wc-change-order-payment-gateway
 *
 * @wordpress-plugin
 * Plugin Name:       Change Order Payment Gateway
 * Plugin URI:        http://github.com/BrianHenryIE/bh-wc-change-order-payment-gateway/
 * Description:       Allows changing the payment gateway of a WooCommerce order after the order is complete.
 * Version:           1.0.0
 * Requires PHP:      7.4
 * Author:            BrianHenryIE
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bh-wc-change-order-payment-gateway
 * Domain Path:       /languages
 */

namespace BrianHenryIE\WC_Change_Order_Payment_Gateway;

use BrianHenryIE\WC_Change_Order_Payment_Gateway\API\API;
use BrianHenryIE\WC_Change_Order_Payment_Gateway\API\Settings;
use BrianHenryIE\WC_Change_Order_Payment_Gateway\BrianHenryIE\WP_Logger\Logger;
use BrianHenryIE\WC_Change_Order_Payment_Gateway\Includes\BH_WC_Change_Order_Payment_Gateway;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'autoload.php';

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BH_WC_CHANGE_ORDER_PAYMENT_GATEWAY_VERSION', '1.0.0' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function instantiate_bh_wc_change_order_payment_gateway(): BH_WC_Change_Order_Payment_Gateway {

	$settings = new Settings();
	$logger   = Logger::instance( $settings );
	$api      = new API();

	$plugin = new BH_WC_Change_Order_Payment_Gateway( $api, $settings, $logger );

	return $plugin;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and frontend-facing site hooks.
 */
$GLOBALS['bh_wc_change_order_payment_gateway'] = instantiate_bh_wc_change_order_payment_gateway();
