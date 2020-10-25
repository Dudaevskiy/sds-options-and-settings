<?php
/**
 * REDUX - Захват опций темы
 */
$redux = get_option( 'redux_sds_options_and_settings' );

global $enable_header_code_mailru_tag_sds_options_and_settings;
$enable_header_code_mailru_tag_sds_options_and_settings = $redux['enable_header_code_mailru_tag_sds-options-and-settings'];
global $CODE_enable_mailru_tag_sds_options_and_settings;
$CODE_enable_mailru_tag_sds_options_and_settings = $redux['CODE_enable_mailru_tag_sds-options-and-settings'];

if ($enable_header_code_mailru_tag_sds_options_and_settings == 1 ) {
//    $Yandex_MetaTag = "<meta name=\"yandex-verification\" content=\"".$CODE__enable_yandex_code_sds_options_and_settings."\" />";
//    dd($Yandex_MetaTag);

    function SDStudio_add_MailRU_meta() {
        global $CODE_enable_mailru_tag_sds_options_and_settings;
        echo "\n";?>
        <!--   SDStudio Options and Setting - Mail.ru META     -->
        <meta name="wmail-verification" content="<?php echo $CODE_enable_mailru_tag_sds_options_and_settings;?>" />
        <?php
    }
    add_action( 'wp_head', 'SDStudio_add_MailRU_meta' );
}
