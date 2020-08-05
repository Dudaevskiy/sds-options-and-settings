<?php
/**
* REDUX - Захват опций темы
*/
$redux = get_option( 'redux_sds_options_and_settings' );

global $enable_google_adsense_sds_options_and_settings;
$enable_google_adsense_sds_options_and_settings = $redux['enable_google_adsense_sds-options-and-settings'];
global $CODE__enable_google_adsense_sds_options_and_settings;
$CODE__enable_google_adsense_sds_options_and_settings = $redux['CODE__enable_google_adsense_sds-options-and-settings'];


if ($enable_google_adsense_sds_options_and_settings == 1 ) {

    if (current_user_can( 'administrator' ) === false ) {
        function GoogleADS_ADD_header_metadata() {
            // Post object if needed
            // global $post;

            // Page conditional if needed
            // if( is_page() ){}
            global $CODE__enable_google_adsense_sds_options_and_settings;
            echo "\n";?>
<!--   SDStudio Options and Setting - Google ADSense SCRIPT     -->
<!-- Асинхронная загрузка Google ADSense START FIX-->
<script data-ad-client="<?php echo $CODE__enable_google_adsense_sds_options_and_settings;?>" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <?php
            echo "\n";
        }
        add_action( 'wp_head', 'GoogleADS_ADD_header_metadata' );
    }
}