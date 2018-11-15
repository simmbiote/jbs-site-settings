<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       jbsimms.co.za
 * @since      1.0.0
 *
 * @package    Jbs_Site_Settings
 * @subpackage Jbs_Site_Settings/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Jbs_Site_Settings
 * @subpackage Jbs_Site_Settings/public
 * @author     Simmbiote <john@jbsimms.co.za>
 */
class Jbs_Site_Settings_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        /* Set up shortcodes. */
        $this->shortcodes();

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Jbs_Site_Settings_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Jbs_Site_Settings_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/jbs-site-settings-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Jbs_Site_Settings_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Jbs_Site_Settings_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/jbs-site-settings-public.js', array('jquery'), $this->version, false);

    }

    public static function get_setting($id)
    {
        global $sitepress;
        $setting = '';
        if ($id) {
            $settingId = $id;
            $settings = get_option('jbs-site-settings');
            if (isset($settings[$settingId])) {
                $setting = $settings[$settingId]['setting_value'];
                if (isset($sitepress) && isset($setting[$sitepress->get_current_language()])) {
                    $setting = stripslashes($setting[$sitepress->get_current_language()]);
                }
            }
        }
        return $setting;

    }

    private function shortcodes()
    {

        /* [site-setting id="" ]*/
        add_shortcode('site-setting', function ($attributes) {
            if ($attributes['id']) {
                return self::get_setting($attributes['id']);
            }
        });
    }

}

