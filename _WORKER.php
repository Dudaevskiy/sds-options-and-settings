<?php
//use sds_options_and_settings/includes
//Download and Insert a Remote Image File into the WordPress Media Library
//https://kellenmace.com/download-insert-remote-image-file-wordpress-media-library/
// Require the file that contains the KM_Download_Remote_Image class.
// Подключаем в основном файле 
// require_once plugin_dir_path( __FILE__ ) . '_WORKER.php';
// Заменяем sds-options-and-settings на свой слаг с -
// require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

// Путь в корень плагина
define( 'SDS_OPTIONS_AND_SETTINGS__PLUGIN_DIR' , plugin_dir_path(__FILE__) );
// URL плагина
define( 'SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL' , plugin_dir_url(__FILE__) );

// Название плагина
//$plugin_data = get_plugin_data( __FILE__ );
$plugin_name = SDStudioPluginName_sds_options_and_settings();
$plugin_version = SDStudioPluginVersion_sds_options_and_settings();

$plugin_name_title_menu = 'SDStudio options and settings';
$menu_icon = 'dashicons-admin-tools';

$MarkDownImageFolder_sds_options_and_settings = SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL.'_markdown/images/';

// Social URLs
$SDStudio_github_com = 'https://github.com/Dudaevskiy';
$SDStudio_facebook_com = 'https://www.facebook.com/WebSDStudio/';
$SDStudio_site = '//sdstudio.top/';
$SDStudio_linkedin_com = 'https://www.linkedin.com/public-profile/settings?trk=d_flagship3_profile_self_view_public_profile&lipi=urn%3Ali%3Apage%3Ad_flagship3_profile_self_edit_contact_info%3BhWD%2Fwa9lSmWLHB9H6SsiWA%3D%3D';





if ( !function_exists( 'run_prettify' ) && is_admin()){
	
	add_action( 'wp_enqueue_scripts', 'run_prettify' );
	
	function run_prettify(){
		wp_enqueue_script( 'run_prettify', 'https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js');
	}
}

if (!class_exists('Redux') && file_exists(plugin_dir_path(__FILE__) . 'wp-content/plugins/redux-framework/redux-core/framework.php')) {
//==========================================
//==========================================
// Подключаем Redux
    // Redux Framework
//    require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
    require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

    require_once plugin_dir_path( __FILE__ ) . '/wp-content/plugins/redux-framework/redux-core/framework.php';

    //require_once plugin_dir_path( __FILE__ ) . '/wp-content/plugins/redux-framework/redux-core/framework.php';

//Redux::setSection($opt_name__redux_sds_editor_tools, array(    'title' => esc_html__('Section title', 'yourtextdomain') ,    'id' => esc_html__('section-unique-id', ' yourtextdomain') ,    'icon' => 'icon-name',    'fields' => array()));

//==========================================
//==========================================
}
if ( ! class_exists( 'Redux' ) ) {
    return null;
}
//https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js
// Marcdown parser for php
// traditional markdown and parse full text
//$parser = new \cebe\markdown\Markdown();
$MarkdownParser = new \cebe\markdown\Markdown();
// Использование:
// $markdown = '## Привет';
// s($parser->parse($markdown));
//-----------------------------------------
// REMOVE DEMO and PROMO REDUX
// START
//-----------------------------------------
/**
 * Disable Redux Developer Mode dev_mode
 * https://asique.net/disable-redux-framework-developer-mode-dev_mode/
 * START
 */

if ( !function_exists( 'redux_disable_dev_mode_plugin' ) ) {

    function redux_disable_dev_mode_plugin( $redux ) {
        if ( $redux->args[ 'opt_name' ] != 'redux_demo' ) {
            $redux->args[ 'dev_mode' ] = false;
            $redux->args[ 'forced_dev_mode_off' ] = false;
        }
    }

    add_action( 'redux/construct', 'redux_disable_dev_mode_plugin' );
}

if ( !function_exists( 'gl_removeDemoModeLink' ) ) {
	function gl_removeDemoModeLink() {
		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_filter( 'plugin_row_meta', [ ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks' ], null, 2 );
		}
		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_action( 'admin_notices', [ ReduxFrameworkPlugin::get_instance(), 'admin_notices' ] );
		}
	}
	add_action( 'init', 'gl_removeDemoModeLink' );
}


/**
 * END
 * Disable Redux Developer Mode dev_mode
 */
add_action( 'redux/loaded', 'remove_demo' );


/**
 * Removes the demo link and the notice of integrated demo from the redux-framework plugin
 * https://forums.envato.com/t/how-to-remove-redux-framework-notice/62645/4
 * START
 */
if ( ! function_exists( 'remove_demo' ) ) {
    function remove_demo() {
        // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            remove_filter( 'plugin_row_meta', [
                ReduxFrameworkPlugin::instance(),
                'plugin_metalinks'
            ], null, 2 );

            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            remove_action( 'admin_notices', [ ReduxFrameworkPlugin::instance(), 'admin_notices' ] );
        }
    }
}
/**
 * END
 * Removes the demo link and the notice of integrated demo from the redux-framework plugin
 * https://forums.envato.com/t/how-to-remove-redux-framework-notice/62645/4
 */

/**
 * https://docs.reduxframework.com/core/the-basics/removing-demo-mode-and-notices/
 * START
 */
 if ( ! function_exists( 'removeDemoModeLink' ) ) {
	function removeDemoModeLink() { // Be sure to rename this function to something more unique
		if ( class_exists('ReduxFrameworkPlugin') ) {
			remove_filter( 'plugin_row_meta', [ ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'], null, 2 );
		}
		if ( class_exists('ReduxFrameworkPlugin') ) {
			remove_action('admin_notices', [ ReduxFrameworkPlugin::get_instance(), 'admin_notices' ] );
		}
	}
	add_action('init', 'removeDemoModeLink');
}
/**
 * END
 * https://docs.reduxframework.com/core/the-basics/removing-demo-mode-and-notices/
 */
Redux::disable_demo();
//-----------------------------------------
// END
// REMOVE DEMO and PROMO REDUX
//-----------------------------------------













// This is your option name where all the Redux data is stored.
/**
 * REDUX OPTION NAME
 */
$opt_name__redux_sds_options_and_settings = 'redux_sds_options_and_settings';
//Redux::init($opt_name__redux_sds_options_and_settings);


/**
 * GLOBAL ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: @link https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 */

/**
 * ---> BEGIN ARGUMENTS
 */

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = [
    // REQUIRED!!  Change these values as you need/desire.
    'opt_name'                  => $opt_name__redux_sds_options_and_settings,


	'ajax_save'                 => true,

    // Name that appears at the top of your panel.
//    'display_name'              => $theme->get( 'Name' ),
    'display_name'              => $plugin_name,

    // Version that appears at the top of your panel.
    'display_version'           => $plugin_version,

    // Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only).
    'menu_type'                 => 'menu',

    // Show the sections below the admin menu item or not.
    'allow_sub_menu'            => true,

    'menu_title'                => esc_html__( $plugin_name_title_menu, 'sds-options-and-settings' ),
//    'menu_title'                => esc_html__( 'SDStudio Updater Data Year Posts', 'sds-options-and-settings' ),
    'page_title'                => esc_html__( $plugin_name, 'sds-options-and-settings' ),
//    'page_title'                => esc_html__( 'SDStudio Updater Data Year Posts', 'sds-options-and-settings' ),

    // Specify a custom URL to an icon.
//    'menu_icon'                 => 'dashicons-welcome-widgets-menus',
    'menu_icon'                 => $menu_icon,

    // Use a asynchronous font on the front end or font string.
    'async_typography'          => true,

    // Disable this in case you want to create your own google fonts loader.
    'disable_google_fonts_link' => false,

    // Show the panel pages on the admin bar.
    'admin_bar'                 => false,

    // Choose an icon for the admin bar menu.
    'admin_bar_icon'            => $menu_icon,

    // Choose an priority for the admin bar menu.
    'admin_bar_priority'        => 50,

    // Set a different name for your global variable other than the opt_name.
    'global_variable'           => '',

    // Show the time the page took to load, etc.
    'dev_mode'                  => false,

    // Enable basic customizer support.
    'customizer'                => false,

    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_priority'             => null,

    // For a full list of options, visit: @link http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters.
    'page_parent'               => 'themes.php',

    // Permissions needed to access the options panel.
    'page_permissions'          => 'manage_options',


    // Force your panel to always open to a specific tab (by id).
    'last_tab'                  => '',

    // Icon displayed in the admin panel next to your menu_title.
    'page_icon'                 => 'icon-themes',

    // Page slug used to denote the panel.
    'page_slug'                 => 'sds-options-and-settings',

    // On load save the defaults to DB before user clicks save or not.
    'save_defaults'             => true,

    // If true, shows the default value next to each field that is not the default value.
    'default_show'              => false,

    // What to print by the field's title if the value shown is default. Suggested: *.
    'default_mark'              => '',

    // Shows the Import/Export panel when not used as a field.
    'show_import_export'        => true,

    // CAREFUL -> These options are for advanced use only.
    'transient_time'            => 60 * MINUTE_IN_SECONDS,

    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output.
    'output'                    => true,

    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head.
    'output_tag'                => true,

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'database'                  => '',

    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.
    'use_cdn'                   => true,
    'compiler'                  => true,

    // HINTS.
    'hints'                     => [
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => [
            'color'   => 'light',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ],
        'tip_position'  => [
            'my' => 'top left',
            'at' => 'bottom right',
        ],
        'tip_effect'    => [
            'show' => [
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'mouseover',
            ],
            'hide' => [
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'click mouseleave',
            ],
        ],
    ],
];

// ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
$args['admin_bar_links'][] = [
    'id'    => 'redux-docs',
    'href'  => '//docs.reduxframework.com/',
    'title' => esc_html__( 'Documentation', 'sds-options-and-settings' ),
];

$args['admin_bar_links'][] = [
    'id'    => 'redux-support',
    'href'  => '//github.com/ReduxFramework/redux-framework/issues',
    'title' => esc_html__( 'Support', 'sds-options-and-settings' ),
];

$args['admin_bar_links'][] = [
    'id'    => 'redux-extensions',
    'href'  => 'reduxframework.com/extensions',
    'title' => esc_html__( 'Extensions', 'sds-options-and-settings' ),
];

// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
// http://elusiveicons.com/icons/
$args['share_icons'][] = [
//    'url'   => 'https://github.com/Dudaevskiy',
    'url'   => $SDStudio_github_com,
    'title' => 'Visit us on GitHub',
    'target' => '_blank',
    'icon'  => 'el el-github',
];
$args['share_icons'][] = [
//    'url'   => 'https://www.facebook.com/WebSDStudio/',
    'url'   => $SDStudio_facebook_com,
    'title' => esc_html__( 'Like us on Facebook', 'sds-options-and-settings' ),
    'target' => '_blank',
    'icon'  => 'el el-facebook',
];
$args['share_icons'][] = [
//    'url'   => '//sdstudio.top/',
    'url'   => $SDStudio_site,
    'title' => esc_html__( 'Website', 'sds-options-and-settings' ),
    'target' => '_blank',
    'icon'  => 'el el-home',
];
$args['share_icons'][] = [
//    'url'   => 'https://www.linkedin.com/public-profile/settings?trk=d_flagship3_profile_self_view_public_profile&lipi=urn%3Ali%3Apage%3Ad_flagship3_profile_self_edit_contact_info%3BhWD%2Fwa9lSmWLHB9H6SsiWA%3D%3D',
    'url'   => $SDStudio_linkedin_com,
    'title' => esc_html__( 'FInd us on LinkedIn', 'sds-options-and-settings' ),
    'target' => '_blank',
    'icon'  => 'el el-linkedin',
];

// Panel Intro text -> before the form.
if ( ! isset( $args['global_variable'] ) || false !== $args['global_variable'] ) {
    if ( ! empty( $args['global_variable'] ) ) {
        $v = $args['global_variable'];
    } else {
        $v = str_replace( '-', '_', $args['opt_name'] );
    }
//    $args['intro_text'] = '<p>' . sprintf( __( 'Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: $s', 'sds-options-and-settings' ) . '</p>', '<strong>' . $v . '</strong>' );
} else {
//    $args['intro_text'] = '<p>' . esc_html__( 'This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.', 'sds-options-and-settings' ) . '</p>';
}

// Add content after the form.
//$args['footer_text'] = '<p>' . esc_html__( 'This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.', 'sds-options-and-settings' ) . '</p>';

Redux::set_args( $opt_name__redux_sds_options_and_settings, $args );

/*
 * ---> END ARGUMENTS
 */


/*
 *
 * ---> BEGIN SECTIONS
 *з-зю0з
 */

/* As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for. */

/* -> START Basic Fields. */

$kses_exceptions = [
    'a'      => [
        'href' => [],
    ],
    'strong' => [],
    'br'     => [],
];
// traditional markdown and parse full text
// $parser = new \cebe\markdown\Markdown();
// echo $MarkdownParser->parse($markdown);

// $FAQ = file_get_contents(dirname(__FILE__) . '/_markdown/FAQ.md');
$FAQ = $MarkdownParser->parse( file_get_contents(dirname(__FILE__) . '/_markdown/FAQ.md') );
$Hot_Keys = $MarkdownParser->parse( file_get_contents(dirname(__FILE__) . '/_markdown/Hot_Keys.md') );
$section = [
    'title' => __( 'FAQ', 'sds-options-and-settingssds-options-and-settings' ),
    'id'    => 'basic',
    'icon'  => 'el el-home',
		'fields' => [ 
		[
			'id'       => 'opt-raw',
			'type'     => 'raw',
			// 'title'    => __('Raw output', 'redux-framework-demo'),
			// 'subtitle' => __('Subtitle text goes here.', 'redux-framework-demo'),
			// 'desc'     => __('This is the description field for additional info.', 'redux-framework-demo'),
			// 'content'  => $MarkdownParser->parse( file_get_contents(dirname(__FILE__) . '/_markdown/FAQ.md') )
			'desc'  => $FAQ.$Hot_Keys
		],
		],
];

Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );

/**
 * UPDAE ALL POSTS
 * https://docs.redux.io/core-fields/gallery.html
 * START
 *********************************/

$section = [
    'title' => __( 'Страница входа', 'login-page-posts-sds-options-and-settings' ),
    'id'    => 'login_page_sds_options_and_settings',
    'subsection' => false,
    'desc'  => __( 'Настройте страницу входа на сайт. Здесь Вы можете указать логотип Вашего сайта, фоновое изображение', 'sds-options-and-settings' ),
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-play-circle',
    'fields' => [
        [
            //Link: https://docs.redux.io/core-fields/media.html
                'id'       => 'logo-login-page-posts-sds-options-and-settings',
                'type'     => 'media',
                'url'      => true,
                'title'    => __('Выберите логотип сайта', 'title-login-page-posts-sds-options-and-settings'),
                'desc'     => __('Нажмите на кнопку "Upload" для выбора изображения', 'desc-login-page-posts-sds-options-and-settings'),
                'subtitle' => __('', 'subtitle-login-page-posts-sds-options-and-settings'),
//                'default'  => array(
//                'url'=>'https://cdn.cacher.io/attachments/u/3aboiw1y8lm64/rFpFGFkRo8L94062hnUPRcXhqzd00jHS/500px-Wordpress-Logo.svg.png'
//            ),
        ],
        [
            //Link: https://docs.redux.io/core-fields/media.html
            'id'       => 'background-page-posts-sds-options-and-settings',
            'type'     => 'media',
            'url'      => true,
            'title'    => __('Выберите фоновое изображение', 'background-login-page-posts-sds-options-and-settings'),
            'desc'     => __('Нажмите на кнопку "Upload" для выбора изображения', 'background-desc-login-page-posts-sds-options-and-settings'),
            'subtitle' => __('', 'background-subtitle-login-page-posts-sds-options-and-settings'),
//            'default'  => array(
//                'url'=>'https://cdn.cacher.io/attachments/u/3aboiw1y8lm64/rFpFGFkRo8L94062hnUPRcXhqzd00jHS/500px-Wordpress-Logo.svg.png'
//            ),
        ],
    ],

];

Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );

