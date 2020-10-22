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

//    if (current_user_can( 'administrator' ) === false ) {
    if ( !is_user_logged_in()){
        function GoogleADS_ADD_header_metadata() {
            // Post object if needed
            // global $post;

            // Page conditional if needed
            // if( is_page() ){}
            global $CODE__enable_google_adsense_sds_options_and_settings;
            ?>
            <link rel="preload" href="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js" as="script">

            <script type="text/javascript">
                function downloadJSAtOnload() {

                    // var element = document.createElement("script");
                    // element.src = "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js";
                    // document.body.appendChild(element);

                    // document.addEventListener("DOMContentLoaded", function(){

                    var externalScript   = document.createElement("script");
                    externalScript.type  = "text/javascript";
                    // externalScript.setAttribute('async','async');
                    externalScript.setAttribute('defer','defer');
                    externalScript.src = "//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js";
                    document.getElementsByTagName('body')[0].appendChild(externalScript);

                    let lijuArr = document.querySelectorAll('.liju') || [];

                    // Вставляем дивы с классом advDiv после дивов с классом liju

                    for (let i = 0; i < lijuArr.length; i++) {
                        let advDiv = document.createElement('div');
                        advDiv.classList.add('advDiv');
                        lijuArr[i].after(advDiv);
                    }

                    // После загрузки страницы в дивы с классом advDiv вставляем <ins class... , и после каждого дива вставляем (adsbygoogle = window.adsbygoogle || []).push({});
                    document.addEventListener('DOMContentLoaded', function(){
                        let advArr = document.querySelectorAll('.advDiv') || [];

                        advArr.forEach(element => {
                            // element.innerHTML='<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2272238036927" data-ad-slot="43425234" data-ad-format="auto" data-full-width-responsive="true"></ins>';
                            element.innerHTML='<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-<?php echo $CODE__enable_google_adsense_sds_options_and_settings;?>" data-ad-format="auto" data-full-width-responsive="true"></ins>';
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        });

                    });


                }
                // downloadJSAtOnload();
                // document.addEventListener("DOMContentLoaded", function() {
                if (window.attachEvent) {
                    window.attachEvent('onload', downloadJSAtOnload());
                } else {
                    if (window.onload) {
                        var curronload = window.onload;
                        var newonload = function (evt) {
                            curronload(evt);
                            downloadJSAtOnload();
                        };
                        window.onload = newonload;
                    } else {
                        window.onload = downloadJSAtOnload();
                    }
                }
                console.log('Google ADS RUN');
                // });
                // }, 1500);
            </script>

            <?php
        }

        include_once(ABSPATH . 'wp-includes/pluggable.php');
//if ( !current_user_can( 'administrator' ) || !current_user_can( 'editor' )) {
        if ( !is_user_logged_in()) {
            add_action('wp_footer', 'GoogleADS_ADD_header_metadata');
//        add_action( 'wp_head', 'GoogleADS_ADD_header_metadata' );
        }

    }
}