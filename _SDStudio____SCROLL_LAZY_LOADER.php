<?php
/**
* REDUX - Захват опций темы
*/
$redux = get_option( 'redux_sds_options_and_settings' );

include_once(ABSPATH . 'wp-includes/pluggable.php');


    function SDStudio____SCROLL_LAZY_LOADER() {
        require_once plugin_dir_path( __FILE__ ) . '_SDStudio___Yandex.php';
        require_once plugin_dir_path( __FILE__ ) . '_SDStudio___Google_Tag.php';
        ?>

    <script type="text/javascript">
        /* SDStudio____SCROLL_LAZY_LOADER() */

        console.log('START SDStudio____SCROLL_LAZY_LOADER()')
        var fired = false;
        window.addEventListener('scroll', () => {
            if (fired === false) {
                fired = true;
                setTimeout(() => {
                    <?php
                    // =============================
                    // Здесь все эти тормознутые трекеры, чаты и прочая ересь,
                    // без которой жить не может отдел маркетинга, и которые
                    // дико бесят разработчиков, когда тот же маркетинг приходит
                    // с вопросом "почему сайт медленно грузится, нам гугл сказал"
                    // =============================
                    // Yandex Metric
                    if (function_exists('SDStudio_Add_Yandex_Metrik_If_User_Scroll')) {
                        echo SDStudio_Add_Yandex_Metrik_If_User_Scroll();
                    }
                    // Google Tag Manager Global Tag
                    if (function_exists('SDStudio_Add_GoogleTagManager_GlobalTag_If_User_Scroll')) {
                        echo SDStudio_Add_GoogleTagManager_GlobalTag_If_User_Scroll();
                    }
                    // =============================
                    ?>
                }, 1000)
            }
        });
        console.log('END SDStudio____SCROLL_LAZY_LOADER()');
    </script>
        <?php
    }
if ( !is_user_logged_in() ) {
    add_action( 'wp_head', 'SDStudio____SCROLL_LAZY_LOADER' );
//    add_action( 'admin_bar_menu', 'RunnerNoAdminSDStudio____SCROLL_LAZY_LOADER' );
}

