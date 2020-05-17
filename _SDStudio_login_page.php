<?php
/**
 * Страница входа
 */


/**
 * REDUX - Захват опций темы
 */
$redux = get_option( 'redux_sds_options_and_settings' );

// URL - Logo
global $logo_login_page;
$logo_login_page = $redux['logo-login-page-posts-sds-options-and-settings']['url'];
//dd($logo_login_page);

// URL - Background
global $background_login_page;
$background_login_page = $redux['background-page-posts-sds-options-and-settings']['url'];
//dd($background_login_page);

//s($redux);

/**
 * --------------
 */

/* Кастомизированная страница входа в Wordpress */
if (!empty($logo_login_page)){
    add_action('login_head', 'sdstudio_login_page');
}
function sdstudio_login_page() {
    global $logo_login_page;
    global $background_login_page;

    $sdstudio_logo_signin = $logo_login_page;
    $sdstudio_background_signin = $background_login_page;
    ?>
    <style>
        /* Background WordPress Login Page */
        body.login {
            background: linear-gradient(rgb(255, 255, 255), rgba(255, 255, 255, 0.37)), transparent url('<?php echo $sdstudio_background_signin; ?>') center center/cover no-repeat fixed;
        }
        /* Logo */
        .login h1 a {
            /*		  background-image: url(/wp-content/uploads/2018/10/logo-1.png) !important;*/
            background-image: url(<?php echo $sdstudio_logo_signin; ?>) !important;
            background-size: 150px 150px !important;
            width: 150px !important;
            height: 150px;
            background-color: rgba(153, 152, 232, 0)white;
        }

    </style>
    <!-- Подключение jQuery -->
    <script type='text/javascript' src='/wp-includes/js/jquery/jquery.js'></script>
    <!-- JS код для страницы входа wp-admin - при клике по лого переходим на главную*/ -->
    <script>
        jQuery( document ).ready(function( $ ) {
            $('.login h1 a').on("click", function() {
                window.location.href='/';
                return false;
            });
        });
    </script>
    <?php
}