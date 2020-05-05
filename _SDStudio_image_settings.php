<?php
/**
 * REDUX - Захват опций темы
 */
$redux = get_option( 'redux_sds_options_and_settings' );

// URL - Logo
global $sds_options_and_settings__gallery_settings_opt;
$enable_image_link_paste_auto_sds_options_and_settings = $redux['enable_image_link_paste_auto_sds-options-and-settings'];



if ($enable_image_link_paste_auto_sds_options_and_settings == 1 ) {

    //https://wordpress.stackexchange.com/questions/214362/bulk-change-of-image-setting-link-to-to-link-to-image-url
    function wpb_imagelink_setup()
    {
        $image_set = get_option('image_default_link_type');
        update_option('image_default_link_type', 'file');
    }
    add_action('admin_init', 'wpb_imagelink_setup', 10);

    //function wpb_imagelink_setup() {
    //    $image_set = get_option( 'image_default_link_type' );
    //    update_option('image_default_link_type', 'image url');
    //
    //}
    //add_action('admin_init', 'wpb_imagelink_setup', 10);
}