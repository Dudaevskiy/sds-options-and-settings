<?php
/**
 * REDUX - Захват опций темы
 */
global $redux;
$redux = get_option( 'redux_sds_options_and_settings' );


//Следующий код добавляет ссылку на библиотеку мультимедиа в раскрывающееся меню с именем сайта.
add_action( 'admin_bar_menu', 'add_link_to_admin_bar',999 );
function add_link_to_admin_bar($admin_bar) {
    $args = array(
        'parent' => 'site-name',
        'id'     => 'media-libray',
        'title'  => 'Media Library',
        'href'   => esc_url( admin_url( 'upload.php' ) ),
        'meta'   => false
    );
    $admin_bar->add_node( $args );
}
//Следующий код добавляет библиотеку мультимедиа и ссылку на плагины в раскрывающемся меню имени сайта.
add_action( 'admin_bar_menu', 'add_links_to_admin_bar',999 );

function add_links_to_admin_bar($admin_bar) {
    $args = array(
        'parent' => 'site-name',
        'id'     => 'media-libray',
        'title'  => '<span class="ab-icon dashicons-admin-media" style="float: left;display: contents;"></span>  Медиатека',
        'href'   => esc_url( admin_url( 'upload.php' ) ),
        'meta'   => false
    );
    $admin_bar->add_node( $args );

    $args = array(
        'parent' => 'site-name',
        'id'     => 'plugins',
        'title'  => '<span class="ab-icon dashicons-admin-plugins" style="float: left;display: contents;"></span> Плагины',
        'href'   => esc_url( admin_url( 'plugins.php' ) ),
        'meta'   => false
    );
    $admin_bar->add_node( $args );

    $args = array(
        'parent' => 'site-name',
        'id'     => 'drafts',
        'title'  => '<span class="ab-icon dashicons-media-default" style="float: left;display: contents;"></span> Черновики',
        'href'   => esc_url('/wp-admin/edit.php?post_status=draft&post_type=post' ),
        'meta'   => false
    );
    $admin_bar->add_node( $args );

    $args = array(
        'parent' => 'site-name',
        'id'     => 'future',
        'title'  => '<span class="ab-icon dashicons-calendar-alt" style="float: left;display: contents;"></span> Запланированные',
        'href'   => esc_url('/wp-admin/edit.php?post_status=future&post_type=post' ),
        'meta'   => false
    );
    $admin_bar->add_node( $args );
    //<div class="wp-menu-image dashicons-before dashicons-admin-media"><br></div>
}

/**********************************
 *  2020-05-25 правки админ бара
 *
 * https://heera.it/customize-admin-menu-bar-in-wordpress
 * https://gist.github.com/Pushplaybang/6198196
 **********************************/

/**
 * Удалить логотип WP и Пользователя
 */
add_action( 'wp_before_admin_bar_render', 'remove_the_logo' );
function remove_the_logo() {
    global $redux;
    global $wp_admin_bar;

//    /**
//     * Удаляем пункты меню плагинов для single
//     */
//    $wp_admin_bar->remove_node('rank-math');
//    $wp_admin_bar->remove_node('clearfy-menu');
//    $wp_admin_bar->remove_node('disqus');

    /**
     * Сменяем название сайта в дамин панели
     */
    if ($redux['enable_ADMINBAR_change_site_name_in_panel-sds-options-and-settings'] == 1) {
        if (!empty($redux['enable_ADMINBAR_change_site_name_in_panel_CUSTOM_NAME_SITE-sds-options-and-settings'])) {
            $newtitle = $redux['enable_ADMINBAR_change_site_name_in_panel_CUSTOM_NAME_SITE-sds-options-and-settings'];
        } else {
            $newtitle = 'Мой WordPress';
        }
        $wp_admin_bar->add_node(array(
            'id' => 'site-name',
            'title' => $newtitle,
        ));
    }
}

/**
 * Отключаем пункты в меню ПЛАГИНОВ
 */
if ($redux['enable_ADMINBAR_Remove_plugins_menu_items_in_single-sds-options-and-settings']){
    add_action( 'wp_before_admin_bar_render', 'ADMINBAR_Remove_plugins_menu_items_in_single_sds_options_and_settings' );
    function ADMINBAR_Remove_plugins_menu_items_in_single_sds_options_and_settings()
    {
        global $redux;
        global $wp_admin_bar;
        if (!is_single()){
            return;
        }

        if ($redux['enable_ADMINBAR_Remove_plugins_menu_items_Clearfy-sds-options-and-settings'] == 1){
            $wp_admin_bar->remove_node('clearfy-menu');
        }
        if ($redux['enable_ADMINBAR_Remove_plugins_menu_items_rank-math-sds-options-and-settings'] == 1){
            $wp_admin_bar->remove_node('rank-math');
        }
        if ($redux['enable_ADMINBAR_Remove_plugins_menu_items_disqus-sds-options-and-settings'] == 1){
            $wp_admin_bar->remove_node('disqus');
        }

    }
}

/**
 * Отключаем вывод логотипа WP в админ барре
 */
if ($redux['enable_ADMINBAR_Disable_logo_wp_in_adminbar-sds-options-and-settings'] == 1) {
    add_filter('admin_bar_menu', 'sdsrtudio_disable_wordpress_logo_in_adminbar', 25);
    function sdsrtudio_disable_wordpress_logo_in_adminbar($wp_admin_bar)
    {
        $wp_admin_bar->remove_menu('wp-logo');
    }
}

/**
 * Аккаунт
 */
if ($redux['enable_ADMINBAR_custom_user-sds-options-and-settings'] == 1){

    add_filter( 'admin_bar_menu', 'howdy_to_hello', 25 );
    function howdy_to_hello( $wp_admin_bar ) {
    //    vd($wp_admin_bar);
        $my_account = $wp_admin_bar->get_node('my-account');
        $newtitle = 'Аккаунт';
        $wp_admin_bar->add_node( array(
            'id' => 'my-account',
            'title' => $newtitle,
        ));

    }
}
