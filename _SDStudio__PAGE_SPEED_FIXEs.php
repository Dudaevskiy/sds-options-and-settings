<?php
$redux = get_option( 'redux_sds_options_and_settings' );
global $_SDStudio__PAGE_SPEED_FIXEs;
$_SDStudio__PAGE_SPEED_FIXEs = $redux['enable_js_inlineinpage_sds-options-and-settings'];
//global $_enable_webfonts_swap;
//$_enable_webfonts_swap = $redux['enable_webfonts_swap_sds-options-and-settings'];
//global $_enable_SWAP_bs_icons_SDStudio;
//$_enable_SWAP_bs_icons_SDStudio = $redux['print_SWAP_bs_icons_SDStudio_swap_sds-options-and-settings'];



if ($_SDStudio__PAGE_SPEED_FIXEs == 1 ) {
    /**
     * Полностью удаляем
     * jQuery из WordPress
     */
    function my_init() {
        if (!is_admin()) {
            wp_deregister_script('jquery');
            wp_register_script('jquery', false);
        }
    }
    add_action('init', 'my_init');

    /**
     * Встраиваем jQuery в тело страницы
     */
    add_action( 'wp_head', 'print_jQuery_SDStudio',1 );
    function print_jQuery_SDStudio(){
//    $jQuery = file_get_contents(includes_url( '/js/jquery/jquery.min.js' ));
//    dd($jQuery);

        $jq = file_get_contents(ABSPATH . WPINC . '/js/jquery/jquery.min.js');
//        ddd($jq);
        $wpml_jq_cokie = wp_remote_retrieve_body( wp_remote_get( plugins_url() . '/sitepress-multilingual-cms/res/js/jquery.cookie.js' ) );
//    dd(plugins_url('sitepress-multilingual-cms/'));
//    dd($wpml_jq_cokie);

        if (!is_admin()) {
            echo '<script>';
            echo '/* SDStudio Inline jQuery START */' . "\n";
//        echo file_get_contents(includes_url('/js/jquery/jquery.min.js'));
            echo $jq;
//        if ( function_exists('icl_object_id') ) {
            echo '$ = jQuery;';
            echo $wpml_jq_cokie;
            echo "\n".'/* SDStudio Inline jQuery END */' . "\n";
//        }
            echo '</script>';
        }
    }


//    ddd($_SDStudio__PAGE_SPEED_FIXEs);
}