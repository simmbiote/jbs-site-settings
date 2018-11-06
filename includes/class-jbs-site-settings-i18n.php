<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       jbsimms.co.za
 * @since      1.0.0
 *
 * @package    Jbs_Site_Settings
 * @subpackage Jbs_Site_Settings/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Jbs_Site_Settings
 * @subpackage Jbs_Site_Settings/includes
 * @author     Simmbiote <john@jbsimms.co.za>
 */
class Jbs_Site_Settings_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'jbs-site-settings',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
