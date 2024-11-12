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


/**
 * REDUX - Отримання налаштувань
 */
$redux = get_option( 'redux_sds_options_and_settings' );

$enable_custom_verification = $redux['enable_custom_verification_tag_sds-options-and-settings'];
global $custom_verification_code;
$custom_verification_code = $redux['custom_verification_code_sds-options-and-settings'];

if ($enable_custom_verification == 1 && !empty($custom_verification_code)) {

    function SDStudio_add_custom_verification_meta() {
        global $custom_verification_code;

        // Базова санітизація, зберігаючи HTML теги
        $code = wp_kses($custom_verification_code, [
            'meta' => [
                'name' => [],
                'content' => [],
                'property' => [],
            ]
        ]);

        echo "\n";
        ?>
        <!--   SDStudio Options and Setting - Custom Verification META     -->
        <?php echo $code."\n\n"; ?>
        <?php
    }
    add_action('wp_head', 'SDStudio_add_custom_verification_meta');
}
