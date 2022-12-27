<?php
$redux = get_option( 'redux_sds_options_and_settings' );
global $_SDStudio__PAGE_SPEED_FIXEs;
$_SDStudio__PAGE_SPEED_FIXEs = $redux['enable_js_inlineinpage_sds-options-and-settings'];
global $_enable_webfonts_swap;
$_enable_webfonts_swap = $redux['enable_webfonts_swap_sds-options-and-settings'];
global $_enable_SWAP_bs_icons_SDStudio;
$_enable_SWAP_bs_icons_SDStudio = $redux['print_SWAP_bs_icons_SDStudio_swap_sds-options-and-settings'];



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



if ($_enable_SWAP_bs_icons_SDStudio == 1 ) {
//    ddd(get_template_directory_uri());
//    /**
//     * Встраиваем jQuery в тело страницы
//     */
//    add_action( 'wp_head', 'print_SWAP_bs_icons_SDStudio',1 );
//    function print_SWAP_bs_icons_SDStudio(){
//        echo '<!-- Publisher bs-icons SDStudio START -->';
//        echo '<style>';
//        echo '@font-face {';
//        echo 'font-family: "bs-icons";';
//        echo 'src:url("'.get_template_directory_uri().'/includes/libs/better-framework/assets/fonts/bs-icons.eot");';
//        echo 'src:url("'.get_template_directory_uri().'/includes/libs/better-framework/assets/fonts/bs-icons.eot?#iefix") format("embedded-opentype"),url("'.get_template_directory_uri().'/includes/libs/better-framework/assets/fonts/bs-icons.woff") format("woff"),url("'.get_template_directory_uri().'/includes/libs/better-framework/assets/fonts/bs-icons.ttf") format("truetype"),url("'.get_template_directory_uri().'/includes/libs/better-framework/assets/fonts/bs-icons.svg#bs-icons") format("svg");';
//        echo 'font-weight: normal;';
//        echo 'font-style: normal;';
//        echo 'font-display: swap !important;';
//        echo '}';
//        echo '</style>';
//        echo '<!-- Publisher bs-icons SDStudio END -->';
//    }

    /**
     * Встраиваем jQuery в тело страницы
     * https://gamesradar.inform.click/wp-content/themes/publisher/includes/libs/better-framework/assets/fonts/fontawesome-webfont.woff2?v=4.7.0
     */
//    add_action( 'wp_head', 'print_SWAP_PUBLISHER_FontAwesome_SDStudio',1 );
    function print_SWAP_PUBLISHER_FontAwesome_SDStudio(){
//        echo '<!-- Publisher FontAwesome SDStudio START --><style>body { background-color: #f00; }</style>';
        ?>
        <style>
        body { background-color: #f00; }
        </style>
        <?php
//        echo '<style>';

//        echo '@font-face {';
//        echo 'font-family: "FontAwesome" !important;';
//        echo 'src: url(\''.get_template_directory_uri().'/includes/libs/better-framework/assets/fonts/fontawesome-webfont.eot?v=4.7.0\'); !important;';
//        echo 'src: url(\''.get_template_directory_uri().'/includes/libs/better-framework/assets/fonts/fontawesome-webfont.eot?#iefix&v=4.7.0\') format(\'embedded-opentype\'),url(\''.get_template_directory_uri().'/includes/libs/better-framework/assets/fonts/fontawesome-webfont.woff2?v=4.7.0\') format(\'woff2\'),url(\''.get_template_directory_uri().'/includes/libs/better-framework/assets/fonts/fontawesome-webfont.woff?v=4.7.0\') format(\'woff\'),url(\''.get_template_directory_uri().'/includes/libs/better-framework/assets/fonts/fontawesome-webfont.ttf?v=4.7.0\') format(\'truetype\'),url(\''.get_template_directory_uri().'/includes/libs/better-framework/assets/fonts/fontawesome-webfont.svg?v=4.7.0#fontawesomeregular\') format(\'svg\'); !important;';
//        echo 'font-weight: normal;';
//        echo 'font-style: normal;';

//        echo 'font-display: swap !important;';
//        echo '}';


//        echo '</style>';
//        echo '<!-- Publisher FontAwesome SDStudio END -->';
    }
}