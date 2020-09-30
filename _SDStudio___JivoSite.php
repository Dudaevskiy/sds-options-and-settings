<?php
/**
 * REDUX - Захват опций темы
 */
$redux = get_option( 'redux_sds_options_and_settings' );

global $enable_jivosite_sds_options_and_settings;
$enable_jivosite_sds_options_and_settings = $redux['enable_jivosite_sds-options-and-settings'];
global $CODE_enable_jivosite_sds_options_and_settings;
$CODE_enable_jivosite_sds_options_and_settings = $redux['CODE_enable_jivosite_sds-options-and-settings'];

if ($enable_jivosite_sds_options_and_settings == 1 && !empty($enable_jivosite_sds_options_and_settings)) {

    if ( !is_user_logged_in()){
        function jivosite_ADD_script() {
            global $CODE_enable_jivosite_sds_options_and_settings;

            ?>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
					setTimeout(function(){
                    (function(){ document.jivositeloaded=0;var widget_id = '<?php echo $CODE_enable_jivosite_sds_options_and_settings;?>';var d=document;var w=window;function l(){var s = d.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}//эта строка обычная для кода JivoSite
                        function zy(){
                            //удаляем EventListeners
                            if(w.detachEvent){//поддержка IE8
                                w.detachEvent('onscroll',zy);
                                w.detachEvent('onmousemove',zy);
                                w.detachEvent('ontouchmove',zy);
                                w.detachEvent('onresize',zy);
                            }else {
                                w.removeEventListener("scroll", zy, false);
                                w.removeEventListener("mousemove", zy, false);
                                w.removeEventListener("touchmove", zy, false);
                                w.removeEventListener("resize", zy, false);
                            }
                            //запускаем функцию загрузки JivoSite
                            if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}
                            //Устанавливаем куку по которой отличаем первый и второй хит
                            var cookie_date = new Date ();
                            cookie_date.setTime ( cookie_date.getTime()+60*60*28*1000); //24 часа для Москвы
                            d.cookie = "JivoSiteLoaded=1;path=/;expires=" + cookie_date.toGMTString();
                        }
                        if (d.cookie.search ( 'JivoSiteLoaded' )<0){//проверяем, первый ли это визит на наш сайт, если да, то назначаем EventListeners на события прокрутки, изменения размера окна браузера и скроллинга на ПК и мобильных устройствах, для отложенной загрузке JivoSite.
                            if(w.attachEvent){// поддержка IE8
                                w.attachEvent('onscroll',zy);
                                w.attachEvent('onmousemove',zy);
                                w.attachEvent('ontouchmove',zy);
                                w.attachEvent('onresize',zy);
                            } else {
                                w.addEventListener("scroll", zy, {capture: false, passive: true});
                                w.addEventListener("mousemove", zy, {capture: false, passive: true});
                                w.addEventListener("touchmove", zy, {capture: false, passive: true});
                                w.addEventListener("resize", zy, {capture: false, passive: true});
                            }
                        } else {
                            zy();
                        }
                    })();
					}, 6000);
                });
            </script>

            <?php
        }

        include_once(ABSPATH . 'wp-includes/pluggable.php');
//if ( !current_user_can( 'administrator' ) || !current_user_can( 'editor' )) {
        if ( !is_user_logged_in()) {
            add_action('wp_footer', 'jivosite_ADD_script');
//        add_action( 'wp_head', 'GoogleADS_ADD_header_metadata' );
        }

    }
}
