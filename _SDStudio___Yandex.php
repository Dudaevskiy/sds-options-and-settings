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
        ?>
<script type="text/javascript">
    /* SDStudio_Add_Yandex_Metrik_If_User_Scroll() */
    var fired = false;
    window.addEventListener('scroll', () => {
        if (fired === false) {
            fired = true;
            setTimeout(() => {
                console.log('✅ Yandex Metrika подключена');
                <?php
                // Здесь все эти тормознутые трекеры, чаты и прочая ересь,
                // без которой жить не может отдел маркетинга, и которые
                // дико бесят разработчиков, когда тот же маркетинг приходит
                // с вопросом "почему сайт медленно грузится, нам гугл сказал"
                ?>
                (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                    m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
                (window, document, "script", "<?php echo $CUSTOM_LINK__enable_yandex_metrik_scroll_load_sds_options_and_settings;?>", "ym");

                ym(<?php echo $CODE__enable_yandex_metrik_scroll_load_sds_options_and_settings;?>, "init", {
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            }, 1000)
        }
    });
</script>
        <?php
    }
    add_action( 'wp_head', 'SDStudio_Add_Yandex_Metrik_If_User_Scroll' );

}