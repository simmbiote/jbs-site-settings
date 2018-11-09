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


<?php if ($options && count($options) > 0) { ?>
    <h2>Settings</h2>
    <table class="widefat fixed" cellspacing="0">
        <thead>
        <tr>
            <th width="200" style="max-width: 200px" class="manage-column    ">Name</th>
            <th class="manage-column    ">Value</th>
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
                        <em title="Usage: get_sim_setting('<?php echo $option_id; ?>')">ID: <?php echo $option_id; ?></em>
                    </div>
                </td>
                <td>
                    <table class="setting-values">
                        <?php if (is_string($values)) {
                            ?>
                            <tr >
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
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>


<h2 id="form-heading"><span class="mode">Create</span> Setting</h2>

<form method="post" name="setting_options" id="setting_options" action="options.php">
    <?php settings_fields($this->plugin_name); ?>
    <input type="hidden" name="setting_id" id="setting_id">
    <table class="form-table">
        <tr>
            <td align="top" width="150"><span>Setting Name</span></td>
            <td><input placeholder="Setting name" required type="text" id="setting_name" name="setting_name"></td>
        </tr>
        <?php if (isset($sitepress) && count($languages) > 0) { ?>
            <?php foreach ($languages as $language) { ?>
                <tr>
                    <td align="top">Setting
                        value <?php echo '(' . strtoupper($language['code']) . ')'; ?> <?php echo $language['code'] == $default_language ? "(Default)" : ""; ?></td>
                    <td align="top"><textarea name="setting_value[<?php echo $language['code']; ?>]"
                                              id="setting_value_<?php echo $language['code']; ?>" cols="60"
                                              rows="5"></textarea></td>
                </tr>
            <?php } ?>
        <?php } else { ?>

            <tr>
                <td align="top">Setting value</td>
                <td align="top"><textarea id="setting_value" name="setting_value" id="" cols="60" rows="5"></textarea>
                </td>
            </tr>
        <?php } ?>
        <!--       <tr>
                   <td align="top">Notes (optional)</td>
                   <td align="top"><textarea name="setting_notes" id="" cols="60" rows="5"></textarea>
                   </td>
               </tr>-->
    </table>

    <?php submit_button('Save'); ?>
    <button type="reset" class="button ">Cancel</button>
</form>
