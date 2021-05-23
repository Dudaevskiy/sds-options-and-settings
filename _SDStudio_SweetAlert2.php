<?php
/**
 * REDUX - Захват опций темы
 */
$redux = get_option( 'redux_sds_options_and_settings' );

global $sds_options_and_settings__enable_sweetalert2;
$sds_options_and_settings__enable_sweetalert2 = $redux['enable_sweetalert2'];

//dd($redux['enable_hot_key_login-page-posts-sds-options-and-settings']);
//enable_sweetalert2
if ($sds_options_and_settings__enable_sweetalert2 == 1 || $redux['enable_hot_key_login-page-posts-sds-options-and-settings'] == 1) {

    if (is_admin()){
        return;
    }

    /* Отключаем SweetAlert2 подключенный другими плагинамм */
//    add_action( 'wp_print_scripts', 'de_script', 100 );
//    function de_script() {
//        wp_dequeue_script( 'sweetalert2' );
//        wp_deregister_script( 'sweetalert2' );
//    }


    if ( !function_exists( 'SDS_OPTIONS_AND_SETTINGS_register_SweetAlert2_script' ) ) {
        add_action('init', 'SDS_OPTIONS_AND_SETTINGS_register_SweetAlert2_script');
        function SDS_OPTIONS_AND_SETTINGS_register_SweetAlert2_script() {
            wp_register_style('sweetalert_animate', SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL . 'sweetalert2/animate.min.css');
            wp_register_style('sweetalert_css', SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL . 'sweetalert2/sweetalert2.min.css');
            wp_register_style('SweetAlert2_CUSTOM', SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL . 'sweetalert2/__SweetAlert2_CUSTOM.css');
            wp_enqueue_script('sweetalert2_js', SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL . 'sweetalert2/sweetalert2.min.js',array ( 'jquery' ), 1.1, true);
        }

        // use the registered jquery and style above
        add_action('wp_enqueue_scripts', 'SDS_OPTIONS_AND_SETTINGS_SweetAlert2_enqueue_style');
        function SDS_OPTIONS_AND_SETTINGS_SweetAlert2_enqueue_style(){
            wp_enqueue_style('sweetalert_animate');
            wp_enqueue_style('sweetalert_css');
            wp_enqueue_style('SweetAlert2_CUSTOM');
        }
    }
}