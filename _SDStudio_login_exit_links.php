<?php

/**
 *
 * @_ВЫХОД_С_САЙТА
 *
 */
$redux = get_option( 'redux_sds_options_and_settings' );


global $sdstudio_url_login;
$sdstudio_url_login = $redux['login_redirects-login-page-posts-sds-options-and-settings'];
//dd($sdstudio_url_login);

global $sdstudio_url_exit;
$sdstudio_url_exit = $redux['login_redirects-exit-page-posts-sds-options-and-settings'];

//dd($sdstudio_url_exit);


/* Переадрисация при входе и выходе */

/**
 * Вход
 */
if (!empty($sdstudio_url_login)){
    add_filter( 'login_redirect', 'filter_function_name_sdstudio_login', 10, 3 );
}

function filter_function_name_sdstudio_login( $sdstudio_url_login, $requested_redirect_to, $user ){
    // filter...
    global $sdstudio_url_login;
    return $sdstudio_url_login;
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