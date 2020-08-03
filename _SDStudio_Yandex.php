<?php
/**
* REDUX - Захват опций темы
*/
$redux = get_option( 'redux_sds_options_and_settings' );

global $enable_yandex_code_sds_options_and_settings;
$enable_yandex_code_sds_options_and_settings = $redux['enable_yandex_code_sds-options-and-settings'];
global $CODE__enable_yandex_code_sds_options_and_settings;
$CODE__enable_yandex_code_sds_options_and_settings = $redux['CODE__enable_yandex_code_sds-options-and-settings'];


if ($enable_yandex_code_sds_options_and_settings == 1 ) {
//    $Yandex_MetaTag = "<meta name=\"yandex-verification\" content=\"".$CODE__enable_yandex_code_sds_options_and_settings."\" />";
//    dd($Yandex_MetaTag);

    function theme_xyz_header_metadata() {
        // Post object if needed
        // global $post;

        // Page conditional if needed
        // if( is_page() ){}
        global $CODE__enable_yandex_code_sds_options_and_settings;
        echo "\n";?>
<!--   SDStudio Options and Setting - Yandex META     -->
<meta name="yandex-verification" content="<?php echo $CODE__enable_yandex_code_sds_options_and_settings;?>" />
        <?php
    }
    add_action( 'wp_head', 'theme_xyz_header_metadata' );
}