/**
 * Переадрисация при входе и выходе
 */
$section = [
    'title' => __( 'Переадрисация при входе и выходе, фиксы WP-RECALL, настройки поиска и другие фиксы для кабинета', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'login_redirects_page_sds_options_and_settings',
    'subsection' => false,
    'desc'  => __( 'Укажите ссылки на которые будет происходить переход как при входе, так и при выходе с сайта', 'sds-options-and-settings' ),
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-return-key',
    'fields' => [
        [
            //Link: https://docs.redux.io/core-fields/media.html
            'id'       => 'login_redirects-login-page-posts-sds-options-and-settings',
            'title' => __( 'Переадрисация при входе', 'login_redirects_login-page-posts-sds-options-and-settings' ),
            'type' => 'text',
//            'data' => array(
//                'login_redirects-sds-options-and-settings-login-url',
//            ),
            'required' => array('enable_wp_recall_options_sds-options-and-settings', '=', 'false' ),
            'default'  => '',
        ],
            [
                //Link: https://docs.redux.io/core-fields/media.html
                'id'       => 'login_redirects-exit-page-posts-sds-options-and-settings',
                'title' => __( 'Переадрисация при выходе', 'login_redirects_exit-page-posts-sds-options-and-settings' ),
                'type' => 'text',
                'data' => 'login_redirects-sds-options-and-settings-exit-url',
//                'data' => array(
//    //                'login_redirects-sds-options-and-settings-login-url',
//                    'login_redirects-sds-options-and-settings-exit-url',
//                ),
                'required' => array('enable_wp_recall_options_sds-options-and-settings', '=', 'false' ),
                'default'  => '/',
    //            'default'  => array(
    //                'text'=>'https://cdn.cacher.io/attachments/u/3aboiw1y8lm64/rFpFGFkRo8L94062hnUPRcXhqzd00jHS/500px-Wordpress-Logo.svg.png'
    //            ),
            ],
        [
            //Link: https://docs.redux.io/core-fields/switch.html

            'id'       => 'enable_redirect_login_for_not_admin_editor_sds-options-and-settings',
            'type'     => 'switch',
            'title'    => __('Включить перенаправления для не Admin и Editor', 'redux-framework-demo'),
//            'subtitle' => __('', 'redux-framework-demo'),
            'desc'  => __( 'При активации, будет включена опция будет применено перенаправление для всех других пользователей кроме ролей Admin и Editor', 'sds-options-and-settings' ),
            'default'  => false,
        ],
            [
                'id'       => 'login_redirects_not_admin_editor-exit-page-posts-sds-options-and-settings',
                'title' => __( 'Переадрисация при входе для не администраторов и редакторов сайта', 'login_redirects_exit-page-posts-sds-options-and-settings' ),
                'type' => 'text',
                'required' => array('enable_redirect_login_for_not_admin_editor_sds-options-and-settings', '=', 'true' ),
            ],

            [
                'id'       => 'redirect_on_dashboard_not_admin_editor_sds-options-and-settings',
                'title' => __( 'Переадрисация из консоли сайта для не администраторов и редакторов сайта', 'login_redirects_exit-page-posts-sds-options-and-settings' ),
                'type' => 'text',
                'required' => array('enable_redirect_login_for_not_admin_editor_sds-options-and-settings', '=', 'true' ),
            ],

//            [
//                'id'       => 'redirect_on_main_page_not_admin_editor_sds-options-and-settings',
//                'title' => __( 'Переадрисация из главной страницы сайта для не администраторов и редакторов сайта', 'login_redirects_exit-page-posts-sds-options-and-settings' ),
//                'type' => 'text',
//                'required' => array('enable_redirect_login_for_not_admin_editor_sds-options-and-settings', '=', 'true' ),
//            ],


        /**
         * WP RECALL
         */
        [
            //Link: https://docs.redux.io/core-fields/switch.html

            'id'       => 'enable_wp_recall_options_sds-options-and-settings',
            'type'     => 'switch',
            'title'    => __('WP-RECALL Включить обработку вода и выхода для плагина', 'redux-framework-demo'),
//            'subtitle' => __('', 'redux-framework-demo'),
            'desc'  => __( 'При активации опции, будет включена опция входа и выхода для плагина WP-RECALL.', 'sds-options-and-settings' ),
            'default'  => false,
        ],

        [
            //Link: https://docs.redux.io/core-fields/switch.html

            'id'       => 'enable_wp_recall_replace_wp_login_on_wprecallpage_sds-options-and-settings',
            'type'     => 'switch',
            'title'    => __('WP-RECALL Заменить страницу wp-login на страницу wp-recall', 'redux-framework-demo'),
//            'subtitle' => __('', 'redux-framework-demo'),
            'desc'  => __( 'При активации опции, при попытке перейти на стандартную страницу входа wp-admin,wp-login. Будет происходить редирект на страницу авторизации плагина WP-RECALL - "/account"' ),
            'required' => array('enable_wp_recall_options_sds-options-and-settings', '=', 'true' ),
            'default'  => false,
        ],
    ],

];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );

/**
 * Admin bar
 */
