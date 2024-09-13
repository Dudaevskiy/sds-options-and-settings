<?php

/**
 *
 * @_ВЫХОД_С_САЙТА
 *
 */
global $redux;
$redux = get_option( 'redux_sds_options_and_settings' );


global $sdstudio_url_login;
$sdstudio_url_login = $redux['login_redirects-login-page-posts-sds-options-and-settings'];
//dd($sdstudio_url_login);

global $sdstudio_url_exit;
$sdstudio_url_exit = $redux['login_redirects-exit-page-posts-sds-options-and-settings'];

// Enable WP-RECALL
global $enable_wp_recall_options_sds_options_and_settings;
$enable_wp_recall_options_sds_options_and_settings = $redux['enable_wp_recall_options_sds-options-and-settings'];

$enable_wp_recall_options_disable_admin_panel_for_all_not_admin_sds_options_and_settings = $redux['enable_wp_recall_options_disable_admin_panel_for_all_not_admin_sds-options-and-settings'];

$enable_wp_recall_replace_wp_login_on_wprecallpage_sds_options_and_settings = $redux['enable_wp_recall_replace_wp_login_on_wprecallpage_sds-options-and-settings'];
//s($redux['enable_wp_recall_options_sds-options-and-settings']);
//s($redux['enable_wp_recall_options_disable_admin_panel_for_all_not_admin_sds-options-and-settings']);



// Включить перенаправление для не Admin и Editor
global $enable_redirect_login_for_not_admin_editor_sds_options_and_settings;
$enable_redirect_login_for_not_admin_editor_sds_options_and_settings = $redux['enable_redirect_login_for_not_admin_editor_sds-options-and-settings'];

// Включить перенаправление для не Admin и Editor - ссылка переадресации
global $login_redirects_not_admin_editor_exit_page_posts_sds_options_and_settings;
$login_redirects_not_admin_editor_exit_page_posts_sds_options_and_settings = $redux['login_redirects_not_admin_editor-exit-page-posts-sds-options-and-settings'];// Включить перенаправление для не Admin и Editor - ссылка переадресации


// Скрытие кнопки "Мой сайт" в самом левом углу админ бара для не зарегистрировавшихся пользователей
global $remove_left_admin_bar_button_sds_options_and_settings;
$remove_left_admin_bar_button_sds_options_and_settings = $redux['remove_left_admin_bar_button_sds-options-and-settings'];


/**
 * Роль текущего пользователя
 */
if(!function_exists('sdstudio_get_current_user_roles')){
    function sdstudio_get_current_user_roles() {
        if( is_user_logged_in() ) {
            $user = wp_get_current_user();
            $roles = ( array ) $user->roles;
            return $roles[0]; // This returns an array
            // Use this to return a single value
            // return $roles[0];
        } else {
            return array();
        }
    }
}
//dd(sdstudio_get_current_user_roles());





if ($enable_wp_recall_options_sds_options_and_settings == 0){

    /* Переадрисация при входе и выходе - СТАНДАРТ*/
    /**
     * Вход Admin and Editor
     */
    if (!empty($sdstudio_url_login)){
        add_filter( 'login_redirect', 'filter_function_name_sdstudio_login', 10, 3 );
    }

    function filter_function_name_sdstudio_login( $sdstudio_url_login, $requested_redirect_to, $user )
    {
        // filter...
//        if (!current_user_can('administrator') && !is_admin() || !current_user_can('editor')) {
        /**
         * Переадресация при входе
         * Если активна и опция для входа 'Переадрисация при входе' и 'Включить перенаправление для не Admin и Editor'
         */
        global $enable_redirect_login_for_not_admin_editor_sds_options_and_settings;
        global $login_redirects_not_admin_editor_exit_page_posts_sds_options_and_settings;
        global $sdstudio_url_login;

        if (!empty($sdstudio_url_login) && $enable_redirect_login_for_not_admin_editor_sds_options_and_settings == 1 && !empty($login_redirects_not_admin_editor_exit_page_posts_sds_options_and_settings)){
            if (current_user_can('administrator') || current_user_can('editor')) {
                // if login admin or editor

                return $sdstudio_url_login;
            } else {
                // if NOT login admin or editor
                return $login_redirects_not_admin_editor_exit_page_posts_sds_options_and_settings;
            }

        /**
         * Переадресация при входе
         * Если активна только опция для входа 'Переадрисация при входе'
         */
        } else {
            return $sdstudio_url_login;
        }

    }

    /**
     * Выход
     */
    if (!empty($sdstudio_url_exit)){
        add_action('wp_logout', 'wc_registration_redirect');
    }

    add_filter( 'logout_redirect', 'filter_function_name_sdstudio_exit', 10, 3 );
    function filter_function_name_sdstudio_exit( $sdstudio_url_exit, $requested_redirect_to, $user ){
        // filter...
        global $sdstudio_url_exit;
        return $sdstudio_url_exit;
    }
    // Выход при нажатии --НЕ-- СТАНДАРТНОЙ и --НЕ-- WP-RECALL кнопки выхода допустим в для моб. устройств
    add_action('check_admin_referer', 'logout_without_confirm_one', 10, 2);
    function logout_without_confirm_one($action, $result)
    {

        //Разрешить выход без подтверждения

        if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
            $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '/';
            $location = str_replace('&', '&', wp_logout_url($redirect_to));
            header("Location: $location");
            die;
        }
    }


    /***
     * Редиректы из консоли для не Админов и Редакторов сайта
     */
    $login_redirects_not_admin_editor_exit_page_posts_sds_options_and_settings = $redux['login_redirects_not_admin_editor-exit-page-posts-sds-options-and-settings'];
    if (isset($login_redirects_not_admin_editor_exit_page_posts_sds_options_and_settings) && isset($enable_redirect_login_for_not_admin_editor_sds_options_and_settings) && $enable_redirect_login_for_not_admin_editor_sds_options_and_settings == 1) {
//        dd(sdstudio_get_current_user_roles());

        if (current_user_can('administrator')){
            return false;
        }
        if (current_user_can('editor')) {
            return false;
        }
            add_action('admin_head', 'dcwd_require_weight_field');
            function dcwd_require_weight_field()
            {
                $screen = get_current_screen();
                $screen = $screen->base;
                if ($screen == "dashboard") {
                    global $login_redirects_not_admin_editor_exit_page_posts_sds_options_and_settings;
                    wp_redirect($login_redirects_not_admin_editor_exit_page_posts_sds_options_and_settings, 302);
                }
            }
//        }
    }

