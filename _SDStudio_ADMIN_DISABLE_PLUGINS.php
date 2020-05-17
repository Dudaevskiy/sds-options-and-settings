<?php

$redux = get_option( 'redux_sds_options_and_settings' );

global $enable_DISABLE_FOR_ADMIN_highlight_and_share_sds_options_and_settings;
$enable_DISABLE_FOR_ADMIN_highlight_and_share_sds_options_and_settings = $redux['enable_DISABLE_FOR_ADMIN_highlight-and-share_sds-options-and-settings'];

//dd($enable_DISABLE_FOR_ADMIN_highlight_and_share_sds_options_and_settings);

global $enable_DISABLE_FOR_ADMIN_sem_external_links_sds_options_and_settings;
$enable_DISABLE_FOR_ADMIN_sem_external_links_sds_options_and_settings = $redux['enable_DISABLE_FOR_ADMIN_sem-external-links_sds-options-and-settings'];

/**
 * Отключаем
 *
 */
if ($enable_DISABLE_FOR_ADMIN_highlight_and_share_sds_options_and_settings == 1) {
    include_once(ABSPATH . 'wp-includes/pluggable.php');
    if ( current_user_can( 'administrator' )) {
        function DISABLE_FOR_ADMIN_highlight_and_share_sds_options_and_settings_js()
        {
            wp_dequeue_script('highlight-and-share'); //Name of Style ID.
            // wp_deregister_style('woodmart-style');
        }

        add_action('wp_enqueue_scripts', 'DISABLE_FOR_ADMIN_highlight_and_share_sds_options_and_settings_js', 100);
    }
}


/*
include_once(ABSPATH . 'wp-includes/pluggable.php');
if ( current_user_can( 'administrator' )) {
    $plugins = array();
    if ($enable_DISABLE_FOR_ADMIN_highlight_and_share_sds_options_and_settings == 1){
        $plugins[] = "highlight-and-share/highlight-and-share.php";
    }
    if ($enable_DISABLE_FOR_ADMIN_sem_external_links_sds_options_and_settings == 1){
        $plugins[] = "sem-external-links/sem-external-links.php";
    }

//    dd($plugins);

//        'highlight-and-share/highlight-and-share.php','sem-external-links/sem-external-links.php'
//    );


//if (((getenv('environment') == 'production') || (getenv('environment') == 'alpha')) == false) {
//    $plugins = array(
//        'highlight-and-share/highlight-and-share.php','sem-external-links/sem-external-links.php'
//    );
    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    deactivate_plugins($plugins);
} else {
    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    activate_plugins($plugins);
}
*/