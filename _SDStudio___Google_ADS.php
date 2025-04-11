<?php
/**
 * REDUX - Захват опций темы
 */
$redux = get_option( 'redux_sds_options_and_settings' );

global $enable_google_adsense_sds_options_and_settings;
$enable_google_adsense_sds_options_and_settings = $redux['enable_google_adsense_sds-options-and-settings'];
global $CODE__enable_google_adsense_sds_options_and_settings;
$CODE__enable_google_adsense_sds_options_and_settings = $redux['CODE__enable_google_adsense_sds-options-and-settings'];


if ($enable_google_adsense_sds_options_and_settings == 1 && !empty($CODE__enable_google_adsense_sds_options_and_settings)) {

    if ( !is_user_logged_in()){
        function GoogleADS_ADD_header_metadata() {
            global $CODE__enable_google_adsense_sds_options_and_settings;
            ?>
            <script>
                // Lazy Load AdSense start
                var lazyadsense=!1;
                window.addEventListener("scroll",function(){
                    (0!=document.documentElement.scrollTop&&!1===lazyadsense||0!=document.body.scrollTop&&!1===lazyadsense)&&(!function(){
                        var e=document.createElement("script");
                        e.type="text/javascript",
                            e.async=!0,
                            e.crossorigin="anonymous",
                            e.src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-<?php echo $CODE__enable_google_adsense_sds_options_and_settings;?>";
                        var a=document.getElementsByTagName("script")[0];
                        a.parentNode.insertBefore(e,a);

                        // Сохраняем функциональность вставки рекламных дивов
                        document.addEventListener('DOMContentLoaded', function(){
                            let lijuArr = document.querySelectorAll('.liju') || [];

                            // Вставляем дивы с классом advDiv после дивов с классом liju
                            for (let i = 0; i < lijuArr.length; i++) {
                                let advDiv = document.createElement('div');
                                advDiv.classList.add('advDiv');
                                lijuArr[i].after(advDiv);
                            }

                            // После загрузки страницы в дивы с классом advDiv вставляем <ins class...
                            let advArr = document.querySelectorAll('.advDiv') || [];

                            advArr.forEach(element => {
                                element.innerHTML='<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-<?php echo $CODE__enable_google_adsense_sds_options_and_settings;?>" data-ad-format="auto" data-full-width-responsive="true"></ins>';
                                (adsbygoogle = window.adsbygoogle || []).push({});
                            });
                        });

                    }(),lazyadsense=!0)
                },!0);
                // Lazy Load AdSense end
            </script>
            <?php
        }

        include_once(ABSPATH . 'wp-includes/pluggable.php');
        if ( !is_user_logged_in()) {
            add_action('wp_footer', 'GoogleADS_ADD_header_metadata');
        }
    }
}