<?php

class PluginsPageCest {

	/**
	 * Login and navigate to plugins.php.
	 *
	 * @param AcceptanceTester $I The Codeception tester.
	 *
	 * phpcs:disable PSR2.Methods.MethodDeclaration.Underscore
	 */
	public function _before( AcceptanceTester $I ) {
		$I->loginAsAdmin();

		$I->amOnPluginsPage();
	}

	/**
	 * Verify the name of the plugin has been set.
	 *
	 * @param AcceptanceTester $I The tester.
	 */
	public function testPluginsPageForName( AcceptanceTester $I ) {

		$I->canSee( 'BH WC Change Order Payment Gateway' );
	}

	/**
	 * Check the description displayed on plugins.php has been changed from the default.
	 *
	 * @param AcceptanceTester $I The tester.
	 */
	public function testPluginDescriptionHasBeenSet( AcceptanceTester $I ) {

		$default_plugin_description = "This is a short description of what the plugin does. It's displayed in the WordPress admin area.";

		$I->cantSee( $default_plugin_description );
	}

}
