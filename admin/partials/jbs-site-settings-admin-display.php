<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       jbsimms.co.za
 * @since      1.0.0
 *
 * @package    Jbs_Site_Settings
 * @subpackage Jbs_Site_Settings/admin/partials
 */

global $sitepress;

$plugin_name = basename(plugin_dir_path(dirname(__FILE__, 2)));


if (isset($sitepress)) {
    $languages = $sitepress->get_active_languages();
    sort($languages);
    $default_language = $sitepress->get_default_language();
}

$options = get_option($plugin_name);

?>

<h1><?php echo esc_html(get_admin_page_title()); ?></h1>

<h2 class="nav-tab-wrapper settings-tabs">
    <a href="#settings-tab" class="nav-tab active">Settings</a>
    <a href="#export-tab" class="nav-tab">Export</a>
    <a href="#import-tab" class="nav-tab">Import</a>
</h2>

<div id="settings-tab" class="setting-tab active-tab">
    <?php if ($options && count($options) > 0) { ?>
        <h2><?php _e('Settings', 'sim-settings'); ?></h2>
        <table class="widefat fixed" cellspacing="0">
            <thead>
            <tr>
                <th width="200" style="max-width: 200px"
                    class="manage-column    "><?php _e('Name', 'sim-settings'); ?></th>
                <th class="manage-column "><?php _e('Value', 'sim-settings'); ?></th>
                <th class="manage-column "><?php _e('Shortcode', 'sim-settings'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($options as $option_id => $data) {
                $values = $data['setting_value'];
                ?>
                <tr id="setting-<?php echo $option_id; ?>">
                    <td><strong><a data-setting-id="<?php echo $option_id; ?>"
                                   href="#edit-setting"><?php echo $data['setting_name']; ?></a></strong>
                        <div>
                            <em title="Usage: get_sim_setting('<?php echo $option_id; ?>')"><?php _e('ID', 'sim-settings'); ?>
                                : <?php echo $option_id; ?></em>
                        </div>
                    </td>
                    <td>
                        <table class="setting-values">
                            <?php if (is_string($values)) {
                                ?>
                                <tr>
                                    <td>
                            <textarea name="setting_<?php echo $option_id; ?>"
                                      id="setting_<?php echo $option_id; ?>" cols="30"
                                      class="hidden-field setting_value_holder"
                                      rows="10"><?php echo stripslashes($values); ?></textarea>
                                        <pre class="small setting-value"><?php echo esc_html(stripslashes($values)); ?></pre>
                                    </td>
                                </tr>
                                <?php
                            } ?>
                            <?php if (is_array($values)) {
                                foreach ($values as $lang => $val) { ?>
                                    <tr data-lang="<?php echo $lang; ?>">
                                        <td><?php echo strtoupper($lang); ?></td>
                                        <td><textarea name="setting_<?php echo $option_id . '_' . $lang; ?>"
                                                      id="setting_<?php echo $option_id . '_' . $lang; ?>" cols="30"
                                                      class="hidden-field setting_value_holder"
                                                      rows="10"><?php echo stripslashes($val); ?></textarea>
                                            <pre class="small setting-value"><?php echo esc_html(stripslashes($val)); ?></pre>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                        </table>
                    </td>
                    <td>
                        <input title="<?php __('Click to select and copy the shortcode to your clipboard.', 'sim-settings'); ?>"
                               type="text" readonly class="short-code-selector" width="100%"
                               value='[site-setting id="<?php echo $option_id; ?>"]'
                               onclick="this.select();  document.execCommand('copy');">
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } ?>

    <h2 id="form-heading"><span
                class="mode"><?php _e('Create', 'sim-settings'); ?></span> <?php _e('Setting', 'sim-settings'); ?></h2>

    <form method="post" name="setting_options" id="setting_options" action="options.php">
        <?php settings_fields($this->plugin_name); ?>
        <input type="hidden" name="setting_id" id="setting_id">
        <table class="form-table">
            <tr>
                <td align="top" width="150"><span><?php _e('Setting Name', 'sim-settings'); ?></span></td>
                <td><input placeholder="Setting name" required type="text" id="setting_name" name="setting_name"></td>
            </tr>
            <?php if (isset($sitepress) && count($languages) > 0) { ?>
                <?php foreach ($languages as $language) { ?>
                    <tr>
                        <td align="top"><?php _e('Setting Value', 'sim-settings'); ?><?php echo '(' . strtoupper($language['code']) . ')'; ?><?php echo $language['code'] == $default_language ? "(Default)" : ""; ?></td>
                        <td align="top"><textarea name="setting_value[<?php echo $language['code']; ?>]"
                                                  id="setting_value_<?php echo $language['code']; ?>" cols="60"
                                                  rows="5"></textarea></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>

                <tr>
                    <td align="top"><?php _e('Setting Value', 'sim-settings'); ?></td>
                    <td align="top"><textarea id="setting_value" name="setting_value" id="" cols="60" rows="5"></textarea>
                    </td>
                </tr>
            <?php } ?>
            <!--       <tr>
                   <td align="top"><?php _e('Notes (optional)', 'sim-settings'); ?></td>
                   <td align="top"><textarea name="setting_notes" id="" cols="60" rows="5"></textarea>
                   </td>
               </tr>-->
        </table>

        <?php submit_button(__('Save', 'sim-settings')); ?>
        <button type="reset" class="button "><?php _e('Cancel', 'sim-settings'); ?></button>
    </form>




</div>
<div id="export-tab" class="setting-tab">

    <h3>Export Settings</h3>
    <p>Click on the Export Settings button below to download a file with your theme's settings.</p>
    <form action="options.php" method="post">
        <?php settings_fields($this->plugin_name); ?>
        <?php submit_button(__('Export settings', 'sim-settings'), 'primary', 'export_settings'); ?>

    </form>



</div>
<div id="import-tab" class="setting-tab">
    <h3>Import Settings</h3>
    <p>Click on the Import Settings button below to import a file you've exported before.</p>
    <form action="options.php" method="post" enctype="multipart/form-data">
        <input type="file" accept="text/plain" name="settings_file" required>
        <?php settings_fields($this->plugin_name); ?>
        <?php submit_button(__('Import settings', 'sim-settings'), 'primary', 'import_settings'); ?>
    </form>

</div>