//    /***
//     * Редиректы с главной страницы для не Админов и Редакторов сайта
//     */
//    $redirect_on_main_page_not_admin_editor_sds_options_and_settings = $redux['redirect_on_main_page_not_admin_editor_sds-options-and-settings'];
////    dd($redirect_on_main_page_not_admin_editor_sds_options_and_settings);
//    if (!empty($redirect_on_main_page_not_admin_editor_sds_options_and_settings) && $enable_redirect_login_for_not_admin_editor_sds_options_and_settings == 1) {
////        dd(sdstudio_get_current_user_roles());
//        if (!current_user_can('administrator') || !current_user_can('editor')) {
//            add_action('admin_head', 'redirect_on_main_page_for_not_admin_editor',10);
//            function redirect_on_main_page_for_not_admin_editor()
//            {
//
//                if (is_front_page() && is_home()) {
//                    global $redux;
//
//                    wp_redirect($redux['redirect_on_main_page_not_admin_editor_sds-options-and-settings'], 302);
//                }
//            }
//        }
//    }



/**
 * WP-RECALL
 */
} elseif ($enable_wp_recall_options_sds_options_and_settings == 1) {
//    s('ENABLE');
    /* Вход - '/' */


    /* Переадрисация при входе и выходе */
    /*Выход - '/' */

    add_action('wp_logout', 'wc_registration_redirect');

    function wc_registration_redirect( $redirect_to) {
        wp_redirect( '/');
        exit();
    }

    // Выход при нажатии --НЕ-- СТАНДАРТНОЙ и --НЕ-- WP-RECALL кнопки выхода допустим в для моб. устройств
    add_action('check_admin_referer', 'logout_without_confirm', 10, 2);
    function logout_without_confirm($action, $result)
    {

        //Разрешить выход без подтверждения

        if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
            $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '/';
            $location = str_replace('&', '&', wp_logout_url($redirect_to));
            header("Location: $location");
            die;
        }
    }

    /**
     * ВХОД - Перенаправляем пользователя в зависимости от его роли
     */
    function my_login_redirect( $url, $request, $user ){
        if( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
            // Если вошел АДМИН - перенаправляем в админку
            if( $user->has_cap( 'administrator' ) ) {
                $url = admin_url();
                // Если вошел любой другой пользователь - перенаправляем в кабинет WP-RECALL
            } else {
                $url = home_url('/account');
            }
        }
        return $url;
    }
    add_filter('login_redirect', 'my_login_redirect', 10, 3 );

}


/**
 * Админ бар только для админа
 */
//if ($enable_wp_recall_options_disable_admin_panel_for_all_not_admin_sds_options_and_settings == 1 && $enable_wp_recall_options_sds_options_and_settings == 1){
if ($enable_wp_recall_options_disable_admin_panel_for_all_not_admin_sds_options_and_settings == 1){

    // АДМИНБАР - Деактивируем админбар для всех кроме администраторов
    add_action('after_setup_theme', 'remove_admin_bar');
    function remove_admin_bar() {
        if (!current_user_can('administrator') && !is_admin()) {
            show_admin_bar(false);
        }
    }

    // Запрет доступа к админке для всех кроме админа
    // http://qaru.site/questions/2303069/how-to-prevent-users-to-access-wp-admin-and-wp-loginphp

    function my_checkRole(){
        if( !( current_user_can( 'administrator' ) ) && !( defined('DOING_AJAX') && DOING_AJAX ) ){
            wp_redirect( site_url( 'restrict_user' ) );
            exit;
        }
    }
    add_action( 'admin_init', 'my_checkRole' );
}

if ($enable_wp_recall_replace_wp_login_on_wprecallpage_sds_options_and_settings == 1  && $enable_wp_recall_options_sds_options_and_settings == 1){
    // Заменяем страницу wp-login на свтраницу wp-recall
        add_action('init','custom_login');
    function custom_login(){
        global $pagenow;
        if( !is_user_logged_in() && 'wp-login.php' == $pagenow ) {
            wp_redirect('/account');
            exit();
        }
    }
}