$SDStudio_ADMIN_disable_aggressive_update = $Hot_Keys = $MarkdownParser->parse( file_get_contents(dirname(__FILE__) . '/_markdown/AdminSpeedUp.md') );
$section = [
    'title' => __( 'Admin bar - панель администратора ', 'ADMIN_disable_aggressive_update-sds-options-and-settings' ),
//    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'ADMIN_BAR_update_options_and_settings',
    'subsection' => false,
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-graph',
    'desc'  => 'Полезные дополнения для панели администратора',
//    'ajax_save' => false,
    'fields' => [




// Begin the section
        [
            'id' => 'enable_ADMINBAR_change_site-start',
            'type' => 'section',
            'title' => __('Сменить название сайта в админ панели', 'redux-framework-demo'),
            'subtitle' => __('Опция отключаеет стандартное отображение имени сайта в пункте меню админ панели. И включает кастомный вывод данного пункта меню и место стаандартного названия сайта будет по умолчанию отображаться "Мой WordPress" или же то название которое введено в пункте форме. Для включения установите переключатель в положение "On". По умолчанию опция включена.', 'redux-framework-demo'),
            'indent' => true
        ],

        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_ADMINBAR_change_site_name_in_panel-sds-options-and-settings',
            'type'     => 'switch',
            'title'    => __('Включить', 'redux-framework-demo'),
            'subtitle' => __('Для включения установите переключатель в положение "On". По умолчанию опция включена.', 'redux-framework-demo'),
//            'desc'  => $SDStudio_ADMIN_disable_aggressive_update,
//                'required' => array('enable_sweetalert2', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => true,
        ],

        'fields' => [
            'id' => 'enable_ADMINBAR_change_site_name_in_panel_CUSTOM_NAME_SITE-sds-options-and-settings',
            'title' => 'Введите имя сайта',
            'desc' => 'Данное имя сайта будет отображаться в админ панели сайта, в случае если имя не будет ввведно. Будет отображаться "Мой WordPress"',
            'type' => 'text',
            'placeholder' => 'My Mega Site',
            'required' => array('enable_ADMINBAR_change_site_name_in_panel-sds-options-and-settings', '=', 'true' ),
        ],

// End the section
        [
            'id'     => 'enable_ADMINBAR_change_site-end',
            'type'   => 'section',
            'indent' => false,
        ],


        /**
         * SITE NAME
         */
        /**
         * Скрытие всех пунктов меню под "Мой сайт" в самом левом углу админ бара для не зарегистрировавшихся пользователей
         */
        [
            //Link: https://docs.redux.io/core-fields/switch.html

            'id'       => 'remove_left_admin_bar_button_sds-options-and-settings',
            'type'     => 'switch',
            'title'    => __('Удаление всех ссылок в "Мой сайт" для не зарегистрировавшихся пользователей', 'redux-framework-demo'),
//            'subtitle' => __('', 'redux-framework-demo'),
            'required' => array('enable_wp_recall_options_disable_admin_panel_for_all_not_admin_sds-options-and-settings', '=', 'false' ),
            'desc'  => __( 'При активации, скрытие всех удаление всех ссылок под кнопкой "Мой сайт" в самом левом углу админ бара для не зарегистрировавшихся пользователей', 'sds-options-and-settings' ),
            'default'  => false,
        ],

        /**
         * Отключене админ панели
         */
        [
            //Link: https://docs.redux.io/core-fields/switch.html

            'id'       => 'enable_wp_recall_options_disable_admin_panel_for_all_not_admin_sds-options-and-settings',
            'type'     => 'switch',
            'title'    => __('Oтключить админ панель для всех кроме администратора', 'redux-framework-demo'),
//            'subtitle' => __('', 'redux-framework-demo'),
            'desc'  => __( 'При активации опции, будет отключена полоса дамин анели для всех кроме даминистратора системы' ),
//            'required' => array('enable_wp_recall_options_sds-options-and-settings', '=', 'true' ),
            'default'  => false,
        ],


        // Лого WP
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_ADMINBAR_Disable_logo_wp_in_adminbar-sds-options-and-settings',
            'type'     => 'switch',
            'title'    => __('Удалить из админ панели пункт с логотипом WordPress', 'redux-framework-demo'),
            'subtitle' => __('Опция отключаеет стандартное отображение самого первого пункта меню с логотипом WordPress. Для включения установите переключатель в положение "On". По умолчанию опция включена.', 'redux-framework-demo'),
            'default'  => true,
        ],
        // Профиль
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_ADMINBAR_custom_user-sds-options-and-settings',
            'type'     => 'switch',
            'title'    => __('Включить кастомный вывод профиля текущего пользователя - "Аккаунт"', 'redux-framework-demo'),
            'subtitle' => __('Опция отключаеет стандартное отображение самого крайнего пункта меню с профилем пользователя ( крайнее меню слева) И включает кастомный вывод данного пункта меню - что освобождает место на панели. Для включения установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
            'default'  => false,
        ],


        // Begin the section
        [
            'id' => 'ADMINBAR_Remove_plugins_menu_items_in_single-sfgtart-start',
            'type' => 'section',
            'title' => __('Отключение пунктов меню плагинов на записях и страницах сайта', 'redux-framework-demo'),
            'subtitle' => __('Опция отключаеет отображение пунктов меню которые были созданы плагинами установленными на сайт. По умолчанию опция выключена.', 'redux-framework-demo'),
            'indent' => true
        ],


        [
            'id' => 'enable_ADMINBAR_Remove_plugins_menu_items_in_single-sds-options-and-settings',
            'type' => 'switch',
            'title' => __('Включить отключение пунктов созданных плагинами', 'redux-framework-demo'),
            'subtitle' => __('По умолчанию опция выключена.', 'redux-framework-demo'),
            'indent' => true
        ],

        // Clearfy
        [
            'id' => 'enable_ADMINBAR_Remove_plugins_menu_items_Clearfy-sds-options-and-settings',
            'type' => 'switch',
            'title' => __('Clearfy - Отключить пункт в меню', 'redux-framework-demo'),
            'subtitle' => __('По умолчанию опция выключена.', 'redux-framework-demo'),
            'required' => array('enable_ADMINBAR_Remove_plugins_menu_items_in_single-sds-options-and-settings', '=', 'true' ),
            'indent' => true
        ],
        // Rank Math
        [
            'id' => 'enable_ADMINBAR_Remove_plugins_menu_items_rank-math-sds-options-and-settings',
            'type' => 'switch',
            'title' => __('Rank Math - Отключить пункт в меню', 'redux-framework-demo'),
            'subtitle' => __('По умолчанию опция выключена.', 'redux-framework-demo'),
            'required' => array('enable_ADMINBAR_Remove_plugins_menu_items_in_single-sds-options-and-settings', '=', 'true' ),
            'indent' => true
        ],
        // Disqus
        [
            'id' => 'enable_ADMINBAR_Remove_plugins_menu_items_disqus-sds-options-and-settings',
            'type' => 'switch',
            'title' => __('Disqus - Отключить пункт в меню', 'redux-framework-demo'),
            'subtitle' => __('По умолчанию опция выключена.', 'redux-framework-demo'),
            'required' => array('enable_ADMINBAR_Remove_plugins_menu_items_in_single-sds-options-and-settings', '=', 'true' ),
            'indent' => true
        ],


        // End the section
        [
            'id'     => 'ADMINBAR_Remove_plugins_menu_items_in_single-end',
            'type'   => 'section',
            'indent' => false,
        ],
    ],
];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );








/**
 * Горячие клавиши для входа
 */
$section = [
    'title' => __( 'Горячие клавиши для входа ', 'hot_key_for_login-page-posts-sds-options-and-settings' ),
//    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'hot_key_for_login_page_sds_options_and_settings',
    'subsection' => false,
    'desc'  => __( 'Настройки для входа в админку сайта по сочитанию горячих клавиш', 'sds-options-and-settings' ),
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-torso',
    'fields' => [
        [
            //Link: https://docs.redux.io/core-fields/switch.html

            'id'       => 'enable_hot_key_login-page-posts-sds-options-and-settings',
            'type'     => 'switch',
            'title'    => __('Включить вход на сайт по горячим клавишам?', 'redux-framework-demo'),
            'subtitle' => __('Включите вход на сайт при помощи горячих клавишь. Для этого установите переключатель в положение "On". По умолчанию опция включена.', 'redux-framework-demo'),
            'desc'  => __( 'При активации, появляется возможность переходить на страницу входа в админку при нажатии горячих клавиш Ctrl+Shift+1. Так же активируется скрипт для быстрого входа с мобильного телефона - для этого нужно нажать 5-6 раз (событие таб) по любой пустой области футера сайта, но только на главной странице.', 'sds-options-and-settings' ),
            'default'  => true,
        ],
        [
            //Link: https://docs.redux.io/core-fields/media.html
            'id'       => 'custom_url_login-page-posts-sds-options-and-settings',
            'title' => __( 'Кастомный URL входа.', 'hot_key_for_login_title-page-posts-sds-options-and-settings' ),
            'subtitle' => __('Укажите ссылку страницы входа, если она отличается от <code> /wp-admin</code>', 'redux-framework-demo'),
            'type' => 'text',
            'placeholder' => '/my-custom-login-page-link',
            'data' => 'custom_url_login-sds-options-and-settings-login-url',
//            'data' => array(
//                'custom_url_login-sds-options-and-settings-login-url',
//            ),
            'default'  => '',
        ],
    ],

];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );


///**
// * Активация загрузки файлов
// */
//$section = [
//    'title' => __( 'Загрузка файлов', 'sds-options-and-settings' ),
//    'id'    => 'enable_upload_other_mmi_types_files_sds_options_and_settings',
//    'subsection' => false,
//    'desc'  => __( '(активация загрузки ранее не разрешенных типов файлов)', 'sds-options-and-settings' ),
//    // Иконки брать здесь
//    // http://elusiveicons.com/icons/
//    'icon'  => 'el el-file-new',
//    'fields' => [
//        [
//            //Link: https://docs.redux.io/core-fields/switch.html
//
//            'id'       => 'svg_enable_upload_other_mmi_types_files_sds_options_and_settings',
//            'type'     => 'switch',
//            'title'    => __('SVG - Активировать загрузку файлов формата svg', 'sds-options-and-settings'),
//            'subtitle'    => '
//            Если после применения SVG не загружается, добавьте в начало SVG файла данную строку <pre><code>&lt;?xml version=&quot;1.0&quot; encoding=&quot;utf-8&quot;?&gt;</code></pre>
//            ',
//            'desc'     => __('После применения настройки, появится возможность загружать файлы формата SVG в медиатеку WordPress', 'sds-options-and-settings'),
//            'default'  => true,
//        ],
//    ],
//];
//Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );



/**
 * Настройки галереи и изображений
 */
$section = [
    'title' => __( 'Настройки вывода галерей и изображений ', 'gallery_settings-page-posts-sds-options-and-settings' ),
//    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'gallery_settings_sds_options_and_settings',
    'subsection' => false,
    'desc'  => __( 'Настройки связанные с отоборажением галерей, глобально во всем сайте', 'sds-options-and-settings' ),
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-picture',
    'fields' => [
        [
            //Link: https://docs.redux.io/core-fields/switch.html

            'id'       => 'enable_gallery_settings_opt-page-posts-sds-options-and-settings',
            'type'     => 'switch',
            'title'    => __('Включить обработку добалвения галерей плагином, на сайте?', 'redux-framework-demo'),
            'subtitle' => __('Включите обработку добавления галерей. Для этого установите переключатель в положение "On". По умолчанию опция включена.', 'redux-framework-demo'),
            'desc'     => __('После применения настройки, при добавлении галереи в контент автоматически будет выставлена опция  вставки по Вашему количеству колонок, с ссылкой на изображение и с эскизом по умолчанию  . ( По умолчанию 4 колонки)', 'redux-framework-demo'),
            'default'  => true,
        ],
        [
            //Link: https://docs.redux.io/core-fields/select.html
            'id'       => 'gallery_settings_opt-page-posts-sds-options-and-settings',
            'type'     => 'select',
            'title'    => __('Галерея - количество колонок изображений', 'redux-framework-demo'),
            'subtitle' => __('Выберите количество колонок в галерее изображений'),
            // Must provide key => value pairs for select options
            'options'  => array(
                '1' => '1 колонка',
                '2' => '2 колонки',
                '3' => '3 колонки',
                '4' => '4 колонки',
                '5' => '5 колонок',
                '6' => '6 колонок',
                '7' => '7 колонок',
                '8' => '8 колонок',
             ),
            'default'  => '4',
        ],
        [
            //Link: https://docs.redux.io/core-fields/switch.html

            'id'       => 'enable_image_link_paste_auto_sds-options-and-settings',
            'type'     => 'switch',
            'title'    => __('Вставлять изображения в контент при редактировании, с ссылкой на изображения по умолчанию?', 'redux-framework-demo'),
            'subtitle' => __('Отличная опция, после активации которой все изображения которые будут вставлены в любой контент сайта при редактировании. Будут вставляться с ссылкой на файл. Очень полезно для лайтбоксов. Для активации установите переключатель в положение "On". По умолчанию опция включена.', 'redux-framework-demo'),
            'desc'     => __('Опция включена по умолчанию', 'redux-framework-demo'),
            'default'  => true,
        ],

    ],

];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );

/**
 * Размеры изображений
 * 📌 2024-01-13 DiSABLE
 */

//$sdstudio_get_img_sizes = sdstudio_get_images_sizes();
//
//$section = [
//    'title' => __( 'Размеры зарегистрированных изображений + добавление размеров ', 'images_sizes-sds-options-and-settings' ),
////    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
//    'id'    => 'images_sizes_sds_options_and_settings',
//    'subsection' => false,
//    'desc'  => __( 'Здесь отображается список зарегистрированных на сайте эскизов изображений. Плюс можно активировать не достающие популярные варианты эскизов.', 'sds-options-and-settings' ),
//    // Иконки брать здесь
//    // http://elusiveicons.com/icons/
//    'icon'  => 'el el-picture',
////    'ajax_save' => false,
//        'fields' => [
//            [
//                //Link: https://docs.redux.io/core-fields/switch.html
//
//                'id'       => 'enable_sdstudio_300_200_sds-options-and-settings',
//                'type'     => 'switch',
//                'title'    => __('Включить эскизы 300*200', 'redux-framework-demo'),
//                'subtitle' => __('Включите дополнительный размер эскизов 300 ширина X 200 высота. Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
//                'desc' => '<br><br>',
//                'default'  => false,
////                'ajax_save' => false,
//
//            ],
//            [
//            // https://docs.redux.io/core-fields/info.html
//            'title' => __( 'Размеры зарегистрированных изображений', 'images_sizes-sds-options-and-settings' ),
//            'id'   => 'info_normal',
//            'type' => 'info',
//            'desc' => $sdstudio_get_img_sizes,
//            ]
//        ],
//        'ajax_save' => false,
//    ];
//Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );


