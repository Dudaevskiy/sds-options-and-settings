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
 * Version:           2.2.16
 * Author:            Serhii Dudchenko
 * Author URI:        https://sdstudio.top
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sds-options-and-settings
 * Domain Path:       /languages

GitHub Plugin URI: https://github.com/Dudaevskiy/sds-options-and-settings
GitHub Branch: master

 *
 * GitHub Plugin URI: https://github.com/Dudaevskiy/sds-options-and-settings
 * GitHub Branch: master
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
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_ENABLE_UPLOAD_FILES.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_add_images_sizes.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_images_sizes.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_image_settings.php';
    require_once plugin_dir_path( __FILE__ ) . '_WORKER.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_FRONTEND_ELEMENTOR.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio___PUBLISH_POSTS.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_login_page.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_login_exit_links.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_hot_key_login.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_gallery_settings.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_SweetAlert2.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_SweetAlert2_CF7_messages.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_SweetAlert2_AddToAny_messages.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_ADMIN_disable_aggressive_update.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_ADMIN_active_sorted_data_publish.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_ADMIN_DISABLE_PLUGINS.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_CSS_Styles.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_arrows.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_code_edit_addons.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio_ADMIN_BAR.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio___Yandex.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio___MailRU.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio___Admitad.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio___Google_ADS.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio___Google_Tag.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio___JivoSite.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio____SCROLL_LAZY_LOADER.php';
    require_once plugin_dir_path( __FILE__ ) . '_SDStudio___SHORTCODES_AUTOGEN_PAGES.php';
}
run_sds_options_and_settings();







/**
 * SHORTCODES
 */
/**
 * Name: Bloginfo Shortcode
 * Description: Allows bloginfo() as a shortcode.
 * Author URI: http://gm.zoomlab.it
 *
 * https://wordpress.stackexchange.com/questions/173871/how-to-display-the-site-name-in-a-wordpress-page-or-post
 * [bloginfo info='name']
 */

add_shortcode('bloginfo', function($atts) {

    $atts = shortcode_atts(array('filter'=>'', 'info'=>''), $atts, 'bloginfo');

    if ($atts['info'] == 'link_site'){
        $home_url = get_bloginfo('home');
        $home_url_not_https = str_replace('https://','',$home_url);
        $home_title = str_replace('http://','',$home_url_not_https);
        $link = '<a href="'.$home_url.'">'.$home_title.'</a>';
        return $link;
    } else if ($atts['info'] == 'url_not_https'){

        $home_url = get_bloginfo('home');
        $home_url = str_replace('https://','',$home_url);
        $home_url = str_replace('http://','',$home_url);
        return $home_url;
    } else {
    $infos = array(
        'name', 'description',
        'wpurl', 'url', 'pingback_url',
        'description', 'url', 'description',
        'admin_email', 'charset', 'version', 'html_type', 'language',
        'atom_url', 'rdf_url','rss_url', 'rss2_url',
        'comments_atom_url', 'comments_rss2_url',
    );

    $filter = in_array(strtolower($atts['filter']), array('raw', 'display'), true)
        ? strtolower($atts['filter'])
        : 'display';

    $return = in_array($atts['info'], $infos, true) ? get_bloginfo($atts['info'], $filter) : '';
    return $return;
    }
});

//$dev = do_shortcode("[bloginfo info='name']"); // Заголовок
//$dev = do_shortcode("[bloginfo info='description']"); //Описание сайта
//$dev = do_shortcode("[bloginfo info='home']"); // https://exemple.club
//$dev = do_shortcode("[bloginfo info='url_not_https']"); //exemple.club
//$dev = do_shortcode("[bloginfo info='link_site']"); // "<a href="https://exemple.club">exemple.club</a>"

/**
 * [current_year]
 * @param $atts
 * @return false|string
 */
function sdstudio_current_year( $atts ){
    $date = getdate();
    return $date['year'];
}
add_shortcode( 'current_year', 'sdstudio_current_year' );

/*
#wpml_main_page - указываем ссылку на главную в зависимости от языка
https://bit.ly/3AQHdNf
 */
function lb_menu_anchors($items, $args) {
        foreach ($items as $key => $item) {
            global $sitepress;
            if ($sitepress){
                if ($item->url == "#wpml_main_page"){
                    $item->url = icl_get_home_url();
                    $item->title = '<i class="fa fa-home" aria-hidden="true"></i>';
                }
            }
        }
        return $items;
}

add_filter('wp_nav_menu_objects', 'lb_menu_anchors', 10, 2);