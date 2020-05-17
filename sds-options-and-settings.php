<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sdstudio.top
 * @since             2.0.1
 * @package           Sds_Options_And_Settings
 *
 * @wordpress-plugin
 * Plugin Name:       SDStudio addons, options and settings
 * Plugin URI:        https://techblog.sdstudio.top/blog
 * Description:       Set of useful additions, settings, improvements for your site from <a href="https://sdstudio.top"><strong>Serhii Dudchenko</strong></a>
 * Version:           2.1.6
 * Author:            Serhii Dudchenko
 * Author URI:        https://sdstudio.top
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sds-options-and-settings
 * Domain Path:       /languages
 */

/**
 * Имя и версия плагина
 */
if( !function_exists('get_plugin_data') ){
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}
add_action('admin_init', 'SDStudioPluginName_sds_options_and_settings' );
function SDStudioPluginName_sds_options_and_settings(){
    $data = get_plugin_data(__FILE__);
    return $data['Name']; // выведет название плагина
}
add_action('admin_init', 'SDStudioPluginVersion_sds_options_and_settings' );
function SDStudioPluginVersion_sds_options_and_settings(){
    $data = get_plugin_data(__FILE__);
    return  $data['Version']; // выведет название плагина
}


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SDS_OPTIONS_AND_SETTINGS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sds-options-and-settings-activator.php
 */
function activate_sds_options_and_settings() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sds-options-and-settings-activator.php';
	Sds_Options_And_Settings_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sds-options-and-settings-deactivator.php
 */
function deactivate_sds_options_and_settings() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sds-options-and-settings-deactivator.php';
	Sds_Options_And_Settings_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sds_options_and_settings' );
register_deactivation_hook( __FILE__, 'deactivate_sds_options_and_settings' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sds-options-and-settings.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sds_options_and_settings() {

	$plugin = new Sds_Options_And_Settings();
	$plugin->run();

    // Определяем ajax
    add_action( 'wp_enqueue_scripts', 'sdstudio_myajax_data', 99 );
    function sdstudio_myajax_data(){

        wp_localize_script('twentyfifteen-script', 'myajax',
            array(
                'sdstudio_wp_ajax_url' => admin_url('admin-ajax.php')
            )
        );

    }

    require_once plugin_dir_path( __FILE__ ) . '_Redux_Framework_Parser_POST_data.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_add_images_sizes.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_images_sizes.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_image_settings.php';
    require_once plugin_dir_path( __FILE__ ) . '_WORKER.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_login_page.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_login_exit_links.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_hot_key_login.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_gallery_settings.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_SweetAlert2.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_SweetAlert2_CF7_messages.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_SweetAlert2_AddToAny_messages.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_ADMIN_disable_aggressive_update.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_ADMIN_active_sorted_data_publish.php';
<<<<<<< HEAD
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_ADMIN_DISABLE_PLUGINS.php';
=======
>>>>>>> 640da323bce3989f6040a742d78e78ee5554147a
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_CSS_Styles.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_arrows.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_code_edit_addons.php';

}
run_sds_options_and_settings();





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
    //<div class="wp-menu-image dashicons-before dashicons-admin-media"><br></div>
}
<<<<<<< HEAD
=======

/**
 * @param $buffer
 * @return string|string[]
 * Удаляем надоедливую ошибку wp-polyfill-fetch.min.js?ver=3.0.0
 */
