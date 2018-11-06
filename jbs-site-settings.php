<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              jbsimms.co.za
 * @since             1.0.0
 * @package           Jbs_Site_Settings
 *
 * @wordpress-plugin
 * Plugin Name:       Site Settings
 * Plugin URI:        jbs-site-settings
 * Description:       Add and manage settings for your theme.
 * Version:           1.0.0
 * Author:            Simmbiote
 * Author URI:        jbsimms.co.za
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       jbs-site-settings
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
if (!defined('PLUGIN_NAME_VERSION')) {
    define('PLUGIN_NAME_VERSION', '1.0.0');
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-jbs-site-settings-activator.php
 */
function activate_jbs_site_settings()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-jbs-site-settings-activator.php';
    Jbs_Site_Settings_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-jbs-site-settings-deactivator.php
 */
function deactivate_jbs_site_settings()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-jbs-site-settings-deactivator.php';
    Jbs_Site_Settings_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_jbs_site_settings');
register_deactivation_hook(__FILE__, 'deactivate_jbs_site_settings');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-jbs-site-settings.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_jbs_site_settings()
{

    $plugin = new Jbs_Site_Settings();
    $plugin->run();

}

run_jbs_site_settings();


/* Make helper functions available */

if (!function_exists('get_sim_setting')) {
    function get_sim_setting($id)
    {
        return Jbs_Site_Settings_Public::get_setting($id);
    }
}