/**
 * SweetAlert2
 */
$SweetAlert2 = $Hot_Keys = $MarkdownParser->parse( file_get_contents(dirname(__FILE__) . '/_markdown/SweetAlert2.md') );
$section = [
    'title' => __( 'SweetAlert2 ', 'SweetAlert2_sizes-sds-options-and-settings' ),
//    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'sweetalert2_sds_options_and_settings',
    'subsection' => false,
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-check',
    'desc'  => $SweetAlert2,
//    'ajax_save' => false,
        'fields' => [
            [
                //Link: https://docs.redux.io/core-fields/switch.html

                'id'       => 'enable_sweetalert2',
                'type'     => 'switch',
                'title'    => __('Включить SweetAlert2', 'redux-framework-demo'),
                'subtitle' => __('Включите дополнительный размер эскизов 300 ширина X 200 высота. Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
                'desc' => '<br>',
                'default'  => false,
            ],
                [
                    'id'       => 'addtoany_sds-options-and-settings',
                    'title'    => __('Дополнения с функционалом SweetAlert2', 'redux-framework-demo'),
                    'subtitle' => __('Дополнительные полезные настройки и опции реализованные благодаря SweetAlert2', 'redux-framework-demo'),
                    'type'     => 'section',
                    //https://docs.redux.io/core-fields/section.html
                    'indent' => true,
                    'required' => array('enable_sweetalert2', '=', 'true' ),
                ],

                            [
                                //Link: https://docs.redux.io/core-fields/switch.html
                                'id'       => 'enable_sweetalert2_CF7_allerts',
                                'type'     => 'switch',
                                'title'    => __('Включить оповещения SweetAlert при отправке форм Contact Form 7?', 'redux-framework-demo'),
                                'subtitle' => __('Включите дополнительный размер эскизов 300 ширина X 200 высота. Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
                                'required' => array('enable_sweetalert2', '=', 'true' ),
//                                'desc' => '<br><br>',
                                'default'  => false,
                            ],
                                [
                                        //Link: https://docs.redux.io/core-fields/editor.html
                                        'id'               => 'enable_sweetalert2_CF7_allerts_ERROR_title',
                                        'type'             => 'editor',
                                        'title'            => __('ERROR - Заголовок при ошибке отправки', 'redux-framework-demo'),
                                        'default'          => '[wpml_if lang = \'uk\']Помилка! [/wpml_if][wpml_if lang = \'ru\']Ошибка! [/wpml_if][wpml_if lang = \'en\']Error! [/wpml_if]',
                                        'args'   => array(
                                        'teeny'            => true,
                                        'textarea_rows'    => 10,
                                        ),
                                        'required' => array('enable_sweetalert2_CF7_allerts', '=', 'true' ),
                                ],
                                [
                                    //Link: https://docs.redux.io/core-fields/editor.html
                                    'id'               => 'enable_sweetalert2_CF7_allerts_OK_title',
                                    'type'             => 'editor',
                                    'title'            => __('OK - Заголовок при успешной отправке сообщения', 'redux-framework-demo'),
                                    'default'          => '[wpml_if lang = \'uk\']Дякуємо! [/wpml_if][wpml_if lang = \'ru\']Спасибо! [/wpml_if][wpml_if lang = \'en\']Thanks! [/wpml_if]',
                                    'args'   => array(
                                        'teeny'            => true,
                                        'textarea_rows'    => 10,
                                    ),
                                    // Условия
                                    'required' => array('enable_sweetalert2_CF7_allerts', '=', 'true' ),
                                ],

//                                [
//                                    //Link: https://docs.redux.io/core-fields/divide.html
//                                    'id'   =>'divider_1',
////                                    'desc' => __('This is the description field.', 'redux-framework-demo'),
//                                    'type' => 'divide',
//                                    // Условия
//                                    'required' => array('enable_sweetalert2_CF7_allerts', '=', 'true' ),
//                                ],

                                [
                                    //Link: https://docs.redux.io/core-fields/editor.html
                                    'id'               => 'enable_sweetalert2_CF7_allerts_ERROR_message',
                                    'type'             => 'editor',
                                    'title'            => __('ERROR - Сообщение при ошибке отправки', 'redux-framework-demo'),
                                    'default'          => '[wpml_if lang = \'uk\'] Помилка заповнення форми. Форма була заповнена не вірно, або ж не заповнена зовсім. Будь ласка, зверніть увагу на повідомлення під полями введення. [/wpml_if][wpml_if lang = \'ru\']Ошибка заполнения формы. Форма была заполнена не верно, или не заполнена вовсе. Пожалуйста, обратите внимание на сообщение под полями ввода. [/wpml_if][wpml_if lang = \'en\']Error filling out the form. The form was not filled out correctly, or not filled out at all. Please note the message below the input fields. [/wpml_if]',
                                    'args'   => array(
                                        'teeny'            => true,
                                        'textarea_rows'    => 10,
                                    ),
                                    'required' => array('enable_sweetalert2_CF7_allerts', '=', 'true' ),
                                ],
                                [
                                    //Link: https://docs.redux.io/core-fields/editor.html
                                    'id'               => 'enable_sweetalert2_CF7_allerts_OK_message',
                                    'type'             => 'editor',
                                    'title'            => __('OK - Сообщение при успешной отправке сообщения', 'redux-framework-demo'),
                                    'default'          => '[wpml_if lang = \'uk\'] Ваше повідомлення було нам надіслано. [/wpml_if][wpml_if lang = \'ru\']Спасибо за Ваше сообщение. Оно успешно отправлено.[/wpml_if][wpml_if lang = \'en\']Your message has been sent to us.[/wpml_if]',
                                    'args'   => array(
                                        'teeny'            => true,
                                        'textarea_rows'    => 10,
                                    ),
                                    // Условия
                                    'required' => array('enable_sweetalert2_CF7_allerts', '=', 'true' ),
                                ],

            /**
             * SweetAlert2 & AddToAny
             */

                        [
                            //Link: https://docs.redux.io/core-fields/switch.html
                            'id'       => 'enable_sweetalert2_for_AddToAny',
                            'type'     => 'switch',
                            'title'    => __('Включить шаринг в социальных сетях от AddToAny с отложенной загрузкой?', 'redux-framework-demo'),
                            'subtitle' => __('<a href="https://www.addtoany.com/buttons/for/website">AddToAny</a> это отличное решение для шаринга стриниц в социальных сетях. При активации данной опции по сути вы автоматически активируете опцию о которой я писал в <a href="https://techblog.sdstudio.top/blog/jquery-kak-zagruzit-knopki-addtoany-share-tolko-po-cliku"
target="_blank">данной статье</a>. <br><b>Внимание! лучше используйте не более 18 соц. сетей.</b> Просто выглядеть больше будет не очень.'),
            //                                'desc' => '<br><br>',
                            'default'  => false,
                            // Условия
                            'required' => array('enable_sweetalert2', '=', 'true' ),
                        ],

                            [
                                //Link: https://docs.redux.io/core-fields/editor.html
                                'id'               => 'enable_sweetalert2_for_AddToAny_title',
                                'type'             => 'editor',
                                'title'            => __('Заголовок - введите заголовок попап окна', 'redux-framework-demo'),
                                'default'          => '[wpml_if lang = \'uk\']Поширити сторінку [/wpml_if][wpml_if lang = \'ru\']Поделится страницей [/wpml_if][wpml_if lang = \'en\']Share this page[/wpml_if]',
                                'args'   => array(
                                    'teeny'            => true,
                                    'textarea_rows'    => 10,
                                ),
                                // Условия
                                'required' => array('enable_sweetalert2_for_AddToAny', '=', 'true' ),
                            ],
                            [
                                //Link: https://docs.redux.io/core-fields/switch.html
                                'id'       => 'enable_sweetalert2_for_AddToAny_add_other_social_btn',
                                'type'     => 'switch',
                                'title'    => __('Показать кнопку для выбора других социальных сетей?', 'redux-framework-demo'),
                                'subtitle' => __('Добавляет к кнопкам, кнопку для выбора других социальных сететй'),
                                //                                'desc' => '<br><br>',
                                'default'  => false,
                                // Условия
                                'required' => array('enable_sweetalert2_for_AddToAny', '=', 'true' ),
                            ],
                            [
                             //Link: https://docs.redux.io/core-fields/button-set.html
                                'id'       => 'enable_sweetalert2_for_AddToAny_activate_social',
                                'type'     => 'button_set',
                                'title'    => __('Активируйте нужные социальные сети', 'redux-framework-demo'),
                                'subtitle' => __('Не выбирайте более 15 соц. сетей (+ кнопка для доп. выбора). Просто выглядеть будет не очень.', 'redux-framework-demo'),
//                                'desc'     => __('This is the description field, again good for additional info.', 'redux-framework-demo'),
                                'multi'    => true,
                                //Must provide key => value pairs for options
                                'options' => array(
                                'a2a_facebook' => 'facebook',
                                'a2a_twitter' => 'twitter',
                                'a2a_whatsapp' => 'whatsapp',
                                'a2a_email' => 'Email',
                                'a2a_linkedin' => 'linkedin',
                                'a2a_telegram' => 'telegram',
                                'a2a_evernote' => 'evernote',
                                'a2a_skype' => 'skype',
                                'a2a_viber' => 'viber',
                                'a2a_trello' => 'trello',
                                'a2a_livejournal' => 'livejournal',
                                'facebook_messenger' => 'facebook messenger',
                                'a2a_tumblr' => 'tumblr',
                                'a2a_pocket' => 'pocket',
                                'a2a_pinterest' => 'pinterest',
                                'a2a_printfriendly' => 'printfriendly',
                                'razdelitel' => '   ⚫   ',
                                'a2a_button_copy_link' => 'copy link',
                                'a2a_button_pinboard' => 'pinboard',
                                'a2a_button_wordpress' => 'wordpress',
                                'a2a_button_google_classroom' => 'google classroom',
                                'a2a_button_flipboard' => 'flipboard',
                                'a2a_button_google_bookmarks' => 'google bookmarks',
                                'a2a_button_mail_ru' => 'mail.ru',
                                'a2a_button_livejournal' => 'livejournal',
                                'a2a_button_vk' => 'vk',
                            ),
                                'default' => array('2', '3'),
                                // Условия
                                'required' => array('enable_sweetalert2_for_AddToAny', '=', 'true' ),
                            ],
                                        [
                                'title' => 'Инструкция к применению',
                                'id'       => 'enable_sweetalert2_for_AddToAny_onfo',
                                'type' => 'info',
                                'desc' => 'Добавление кнопки в меню<p>Теперь добавим кноку в меню после клика на которую и будет подключен скрипт шаринга и отображено окно с кнопками AddToAny. Я использую тему "Cactus" и в моме случае для  title пункта меню можно назначить иконку, в Вашем же случае возможно назначение иконки должно происходить иначе.</p><p>Назначаем иконку:</p><pre data-initialized="true" data-gclp-id="0"><code class="hljs javascript">&lt;i <span class="hljs-class"><span class="hljs-keyword">class</span></span>=<span class="hljs-string">"fa fa-share-alt-square"</span> aria-hidden=<span class="hljs-string">"true"</span>&gt;<span class="xml"><span class="hljs-tag">&lt;/<span class="hljs-name">i</span>&gt;</span></span></code></pre><p>Назначаем класс для кнопки:</p><pre data-initialized="true" data-gclp-id="1"><code class="hljs">AddToAny_View</code></pre> <a href="https://techblog.sdstudio.top/blog/jquery-kak-zagruzit-knopki-addtoany-share-tolko-po-cliku#3-dobavlyaem-knopku-v-menyu" target="_blank">подробнее здесь</a>',
    //                            'full_width' => true,
                                'required' => array('enable_sweetalert2_for_AddToAny', '=', 'true' ),
                            ],
                    [
                        'id'     => 'section-end',
                        'type'   => 'section',
                        'indent' => false,
                        'desc' => '<br><br>',
                    ],



        ],

    ];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );




/**
 * Ускорение админки
 */
$SDStudio_ADMIN_disable_aggressive_update = $Hot_Keys = $MarkdownParser->parse( file_get_contents(dirname(__FILE__) . '/_markdown/AdminSpeedUp.md') );
$section = [
    'title' => __( 'Ускорение админки ', 'ADMIN_disable_aggressive_update-sds-options-and-settings' ),
//    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'ADMIN_disable_aggressive_update_options_and_settings',
    'subsection' => false,
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-graph',
    'desc'  => 'Разные полезности для работы и ускорения админки сайта',
//    'ajax_save' => false,
    'fields' => [
            [
                //Link: https://docs.redux.io/core-fields/switch.html
                'id'       => 'enable_ADMIN_disable_aggressive_update-sds-options-and-settings',
                'type'     => 'switch',
                'title'    => __('Отключить принудительную проверку обновлений?', 'redux-framework-demo'),
                'subtitle' => __('Опция отключаеет принудительную проверку новых версий WP, плагинов и темы в админке, чтобы она не тормозила, когда долго не заходил и зашел... Все проверки будут происходить незаметно через крон или при заходе на страницу: "Консоль > Обновления". Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
                'desc'  => $SDStudio_ADMIN_disable_aggressive_update,
//                'required' => array('enable_sweetalert2', '=', 'true' ),
    //                                'desc' => '<br><br>',
                'default'  => false,
            ],
            [
                //Link: https://docs.redux.io/core-fields/switch.html
                'id'       => 'enable_ADMIN_page_post_sorted-sds-options-and-settings',
                'type'     => 'switch',
                'title'    => __('Включить сортировку по дате публикации для записей и страниц?', 'redux-framework-demo'),
                'subtitle' => __('Опция активирует сортировку страниц и записей по дате публикации. Для удобства администрирования контента. Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
//                'desc'  => $SDStudio_ADMIN_disable_aggressive_update,
    //                'required' => array('enable_sweetalert2', '=', 'true' ),
                //                                'desc' => '<br><br>',
                'default'  => false,
            ],
            [
                //Link: https://docs.redux.io/core-fields/switch.html
                'id'       => 'enable_DISABLE_FOR_ADMIN_highlight-and-share_sds-options-and-settings',
                'type'     => 'switch',
                'title'    => __('Отключить плагин Highlight and share для администратора', 'redux-framework-demo'),
                'subtitle' => __('Опция отключает плагиин highlight-and-share в случае если на сайт вошел администратор. В случае если на сайте НЕ администратор, плагин highlight-and-share будет активен. Для удобства администрирования контента. Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
    //                'desc'  => $SDStudio_ADMIN_disable_aggressive_update,
                //                'required' => array('enable_sweetalert2', '=', 'true' ),
                //                                'desc' => '<br><br>',
                'default'  => false,
            ],
            [
                //Link: https://docs.redux.io/core-fields/switch.html
                'id'       => 'enable_DISABLE_FOR_ADMIN_sem-external-links_sds-options-and-settings',
                'type'     => 'switch',
                'title'    => __('Отключить плагин External links для администратора', 'redux-framework-demo'),
                'subtitle' => __('Опция отключает плагиин External links в случае если на сайт вошел администратор. В случае если на сайте НЕ администратор, плагин External links будет активен. Для удобства администрирования контента. Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
                //                'desc'  => $SDStudio_ADMIN_disable_aggressive_update,
                //                'required' => array('enable_sweetalert2', '=', 'true' ),
                //                                'desc' => '<br><br>',
                'default'  => false,
            ],
        ],
    ];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );

/**
 * CSS - Дополнительное оформление
 */
$SDStudio_CSS_table_styles = $Hot_Keys = $MarkdownParser->parse( file_get_contents(dirname(__FILE__) . '/_markdown/CSS_table_styles.md') );
$section = [
    'title' => __( 'CSS - Дополнительное оформление ', 'CSS_add_design-sds-options-and-settings' ),
//    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'CSS_add_design_sds-options_and_settings',
    'subsection' => false,
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-css',
    'desc'  => 'Примените дополнительные стили, что бы украсить Ваш сайт',
//    'ajax_save' => false,
    'fields' => [
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_table_CSS_add_design-sds-options-and-settings',
            'type'     => 'switch',
            'title'    => __('Применить улучшенное отображение таблиц?', 'redux-framework-demo'),
            'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
//            'desc'  => $SDStudio_CSS_table_styles,
//                'required' => array('enable_table_CSS_add_design-sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'info_table_CSS_add_design-sds-options-and-settings',
            'type'     => 'info',
//            'title'    => __('Применить улучшенное отображение таблиц?', 'redux-framework-demo'),
//            'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
            'desc'  => $SDStudio_CSS_table_styles,
            'required' => array('enable_table_CSS_add_design-sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
//            'default'  => false,
        ],
    ],
];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );






/**
 * Публикация записей
 */
//$SDStudio_CSS_table_styles = $Hot_Keys = $MarkdownParser->parse( file_get_contents(dirname(__FILE__) . '/_markdown/CSS_table_styles.md') );
$section = [
    'title' => __( 'Публикация записей', 'publish_posts_sds-options-and-settings' ),
    'id'    => 'publish_posts_sds-options-and-settings',
    'subsection' => false,
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-pencil-alt',
    'desc'  => 'Настройки публикации записей на сайте',

    'fields' => [
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_disable_full_width_guthenberg_sds-options-and-settings',
            'type'     => 'switch',
            'icon'  => 'el el-chevron-right',
            'title'    => __('Отключить отображение во всю ширину в редакторе Gutenberg', 'redux-framework-demo'),
            'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция ВКЛЮЧЕНА.', 'redux-framework-demo'),
//            'desc'  => __('Активация опции добавляет в интерфейс сайта стралки для пред идущей и следующей записи', 'redux-framework-demo'),
//                'required' => array('enable_table_CSS_add_design-sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => true,
        ],
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_publish_posts_sds-options-and-settings',
            'type'     => 'switch',
            'icon'  => 'el el-chevron-right',
            'title'    => __('Активировать дополнительные настройки публикации записей', 'redux-framework-demo'),
            'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
//            'desc'  => __('Активация опции добавляет в интерфейс сайта стралки для пред идущей и следующей записи', 'redux-framework-demo'),
//                'required' => array('enable_table_CSS_add_design-sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
            [
                //Link: https://docs.redux.io/core-fields/switch.html
                'id'       => 'publish_posts_only_select_users_enable_publish_posts_sds-options-and-settings',
                'type'     => 'switch',
                'icon'  => 'el el-chevron-right',
                'title'    => __('Разрешить публикацю записей только выбранным пользователям', 'redux-framework-demo'),
                'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
    //            'desc'  => __('Активация опции добавляет в интерфейс сайта стралки для пред идущей и следующей записи', 'redux-framework-demo'),
                    'required' => array('enable_publish_posts_sds-options-and-settings', '=', 'true' ),
                //                                'desc' => '<br><br>',
                'default'  => false,
            ],
            [
                //Link: https://docs.redux.io/core-fields/switch.html
                'id'       => 'email_users_publish_posts_only_select_users_enable_publish_posts_sds-options-and-settings',
                'type'     => 'text',
                'icon'  => 'el el-chevron-right',
                'title'    => __('Укажите email пользователей которым разрешена публикация записей, через запятую', 'redux-framework-demo'),
//                'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
                //            'desc'  => __('Активация опции добавляет в интерфейс сайта стралки для пред идущей и следующей записи', 'redux-framework-demo'),
                'required' => array('publish_posts_only_select_users_enable_publish_posts_sds-options-and-settings', '=', 'true' ),
                //                                'desc' => '<br><br>',
                'default'  => false,
            ],
            [
                //Link: https://docs.redux.io/core-fields/switch.html
                'id'       => 'not_publish_posts_if_not_thumb_image_sds-options-and-settings',
                'type'     => 'switch',
                'icon'  => 'el el-chevron-right',
                'title'    => __('Не публиковать записи и страницы если не установлены обложки', 'redux-framework-demo'),
                'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
                //            'desc'  => __('Активация опции добавляет в интерфейс сайта стралки для пред идущей и следующей записи', 'redux-framework-demo'),
                'required' => array('enable_publish_posts_sds-options-and-settings', '=', 'true' ),
                //                                'desc' => '<br><br>',
                'default'  => false,
            ],
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_editposts_relfollow_posts_sds-options-and-settings',
            'type'     => 'switch',
            'icon'  => 'el el-chevron-right',
            'title'    => __('Активировать rel="follow" для редактора ссылок в классическом редакторе', 'redux-framework-demo'),
            'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
            'default'  => true,
        ],
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_editposts_rankmatch_keywords_posts_sds-options-and-settings',
            'type'     => 'switch',
            'icon'  => 'el el-chevron-right',
            'title'    => __('Активировать Rank Match ключевые слова для отображения в мета полях записей', 'redux-framework-demo'),
            'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
            'default'  => false,
        ],
    ],
];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );


/**
 * Элементы интерфейса
 */
//$SDStudio_CSS_table_styles = $Hot_Keys = $MarkdownParser->parse( file_get_contents(dirname(__FILE__) . '/_markdown/CSS_table_styles.md') );
$section = [
    'title' => __( 'Элементы интерфейса', 'arrows_pages_sds-options-and-settings' ),
//    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'info_arrows_pages_sds-options-and-settings',
    'subsection' => false,
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-chevron-right',
    'desc'  => 'Дополнительные элементы интерфейса для сайта',
//    'ajax_save' => false,
    'fields' => [
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_arrows_pages_sds-options-and-settings',
            'type'     => 'switch',
            'icon'  => 'el el-chevron-right',
            'title'    => __('Стрелки NEXT PREV для всех записей по краям экрана?', 'redux-framework-demo'),
            'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
            'desc'  => __('Активация опции добавляет в интерфейс сайта стралки для пред идущей и следующей записи', 'redux-framework-demo'),
//                'required' => array('enable_table_CSS_add_design-sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
            [
                //Link: https://docs.redux.io/core-fields/switch.html
                'id'       => 'enable_arrows_only_for_admin_pages_sds-options-and-settings',
                'type'     => 'switch',
                'icon'  => 'el el-chevron-right',
                'title'    => __('Включить только для администратора сайта?', 'redux-framework-demo'),
                'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
                'desc'  => __('Активация опции добавляет в интерфейс сайта стралки для пред идущей и следующей записи которые будут отображаться только для администратора сайта', 'redux-framework-demo'),
                    'required' => array('enable_arrows_pages_sds-options-and-settings', '=', 'true' ),
                //                                'desc' => '<br><br>',
                'default'  => false,
            ],


        // Elementor дополнения
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_elementor_frontend_addons_sds-options-and-settings',
            'type'     => 'switch',
            'icon'  => 'el el-chevron-right',
            'title'    => __('Elementor дополнительные динамические данные', 'redux-framework-demo'),
            'subtitle' => __('Для включения установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
            'desc'  => __('Активация опции добавляет в динамические данные виджетов плагина Elementor дополнительные данные для вывода (Счетчик просмотров страниц и записей, лайки страниц и записей и т.д.)', 'redux-framework-demo'),
//                'required' => array('enable_table_CSS_add_design-sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
            [
                //Link: https://docs.redux.io/core-fields/switch.html
                'id'       => 'enable_posts_counter_sds-options-and-settings',
                'type'     => 'switch',
                'icon'  => 'el el-chevron-right',
                'title'    => __('Отобразить счетчик просмотра поста', 'redux-framework-demo'),
                'subtitle' => __('Для включения установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
                'desc'  => __('Активация опции добавляет в динамические данные виджета вывод счетчика постов', 'redux-framework-demo'),
                'required' => array('enable_elementor_frontend_addons_sds-options-and-settings', '=', 'true' ),
                //                                'desc' => '<br><br>',
                'default'  => false,
            ],
            [
                //Link: https://docs.redux.io/core-fields/switch.html
                'id'       => 'enable_posts_like_raiteng_sds-options-and-settings',
                'type'     => 'switch',
                'icon'  => 'el el-chevron-right',
                'title'    => __('Отобразить счетчик ретинга поста', 'redux-framework-demo'),
                'subtitle' => __('Для включения установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
                'desc'  => __('Активация опции добавляет в динамические данные виджета вывод ретинга постов', 'redux-framework-demo'),
                'required' => array('enable_elementor_frontend_addons_sds-options-and-settings', '=', 'true' ),
                //                                'desc' => '<br><br>',
                'default'  => false,
            ],
            [
                //Link: https://docs.redux.io/core-fields/switch.html
                'id'       => 'enable_commets_count_posts_like_raiteng_sds-options-and-settings',
                'type'     => 'switch',
                'icon'  => 'el el-chevron-right',
                'title'    => __('Отобразить счетчик комментариев поста', 'redux-framework-demo'),
                'subtitle' => __('Для включения установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
                'desc'  => __('Активация опции добавляет в динамические данные виджета вывода счетчика комментариев поста', 'redux-framework-demo'),
                'required' => array('enable_elementor_frontend_addons_sds-options-and-settings', '=', 'true' ),
                //                                'desc' => '<br><br>',
                'default'  => false,
            ],

            [
                //Link: https://docs.redux.io/core-fields/switch.html
                'id'       => 'enable_time_reading_sds-options-and-settings',
                'type'     => 'switch',
                'icon'  => 'el el-chevron-right',
                'title'    => __('Отобразить время чтения записи', 'redux-framework-demo'),
                'subtitle' => __('Для включения установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
                'desc'  => __('Активация опции добавляет в динамические данные виджета вывода времени на чтение поста', 'redux-framework-demo'),
                'required' => array('enable_elementor_frontend_addons_sds-options-and-settings', '=', 'true' ),
                //                                'desc' => '<br><br>',
                'default'  => false,
            ],

            [
                //Link: https://docs.redux.io/core-fields/switch.html
                'id'       => 'enable_oput_sds-options-and-settings',
                'type'     => 'switch',
                'icon'  => 'el el-chevron-right',
                'title'    => __('Отобразить опыт работы', 'redux-framework-demo'),
                'subtitle' => __('Для включения установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
                'desc'  => __('Активация опции добавляет в динамические данные виджета вывода опыта. Для работы опции необходимо мета поле ', 'redux-framework-demo'),
                'required' => array('enable_elementor_frontend_addons_sds-options-and-settings', '=', 'true' ),
                //                                'desc' => '<br><br>',
                'default'  => false,
            ],
    ],
];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );

/**
 * Google Adsense
 */
//$SDStudio_CSS_table_styles = $Hot_Keys = $MarkdownParser->parse( file_get_contents(dirname(__FILE__) . '/_markdown/CSS_table_styles.md') );
$section = [
    'title' => __( 'Google Adsense', 'arrows_pages_sds-options-and-settings' ),
//    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'google_adsense_sds-options-and-settings',
    'subsection' => false,
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-view-mode',
    'desc'  => 'Активируем Google Adsense',
//    'ajax_save' => false,
    'fields' => [
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_google_adsense_sds-options-and-settings',
            'type'     => 'switch',
            'icon'  => 'el el-chevron-right',
            'title'    => __('Активировать код Google Adsense?', 'redux-framework-demo'),
//            'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
//            'desc'  => __('Активация опции добавляет в интерфейс сайта стралки для пред идущей и следующей записи', 'redux-framework-demo'),
//                'required' => array('enable_table_CSS_add_design-sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'CODE__enable_google_adsense_sds-options-and-settings',
            'type'     => 'text',
            'placeholder'  => 'XXXXXXXXXXXXXXXX',
            'title'    => __('Вставьте код (цифры из ca-pub-XXXXXXXXXXXXXXXX)', 'redux-framework-demo'),
            'subtitle'    => "
            Эталон для вставки:
            <code>
        <!--  Google ADS  -->
        div class=\"advDiv\">
           </code>
            ",
//            'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
            'desc'  => __('Активация опции добавляет в интерфейс сайта возможность подгрузки рекламных блоков Google ADSence после полной загрузки страницы. Рекламные блоки почти автоматически встраиваются на страницу. Обязательно на странице должен быть пустой div блок с классом  "advDiv"', 'redux-framework-demo'),
                'required' => array('enable_google_adsense_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
    ],
];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );



/**
 * Google Tag Manager - Global Tag
 */
$section = [
    'title' => __( 'Google Менеджер тегов (Global tag)', 'arrows_pages_sds-options-and-settings' ),
//    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'google_tag_manager_sds-options-and-settings',
    'subsection' => false,
    'icon'  => 'el el-view-mode',
    'desc'  => 'Активируем опции Google Менеджера тегов (Google Tag Manager)',
    'fields' => [
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_header_code_google_tag_manager_sds-options-and-settings',
            'type'     => 'switch',
            'icon'  => 'el el-chevron-right',
            'title'    => __('Установить Google Менеджер тегов на сайт?', 'redux-framework-demo'),
            'subtitle' => "Через секунду после того как пользователь начал скролить страницу, активирует глобальный тег Google Tag Manager",
//            'desc'  => raw("<pre><meta name=\"yandex-verification\" content=\"00017ddb0314e8c\" /></pre>"),
//                'required' => array('enable_table_CSS_add_design-sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'CODE_enable_google_tag_manager_code_sds-options-and-settings',
            'type'     => 'text',
            'icon'  => 'el el-chevron-right',
            'placeholder'  => 'G-XXXXXXXXXX',
            'title'    => __('Вставьте ИДЕНТИФИКАТОР ПОКАЗАТЕЛЯ (G-XXXXXXXXXX)', 'redux-framework-demo'),
            'subtitle' => 'Вставьте ИДЕНТИФИКАТОР ПОКАЗАТЕЛЯ из предоставленного Google кода отслеживания (G-XXXXXXXXXX)',
//            'desc'  => __('Активация опции добавляет в интерфейс сайта стралки для пред идущей и следующей записи', 'redux-framework-demo'),
            'required' => array('enable_header_code_google_tag_manager_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
    ],
];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );

/**
 * Yandex
 */
$section = [
    'title' => __( 'Yandex', 'arrows_pages_sds-options-and-settings' ),
//    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'yandex_sds-options-and-settings',
    'subsection' => false,
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-view-mode',
    'desc'  => 'Активируем опции Yandex',
//    'ajax_save' => false,
    'fields' => [
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_yandex_code_sds-options-and-settings',
            'type'     => 'switch',
            'icon'  => 'el el-chevron-right',
            'title'    => __('Активировать код отслеживания Yandex?', 'redux-framework-demo'),
            'subtitle' => "Добавляет в header страниц сайта код отслеживания Yandex",
//            'desc'  => raw("<pre><meta name=\"yandex-verification\" content=\"00017ddb0314e8c\" /></pre>"),
//                'required' => array('enable_table_CSS_add_design-sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'CODE__enable_yandex_code_sds-options-and-settings',
            'type'     => 'text',
            'icon'  => 'el el-chevron-right',
            'placeholder'  => '00000ddbf314e8cf',
            'title'    => __('Вставьте ID отслеживания', 'redux-framework-demo'),
            'subtitle' => 'Вставьте ID из предоставленного Yandex кода отслеживания из content="00000ddbf314e8cf" (В данном случае это 00000ddbf314e8cf )Вашего метатега Yandex',
//            'desc'  => __('Активация опции добавляет в интерфейс сайта стралки для пред идущей и следующей записи', 'redux-framework-demo'),
                'required' => array('enable_yandex_code_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
        // ======================================================
        // Источник:
        // https://bit.ly/3o0UAF7
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_yandex_metrik_scroll_load_sds-options-and-settings',
            'type'     => 'switch',
            'icon'  => 'el el-chevron-right',
            'title'    => __('Активировать Yandex Metrika после того как пользователь начал скролить?', 'redux-framework-demo'),
            'subtitle' => "Добавляет на сайт код отслеживания Yandex метрики только после того как пользователь начал скролить страницу. Самый оптимальный вариант что бы Google Page Speed остался доволен",
            'default'  => false,
        ],
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'CODE__enable_yandex_metrik_scroll_load_sds-options-and-settings',
            'type'     => 'text',
            'icon'  => 'el el-chevron-right',
            'placeholder'  => '32947777',
            'title'    => __('Вставьте ID отслеживания Яндекс Метрики', 'redux-framework-demo'),
            'subtitle' => 'Вставьте ID отслеживания Яндекс Метрики из предоставленного Yandex кода отслеживания, который находится в ссылке изображения - ..<img src="https://mc.yandex.ru/watch/32947777".. (В данном случае это 32947777 )',
//            'desc'  => __('Активация опции добавляет в интерфейс сайта стралки для пред идущей и следующей записи', 'redux-framework-demo'),
            'required' => array('enable_yandex_metrik_scroll_load_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'CUSTOM_LINK__enable_yandex_metrik_scroll_load_sds-options-and-settings',
            'type'     => 'text',
            'placeholder'  => 'https://cdn.jsdelivr.net/npm/yandex-metrika-watch/tag.js',
            'title'    => __('Применить альтернативный CDN для */metrika/tag.js', 'redux-framework-demo'),
            'subtitle' => 'Вставьте альтернативный CDN для файла */metrika/tag.js. В основном данная опция нужна если внушительная часть аудитории сайта находится в Украине, где Яндекс запрещен.',
            'desc'  => __('Внимание! Не трогайте данную опцию, и метрика будет подключена по стандартному линку - https://cdn.jsdelivr.net/npm/yandex-metrika-watch/tag.js! Водить альтернативный линк имеет смысл только в случае если Вы при генирации кода яндекс метрики применимли опцию "Альтернативный CDN".', 'redux-framework-demo'),
            'required' => array('enable_yandex_metrik_scroll_load_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
    ],
];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );

/**
 * Mail.ru поиск
 */
$section = [
    'title' => __( 'Mail.ru', 'arrows_pages_sds-options-and-settings' ),
//    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'mailru_tag_sds-options-and-settings',
    'subsection' => false,
    'icon'  => 'el el-view-mode',
    'desc'  => 'Активируем опции Mail.ru',
    'fields' => [
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_header_code_mailru_tag_sds-options-and-settings',
            'type'     => 'switch',
            'icon'  => 'el el-chevron-right',
            'title'    => __('Установить мета-тэг Mail.ru на сайт?', 'redux-framework-demo'),
            'subtitle' => "Добавляет на сайт мета тег Mail.ru верификации домена",
//            'desc'  => raw("<pre><meta name=\"yandex-verification\" content=\"00017ddb0314e8c\" /></pre>"),
//                'required' => array('enable_table_CSS_add_design-sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'CODE_enable_mailru_tag_sds-options-and-settings',
            'type'     => 'text',
            'icon'  => 'el el-chevron-right',
            'placeholder'  => 'c432e207c096f28492c87997xxxxxxxx',
            'title'    => __('Вставьте ИДЕНТИФИКАТОР верификации домена (c432e207c096f28492c87997xxxxxxxx)', 'redux-framework-demo'),
            'subtitle' => 'Вставьте ИДЕНТИФИКАТОР верификации который предоставлен Mail.ru из content="c432e207c096f28492c87997xxxxxxxx" ',
//            'desc'  => __('Активация опции добавляет в интерфейс сайта стралки для пред идущей и следующей записи', 'redux-framework-demo'),
            'required' => array('enable_header_code_mailru_tag_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
    ],
];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );


/**
/**
 * Jivosite
 */
//$SDStudio_CSS_table_styles = $Hot_Keys = $MarkdownParser->parse( file_get_contents(dirname(__FILE__) . '/_markdown/CSS_table_styles.md') );
//$image_this = $MarkDownImageFolder_sds_options_and_settings.'data-hendle.png';
//dd($image_this);
$section = [
    'title' => __( 'Jivosite', 'code_edit_sds-options-and-settings' ),
//    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'jivosite_sds-options-and-settings',
    'subsection' => false,
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-view-mode',
    'desc'  => 'Активация отложенной загрузки скриптов Jivosite',
//    'ajax_save' => false,
    'fields' => [
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_jivosite_sds-options-and-settings',
            'type'     => 'switch',
            'icon'  => 'el el-chevron-right',
            'title'    => __('Активировать отложенную загрузку Jivosite на сайте?', 'redux-framework-demo'),
            'subtitle' => "Активирует на сайте мега популярный чат JivoSite с отложенной загрузкой для увелечения скрости сайта",
//            'desc'  => raw("<pre><meta name=\"yandex-verification\" content=\"00017ddb0314e8c\" /></pre>"),
//                'required' => array('enable_table_CSS_add_design-sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'CODE_enable_jivosite_sds-options-and-settings',
            'type'     => 'text',
            'icon'  => 'el el-chevron-right',
            'placeholder'  => 'QTCtEFf9КЕ',
            'title'    => __('Вставьте widget_id JivoSite ( берем из кода выданного на сайте JS ..var widget_id = \'ВОТ ЗДЕСЬ КОД\')', 'redux-framework-demo'),
            'subtitle' => 'Вставьте ID из предоставленного Google Tag Manage кода отслеживания (GTM-XXXXXX)',
//            'desc'  => __('Активация опции добавляет в интерфейс сайта стралки для пред идущей и следующей записи', 'redux-framework-demo'),
            'required' => array('enable_jivosite_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
    ],
];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );



/**
 * Jivosite
 */
//$SDStudio_CSS_table_styles = $Hot_Keys = $MarkdownParser->parse( file_get_contents(dirname(__FILE__) . '/_markdown/CSS_table_styles.md') );
//$image_this = $MarkDownImageFolder_sds_options_and_settings.'data-hendle.png';
//dd($image_this);
$section = [
    'title' => __( 'Admitad', 'code_edit_sds-options-and-settings' ),
//    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'admitad_sds-options-and-settings',
    'subsection' => false,
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-view-mode',
    'desc'  => "Активирует на сайте все что нужно дял запуска Admited",

//    'ajax_save' => false,
    'fields' => [
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_admitad_sds-options-and-settings',
            'type'     => 'switch',
            'icon'  => 'el el-chevron-right',
            'title'    => __('Активировать мета тег подтверждения домена в Admitad на сайте?', 'redux-framework-demo'),
//            'subtitle' => "Активирует на сайте все что нужно дял запуска Admited",
//            'desc'  => raw("<pre><meta name=\"yandex-verification\" content=\"00017ddb0314e8c\" /></pre>"),
//                'required' => array('enable_table_CSS_add_design-sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'CODE_enable_admitad_sds-options-and-settings',
            'type'     => 'text',
            'icon'  => 'el el-chevron-right',
            'placeholder'  => 'b0ac4e6r11',
            'title'    => __('Вставьте атрибут "content" например "b0ac4e6r11"', 'redux-framework-demo'),
            'subtitle' => 'Вставьте ID из предоставленного берем из кода выданного на сайте мета тега <meta  name="verify-admitad" content="ВОТ-ЗДЕСЬ-ТО-ЧТО-НАМ-НУЖНО"',
//            'desc'  => __('Активация опции добавляет в интерфейс сайта стралки для пред идущей и следующей записи', 'redux-framework-demo'),
            'required' => array('enable_admitad_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
    ],
];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );


// ============================================================
// ============================================================
// ============================================================


/**
 * Отладка кода
 */
//$SDStudio_CSS_table_styles = $Hot_Keys = $MarkdownParser->parse( file_get_contents(dirname(__FILE__) . '/_markdown/CSS_table_styles.md') );
$image_this = $MarkDownImageFolder_sds_options_and_settings.'data-hendle.png';
//dd($image_this);
$section = [
    'title' => __( 'Отладка кода', 'code_edit_sds-options-and-settings' ),
//    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'info_code_edit_sds-options-and-settings',
    'subsection' => false,
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-w3c',
    'desc'  => 'Дополнительные настройки для отладки и работы с кодовой частью сайта',
//    'ajax_save' => false,
    'fields' => [
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_js_descript_code_edit_sds-options-and-settings',
            'type'     => 'switch',
            'title'    => __('Включить отображение дискрипторов скриптов на странице?', 'redux-framework-demo'),
            'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
            'default'  => false,
            //                                'desc' => '<br><br>',
//                'required' => array('enable_table_CSS_add_design-sds-options-and-settings', '=', 'true' ),
//            'desc'  => __('После применения опции, все ваши скрипты будут иметь data-handle атрибут, содержащий дескриптор скрипта, как показано на скриншоте ниже.', 'redux-framework-demo') ,
            'desc'  => 'После применения опции, все ваши скрипты будут иметь data-handle атрибут, содержащий дескриптор скрипта, как показано на скриншоте ниже. <br><img src="'.$image_this.'">'
        ],
    ],
];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );



/**
 * Авто генерация страниц "Отказ от ответственности", "Политика конфединциальности", "Контакты"
 */
//$SDStudio_CSS_table_styles = $Hot_Keys = $MarkdownParser->parse( file_get_contents(dirname(__FILE__) . '/_markdown/CSS_table_styles.md') );
//$image_this = $MarkDownImageFolder_sds_options_and_settings.'data-hendle.png';
//dd($image_this);
$section = [
    'title' => __( 'Авто генерация страниц', 'sds-options-and-settings' ),
//    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'auto_gen_pages_shortcodes_sds-options-and-settings',
    'subsection' => false,
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-file-edit',
    'desc'  => 'Авто генерация страниц "Отказ от ответственности", "Политика конфединциальности", "Контакты"',
    'fields' => [
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_auto_gen_pages_shortcodes_sds-options-and-settings',
            'type'     => 'switch',
            'title'    => __('Включить Авто генерацию страниц?', 'redux-framework-demo'),
            'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
            'default'  => false,
            'desc'  => 'После того как функция будет активирована на сайте появится возможность использования шорт кодов для автоматической генерации страниц <br>[SDStudio_PAGE_AUTOGEN page="OTKAZ"] - "Отказ от ответственности"<br>[SDStudio_PAGE_AUTOGEN page="KONF"] - "Политика конфединциальности"<br>[SDStudio_PAGE_AUTOGEN page="KONTACTS"] - "Контакты"<br>[SDStudio_PAGE_AUTOGEN page="HTML_SITEMAP"] - "HTML карта сайта"<br><hr>[SDStudio_PAGE_AUTOGEN page="FOOTER_OTKAZ"] - Шорт код для вставки в футер сайта. Содержащий текст отказа от ответственности и прочее<br>[SDStudio_PAGE_AUTOGEN page="FOOTER_COPY"] - Шорт код для вставки в футер сайта. Содержащий копирайт, год и "Все права защищены"<br>',
        ],

        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'email_auto_gen_pages_shortcodes_sds-options-and-settings',
            'type'     => 'text',
//            'icon'  => 'el el-chevron-right',
            'placeholder'  => 'info@domain.com',
            'title'    => __('Вставьте Email который будет указан в авто генерируемых страницах (если он отличается от текущего домена).', 'redux-framework-demo'),
            'subtitle' => '<b>Если Email не указан, будет использован адрес формата "info@ДОМЕН_ТЕКУЩЕГО_САЙТА"</b>',
//            'desc'  => __('Активация опции добавляет в интерфейс сайта стралки для пред идущей и следующей записи', 'redux-framework-demo'),
            'required' => array('enable_auto_gen_pages_shortcodes_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],

        /**
         * Линки на страницы
         */
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'OTKAZ_SLUG_auto_gen_pages_shortcodes_sds-options-and-settings',
            'type'     => 'text',
            'placeholder'  => '/otkaz_page_slug/',
            'title'    => __('Относительная ссылка - страницы для [SDStudio_PAGE_AUTOGEN page="OTKAZ"] шорткода', 'redux-framework-demo'),
            'subtitle'  => 'Для меню иcпользуйте:<br>%%sdstudio_autogen__OTKAZ_TITLE%%<br>%%sdstudio_autogen__OTKAZ_URL%%',
            'desc' => 'Вставьте относительную ссылку на страницу в которой вставлен шорт код. Ссылка на данную страницу будет отображена место `%%sdstudio_autogen__OTKAZ%%` (с учетом WPML переводов, но слаг у всех страницы переводов должен быть одинаковым)',
            'required' => array('enable_auto_gen_pages_shortcodes_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],

        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'KONF_SLUG_auto_gen_pages_shortcodes_sds-options-and-settings',
            'type'     => 'text',
            'placeholder'  => '/privacy-policy/',
            'title'    => __('Относительная ссылка - страницы для [SDStudio_PAGE_AUTOGEN page="KONF"] шорткода', 'redux-framework-demo'),
            'subtitle'  => 'Для меню иcпользуйте:<br>%%sdstudio_autogen__KONF_TITLE%%<br>%%sdstudio_autogen__KONF_URL%%',
            'desc' => 'Вставьте относительную ссылку на страницу в которой вставлен шорт код. Ссылка на данную страницу будет отображена место `%%sdstudio_autogen__KONF%%` (с учетом WPML переводов, но слаг у всех страницы переводов должен быть одинаковым)',
            'required' => array('enable_auto_gen_pages_shortcodes_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],

        [

            'id'       => 'KONTACTS_SLUG_auto_gen_pages_shortcodes_sds-options-and-settings',
            'type'     => 'text',
            'placeholder'  => '/contacts_page_slug/',
            'title'    => __('Относительная ссылка - страницы для [SDStudio_PAGE_AUTOGEN page="KONTACTS"] шорткода', 'redux-framework-demo'),
            'subtitle'  => 'Для меню иcпользуйте:<br>%%sdstudio_autogen__KONTACTS_TITLE%%<br>%%sdstudio_autogen__KONTACTS_URL%%',
            'desc' => 'Вставьте относительную ссылку на страницу в которой вставлен шорт код. Ссылка на данную страницу будет отображена место `%%sdstudio_autogen__KONTACTS%%` (с учетом WPML переводов, но слаг у всех страницы переводов должен быть одинаковым)',
            'required' => array('enable_auto_gen_pages_shortcodes_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],

        [

            'id'       => 'HTML_SITEMAP_SLUG_auto_gen_pages_shortcodes_sds-options-and-settings',
            'type'     => 'text',
            'placeholder'  => '/html_sitemap/',
            'title'    => __('Относительная ссылка - страницы для [SDStudio_PAGE_AUTOGEN page="HTML_SITEMAP"] шорткода', 'redux-framework-demo'),
            'subtitle'  => 'Для меню иcпользуйте:<br>%%sdstudio_autogen__HTML_SITEMAP_TITLE%%<br>%%sdstudio_autogen__HTML_SITEMAP_URL%%',
            'desc' => 'Вставьте относительную ссылку на страницу в которой вставлен шорт код. Ссылка на данную страницу будет отображена место `%%sdstudio_autogen__HTML_SITEMAP%%` (с учетом WPML переводов, но слаг у всех страницы переводов должен быть одинаковым)',
            'required' => array('enable_auto_gen_pages_shortcodes_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
        [

            'id'       => 'HTML_SITEMAP_SLUG_EXCLUDE_ID_POSTS__auto_gen_pages_shortcodes_sds-options-and-settings',
            'type'     => 'text',
            'placeholder'  => '156,123',
            'title'    => __('&nbsp;&nbsp;&nbsp;Укажите ID записей которые будут удалены из HTML карты сайта', 'redux-framework-demo'),
//            'subtitle'  => 'Для меню иcпользуйте:<br>%%sdstudio_autogen__HTML_SITEMAP_TITLE%%<br>%%sdstudio_autogen__HTML_SITEMAP_URL%%',
            'desc' => 'Здесь указываются через запятую ID записей которые будут исключены из вывода на странице HTML карты сайта. Достаточно указать ID на одном языке, остальные языковые версии постов так же будут скрыты',
            'required' => array('enable_auto_gen_pages_shortcodes_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
        [

            'id'       => 'HTML_SITEMAP_SLUG_EXCLUDE_ID_TERMS__auto_gen_pages_shortcodes_sds-options-and-settings',
            'type'     => 'text',
            'placeholder'  => '156,123',
            'title'    => __('&nbsp;&nbsp;&nbsp;Укажите ID категорий которые будут удалены из HTML карты сайта', 'redux-framework-demo'),
//            'subtitle'  => 'Для меню иcпользуйте:<br>%%sdstudio_autogen__HTML_SITEMAP_TITLE%%<br>%%sdstudio_autogen__HTML_SITEMAP_URL%%',
            'desc' => 'Здесь указываются через запятую ID категорий которые будут исключены из вывода на странице HTML карты сайта. Достаточно указать ID на одном языке, остальные языковые версии категорий так же будут скрыты',
            'required' => array('enable_auto_gen_pages_shortcodes_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
        [

            'id'       => 'FOOTER_SHORT__auto_gen_pages_shortcodes_sds-options-and-settings',
            'title'    => __('&nbsp;&nbsp;&nbsp;Укажите свой вариант краткого описания сайта для футера', 'redux-framework-demo'),
            'type'     => 'textarea',
            'placeholder'  => '© %%Y%% - %%SITE_TITLE%% | Всі права захищені.',
            'subtitle'  => 'Используется только в случае если необходимо ввести кастомное значение. По умолчание <pre><code>© %%Y%% - %%SITE_TITLE%% | Всі права захищені.<code></pre>',
//            'desc' => 'Здесь указываются через запятую ID категорий которые будут исключены из вывода на странице HTML карты сайта. Достаточно указать ID на одном языке, остальные языковые версии категорий так же будут скрыты',
            'required' => array('enable_auto_gen_pages_shortcodes_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
        [

            'id'       => 'FOOTER_OTKAZ__auto_gen_pages_shortcodes_sds-options-and-settings',
            'title'    => __('&nbsp;&nbsp;&nbsp;Укажите свой вариант копирайта в футере', 'redux-framework-demo'),
            'type'             => 'textarea',
            'args'   => array(
//                'teeny'            => true,
                'textarea_rows'    => 30,
            ),
//            'placeholder'  => '© %%Y%% - %%SITE_TITLE%% | Всі права захищені.',
            'subtitle'  => 'Используется только в случае если необходимо ввести кастомное значение. По умолчание <pre><code><p class = "rascrutie_footer"> ВІДМОВА ВІД ВІДПОВІДАЛЬНОСТІ І РОЗКРИТТЯ ІНФОРМАЦІЇ </p>
Вся інформація на сайті {{%THIS_SITE%}} носить виключно інформаційний характер. Ви особисто несете відповідальність за дотримання будь-яких відповідних місцевих або міжнародних законів. На сайті часто рекомендуються продукти, які ми вважаємо корисними для наших читачів. Ми можемо отримувати партнерську комісію від продажів продуктів, отриманих за партнерськими посиланнями.

** Сайт {{%THIS_SITE%}} ні за яких обставин не несе відповідальність за збитки, прямі або непрямі, які можуть виникнути в результаті використання, або неправильного використання, опублікованій тут інформації. Продовжуючи, ви підтверджуєте, що прочитали і прийняли нашу повну <u> [відмову від відповідальності](%%sdstudio_autogen__OTKAZ_URL%%)</u>, і нашу <u> [політику конфіденційності](%%sdstudio_autogen__KONF_URL%%)</u>. **</code></pre>',
//            'desc' => 'Здесь указываются через запятую ID категорий которые будут исключены из вывода на странице HTML карты сайта. Достаточно указать ID на одном языке, остальные языковые версии категорий так же будут скрыты',

            'required' => array('enable_auto_gen_pages_shortcodes_sds-options-and-settings', '=', 'true' ),
            //                                'desc' => '<br><br>',
            'default'  => false,
        ],
    ],
];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );





/**
 * Ускорение сайта
 */
//$SDStudio_CSS_table_styles = $Hot_Keys = $MarkdownParser->parse( file_get_contents(dirname(__FILE__) . '/_markdown/CSS_table_styles.md') );
//$image_this = $MarkDownImageFolder_sds_options_and_settings.'data-hendle.png';
//dd($image_this);
$section = [
    'title' => __( 'Ускорение сайта', 'sds-options-and-settings' ),
//    'title' => __( 'Переадрисация при входе и выходе ', 'login_redirects-page-posts-sds-options-and-settings' ),
    'id'    => 'pagespeed_sds-options-and-settings',
    'subsection' => false,
    // Иконки брать здесь
    // http://elusiveicons.com/icons/
    'icon'  => 'el el-fast-forward',
    'desc'  => 'Опции для ускорения работы сайта',
    'fields' => [
        [
            //Link: https://docs.redux.io/core-fields/switch.html
            'id'       => 'enable_js_inlineinpage_sds-options-and-settings',
            'type'     => 'switch',
            'title'    => __('Включить встраивание jQuery на страницах сайта?', 'redux-framework-demo'),
            'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
            'default'  => false,
            //                                'desc' => '<br><br>',
//                'required' => array('enable_table_CSS_add_design-sds-options-and-settings', '=', 'true' ),
//            'desc'  => __('После применения опции, все ваши скрипты будут иметь data-handle атрибут, содержащий дескриптор скрипта, как показано на скриншоте ниже.', 'redux-framework-demo') ,
        ],
//        [
//            //Link: https://docs.redux.io/core-fields/switch.html
//            'id'       => 'enable_webfonts_swap_sds-options-and-settings',
//            'type'     => 'switch',
//            'title'    => __('Включить swap для веб шрифтов?', 'redux-framework-demo'),
//            'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
//            'default'  => false,
//            //                                'desc' => '<br><br>',
//    //                'required' => array('enable_table_CSS_add_design-sds-options-and-settings', '=', 'true' ),
//    //            'desc'  => __('После применения опции, все ваши скрипты будут иметь data-handle атрибут, содержащий дескриптор скрипта, как показано на скриншоте ниже.', 'redux-framework-demo') ,
//        ],
//        [
//            //Link: https://docs.redux.io/core-fields/switch.html
//            'id'       => 'print_SWAP_bs_icons_SDStudio_swap_sds-options-and-settings',
//            'type'     => 'switch',
//            'title'    => __('PUBLISHER - Включить swap для веб шрифтов - bs_icons, FontAwesome?', 'redux-framework-demo'),
//            'subtitle' => __('Для этого установите переключатель в положение "On". По умолчанию опция выключена.', 'redux-framework-demo'),
//            'default'  => false,
//            'required' => array('enable_webfonts_swap_sds-options-and-settings', '=', 'true' ),
//        ],
    ],
];
Redux::set_section( $opt_name__redux_sds_options_and_settings, $section );

/**
 * Load my Google Adsense code.
 *
 * Here, your Google Adsense Code is contained directly in your function.
 */
include_once(ABSPATH . 'wp-includes/pluggable.php');
//|| current_user_can( 'editor' ) === false




/**
 * https://docs.reduxframework.com/core/advanced/actions-hooks/
 * Нужно разобраться с экшеном перезагрузки после сохранения опции добалвения эскиза 300X200
 */
//$SDStudio_otion_shange_opt = 'images_sizes_sds_options_and_settings';
//$SDStudio_otion_shange_opt_id = 'enable_sdstudio_300_200_sds-options-and-settings';
////$SDStudio_otion_shange = 'redux/options/'.$opt_name__redux_sds_options_and_settings.'/settings/enable_sdstudio_300_200_sds-options-and-settings/change';
//
//$SDStudio_otion_shange = 'redux/field/'.$opt_name__redux_sds_options_and_settings.'/'.$SDStudio_otion_shange_opt[$SDStudio_otion_shange_opt_id].'/callback/after';
////$SDStudio_otion_shange = 'redux/options/'.$SDStudio_otion_shange_opt.'/settings/change';
//add_action ($SDStudio_otion_shange, 'funstion_for_otion_shange_save_in_ajax');
//function funstion_for_otion_shange_save_in_ajax(){
//    header("refresh: 3;");
////    console.log('Привет, я аджакс');
//}






// Функция которая исполняется при сохранении настроек плагином
$MyOptionName_sds_options_and_settings = 'redux/options/'.$opt_name__redux_sds_options_and_settings.'/saved';
add_action ($MyOptionName_sds_options_and_settings, 'funstion_for_save_in_ajax');
function funstion_for_save_in_ajax(){

    /**
     * И получаем введенный год
     * За обработку POST['data'] отвечает 'sds-options-and-settings\_Redux_Framework_Parser_POST_data.php.
     *
     */
    $ReduxFramework_ParserPOSTdata = redux_parse_str( $_POST['data'] );
    // Распарсим настроки
    $REDUX_DATA_PARSER = $ReduxFramework_ParserPOSTdata['redux_sds_options_and_settings'];

    // Лого
    $logo_login_page = $REDUX_DATA_PARSER['logo-login-page-posts-sds-options-and-settings'];
     // Запишем в опции темы если не пусто
    if (!empty($logo_login_page)){
//        s($logo_login_page);


    }


//    global $SDStudio_year;
//    $SDStudio_year = $ReduxFramework_ParserPOSTdata['redux_sds_options_and_settings'];
//    $SDStudio_year = $SDStudio_year['opt-text-sds-options-and-settings'];
//
//    /**
//     * START
//     * SDStudio_import_post_status
//     * null_import
//     */
//    if (!empty($SDStudio_year)) {
//        function update_all_posts_year_in_data_publish()
//        {
//
//            global $SDStudio_year;
//
//            $args = [
//                'post_type' => 'post',
//                'post_status' => ['publish', 'draft','future'],
//                'tax_query' => array(
//                    'relation' => 'AND',
//                    array(
//                        'taxonomy' => 'sds_update_this_post_year',
//                        'field' => 'slug',
//                        'terms' => 'sdstudio_avtoobnovlenie_goda_da',
//                        'operator' => 'IN',
//                    ),
//                ),
//                // Для еденичной проверки
////                 'post__in' => array(8)
//                'numberposts' => -1
//            ];
//            $all_posts = get_posts($args);
////                s($all_posts);
//
//            /**
//             * И погнали обрабатывать посты
//             */
//            foreach ($all_posts as $single_post) {
//
//                $post_id = $single_post->ID;
////                s($single_post);
//                $post_date = $single_post->post_date;
//
//                $OLD_post_data = explode('-', $post_date);
//
//
//                $NEW_post_data = $SDStudio_year . '-' . $OLD_post_data[1] . '-' . $OLD_post_data[2];
//
//                // Обрабатываем дату
//                // 2017-02-03 18:31:00
//
////                s($post_date);
////                s($SDStudio_year);
////                s($OLD_post_data);
////                s($NEW_post_data);
//                /**
//                 * Применяем обновление даты
//                 */
//                $single_post->post_title = $single_post->post_title . '';
//                $single_post->post_date = $NEW_post_data;
//                $single_post->post_date_gmt = $NEW_post_data;
//                $single_post->post_status = 'future';
//
//                    wp_update_post( $single_post );
//            }
//        }
//
//        update_all_posts_year_in_data_publish();
//    }
//    /**
//     * END
//     */


}



?>