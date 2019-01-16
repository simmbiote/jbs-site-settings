<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       jbsimms.co.za
 * @since      1.0.0
 *
 * @package    Jbs_Site_Settings
 * @subpackage Jbs_Site_Settings/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Jbs_Site_Settings
 * @subpackage Jbs_Site_Settings/admin
 * @author     Simmbiote <john@jbsimms.co.za>
 */
class Jbs_Site_Settings_Admin
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
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        if (isset($_POST['export_settings'])) {
            $this->export_settings();
        }


        if (isset($_POST['import_settings'])) {

            $this->import_file = $_FILES['settings_file'];
            $this->import_settings();
        }

    }

    /**
     * Register the stylesheets for the admin area.
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/jbs-site-settings-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/jbs-site-settings-admin.js', array('jquery'), $this->version, false);

    }

    /**
     * Plug in Settings page.
     * Administration Menus: http://codex.wordpress.org/Administration_Menus
     */

    public function add_plugin_admin_menu()
    {

        add_options_page('Theme Settings', 'Theme Settings', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
        );
    }


    /**
     * Callback function for Settings page.
     */

    public function display_plugin_setup_page()
    {
        include_once('partials/jbs-site-settings-admin-display.php');
    }

    /**
     * Create Settings link
     * https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
     *
     */

    public function add_action_links($links)
    {

        $settings_link = array(
            '<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge($settings_link, $links);

    }

    /**
     *
     * Store valid post data in options table.
     *
     */

    public function validate($input)
    {

        $data = get_option($this->plugin_name);

        if ($this->import_file) {
            $file_contents = file_get_contents($this->import_file['tmp_name']);

            $decoded = json_decode($file_contents);
            foreach ((array)$decoded as $setting_id => $setting_data) {
                $setting_data = (array)$setting_data;
                $data[$setting_id] = [
                    'setting_name' => $setting_data['setting_name'],
                    'setting_value' => $setting_data['setting_value'],
                ];

            }
        }

        if (isset($_POST['setting_id']) && $_POST['setting_id']) {
            $setting_id = sanitize_title($_POST['setting_id']);
            $setting_id = $setting_id ? $setting_id : sanitize_title($_POST['setting_name']);
            $setting_value = $_POST['setting_value'];
            if ($setting_id) {
                $data[$setting_id] =
                    [
                        'setting_name' => $_POST['setting_name'],
                        'setting_value' => $setting_value
                    ];

            }
        }

        return $data;
    }

    /**
     * On Update
     */

    public function options_update()
    {
        register_setting($this->plugin_name, $this->plugin_name, [$this, 'validate']);
    }


    /**
     * Create a new setting */

    public function create_setting()
    {
        $setting_id = sanitize_title($_POST['setting_name']);
        register_setting($this->plugin_name, $setting_id, array($this, 'validate'));

    }


    public function update_setting($option_name)
    {
        /* Get Post */
        register_setting($this->plugin_name, $option_name, array($this, 'validate'));
    }

    public function delete_setting($option_name)
    {
        unregister_setting($this->plugin_name, $option_name);
    }


    public function export_settings()
    {
        $settings = get_option($this->plugin_name);
        header('Content-type: text/plain');
        header("Content-Disposition: attachment; filename=site-settings-" . date("Y-m-d") . ".txt");
        echo json_encode($settings);
        exit();
    }

    public function import_settings()
    {

        $errors = [];

        if ($this->import_file['error']) {
            $errors[] = "An error occurred: Code " . $this->import_file['error'];
        }

        if ($this->import_file['type'] !== "text/plain" || $this->import_file['size'] < 1) {
            $errors[] = "Invalid file";
        }

        update_option($this->plugin_name, $this->validate(''));

    }

}