function callback($buffer) {

    $buffer = str_replace('.png);">','.png.webp);">',$buffer);
    $buffer = str_replace('.jpg);">','.jpg.webp);">',$buffer);

    $SDStudio_cur_domain = $_SERVER['SERVER_NAME'];
    $fatch =  '( "fetch" in window ) || document.write( "<script src="https://'.$SDStudio_cur_domain.'/wp-includes/js/dist/vendor/wp-polyfill-fetch.min.js?ver=3.0.0"></scr" + "ipt>" );( document.contains ) || document.write( "<script src="https://'.$SDStudio_cur_domain.'/wp-includes/js/dist/vendor/wp-polyfill-node-contains.min.js?ver=3.42.0"></scr" + "ipt>" );( window.DOMRect ) || document.write( "<script src="https://'.$SDStudio_cur_domain.'/wp-includes/js/dist/vendor/wp-polyfill-dom-rect.min.js?ver=3.42.0"></scr" + "ipt>" );( window.URL && window.URL.prototype && window.URLSearchParams ) || document.write( "<script src="https://'.$SDStudio_cur_domain.'/wp-includes/js/dist/vendor/wp-polyfill-url.min.js?ver=3.6.4"></scr" + "ipt>" );( window.FormData && window.FormData.prototype.keys ) || document.write( "<script src="https://'.$SDStudio_cur_domain.'/wp-includes/js/dist/vendor/wp-polyfill-formdata.min.js?ver=3.0.12"></scr" + "ipt>" );( Element.prototype.matches && Element.prototype.closest ) || document.write( "<script src="https://'.$SDStudio_cur_domain.'/wp-includes/js/dist/vendor/wp-polyfill-element-closest.min.js?ver=2.0.2"></scr" + "ipt>" );';
    $buffer = str_replace($fatch,' ',$buffer);


//    $buffer = str_replace('.svg','.svg.webp',$buffer);
//    dd($buffer);
    return $buffer;
}

function buffer_start_two() { ob_start("callback"); }
function buffer_end_two() { ob_end_flush(); }

add_action('after_setup_theme', 'buffer_start_two');
add_action('shutdown', 'buffer_end_two');

// END


add_action('wp_head', 'my_custom_styles', 100);
function my_custom_styles()
{
    echo "<style>
            @font-face {
                    font-family: \"asppsicons2\";
                    font-display: swap !important;
                    font-weight: normal;
                    font-style: normal;
                    src: local('asppsicons2'), url('https://devtechblog.sdstudio.top/wp-content/plugins/ajax-search-pro/css/fonts/icons/icons2.woff2') format('woff2');
                    src: url('https://devtechblog.sdstudio.top/wp-content/plugins/ajax-search-pro/css/fonts/icons/icons2.eot');
                    src: url('https://devtechblog.sdstudio.top/wp-content/plugins/ajax-search-pro/css/fonts/icons/icons2.eot?#iefix') format('embedded-opentype'),
                    url('https://devtechblog.sdstudio.top/wp-content/plugins/ajax-search-pro/css/fonts/icons/icons2.woff2') format('woff2'),
                    url('https://devtechblog.sdstudio.top/wp-content/plugins/ajax-search-pro/css/fonts/icons/icons2.woff') format('woff'),
                    url('https://devtechblog.sdstudio.top/wp-content/plugins/ajax-search-pro/css/fonts/icons/icons2.ttf') format('truetype'),
                    url('https://devtechblog.sdstudio.top/wp-content/plugins/ajax-search-pro/css/fonts/icons/icons2.svg#icons') format('svg');
                }
          </style>";

   echo "<link rel=\"preload\" href=\"https://devtechblog.sdstudio.top/wp-content/plugins/ajax-search-pro/css/fonts/icons/icons2.woff2\" as=\"font\" type=\"font/woff2\" crossorigin>";

}




//https://stackoverflow.com/questions/29722267/change-edit-my-profile-text-in-wp-admin/29723736#29723736
//add_action( "admin_bar_menu', function( $admin_bar ){
////    $profile = $admin_bar->get_node('edit-profile');
////    $profile->title = __('View / Edit My Profile');
////    $admin_bar->add_node($profile);
//
//    $profile = $admin_bar->get_node('1');
////    s($profile);
////    s( $admin_bar);
////    $profile->title = __('View / Edit My Profile');
////    $admin_bar->add_node($profile);
//});


//_is_githuber_markdown_enabled
//add_action('wp_insert_post', 'kg_set_default_custom_fields');

//function kg_set_default_custom_fields($post_id)
//{
//    if ( $_GET['post_type'] != 'post' ) {
//        add_post_meta($post_id, '_is_githuber_markdown_enabled', 'no', true);
//    }
//
//    return true;
//}

// https://wp-kama.ru/handbook/rest/basic/wp-api-js
// Включаем библиотеку WP API
//wp_enqueue_script( 'wp-api' );
>>>>>>> 640da323bce3989f6040a742d78e78ee5554147a
