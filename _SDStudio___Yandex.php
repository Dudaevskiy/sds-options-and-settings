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


/**
 * Яндекс Метрика
 */
global $enable_yandex_metrik_scroll_load_sds_options_and_settings;
$enable_yandex_metrik_scroll_load_sds_options_and_settings = $redux['enable_yandex_metrik_scroll_load_sds-options-and-settings'];
global $CODE__enable_yandex_metrik_scroll_load_sds_options_and_settings;
$CODE__enable_yandex_metrik_scroll_load_sds_options_and_settings = $redux['CODE__enable_yandex_metrik_scroll_load_sds-options-and-settings'];
global $CUSTOM_LINK__enable_yandex_metrik_scroll_load_sds_options_and_settings;
$CUSTOM_LINK__enable_yandex_metrik_scroll_load_sds_options_and_settings = $redux['CUSTOM_LINK__enable_yandex_metrik_scroll_load_sds-options-and-settings'];



if ($enable_yandex_metrik_scroll_load_sds_options_and_settings == 1 ) {

    function SDStudio_Add_Yandex_Metrik_If_User_Scroll() {
        global $CODE__enable_yandex_metrik_scroll_load_sds_options_and_settings;
        global $CUSTOM_LINK__enable_yandex_metrik_scroll_load_sds_options_and_settings;
        if ($CUSTOM_LINK__enable_yandex_metrik_scroll_load_sds_options_and_settings == ''){
            $CUSTOM_LINK__enable_yandex_metrik_scroll_load_sds_options_and_settings = 'https://mc.yandex.ru/metrika/tag.js';
        }
        $YandexMetrikaCode = '';
        $YandexMetrikaCode .= '                    console.log(\'✅ Yandex Metrika подключена\');'."\n";
        $YandexMetrikaCode .= '                    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};'."\n";
        $YandexMetrikaCode .= '                    m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})'."\n";
        $YandexMetrikaCode .= '                    (window, document, "script", "'.$CUSTOM_LINK__enable_yandex_metrik_scroll_load_sds_options_and_settings.'", "ym");'."\n";
        $YandexMetrikaCode .=   "\n";
        $YandexMetrikaCode .= '                    ym('.$CODE__enable_yandex_metrik_scroll_load_sds_options_and_settings.', "init", {'."\n";
        $YandexMetrikaCode .= '                    clickmap:true,'."\n";
        $YandexMetrikaCode .= '                    trackLinks:true,'."\n";
        $YandexMetrikaCode .= '                    accurateTrackBounce:true'."\n";
        $YandexMetrikaCode .= '                    });'."\n";
        return $YandexMetrikaCode;
    }
//    add_action( 'wp_head', 'SDStudio_Add_Yandex_Metrik_If_User_Scroll' );

}