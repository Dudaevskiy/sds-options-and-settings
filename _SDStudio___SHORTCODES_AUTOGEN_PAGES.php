<?php
include_once(ABSPATH . 'wp-includes/pluggable.php');
/**
 * REDUX - Захват опций темы
 */
$redux = get_option( 'redux_sds_options_and_settings' );

//dd($redux);

global $email_auto_gen_pages_shortcodes_sds_options_and_settings;
// Если опция активна
$enable_auto_gen_pages_shortcodes_sds_options_and_settings = $redux['enable_auto_gen_pages_shortcodes_sds-options-and-settings'];
$email_auto_gen_pages_shortcodes_sds_options_and_settings = $redux['email_auto_gen_pages_shortcodes_sds-options-and-settings'];





if ($enable_auto_gen_pages_shortcodes_sds_options_and_settings == 1) {
    /***
     * WPML
     * Робимо переклад рядків опцій на рівні перекладу рядків WPML
     */
// Функція для реєстрації рядків Redux для перекладу
    function register_redux_strings_for_translation() {
        if (function_exists('icl_register_string')) {
            $redux = get_option('redux_sds_options_and_settings');

            icl_register_string('Redux Options', 'FOOTER_SHORT', $redux['FOOTER_SHORT__auto_gen_pages_shortcodes_sds-options-and-settings']);
            icl_register_string('Redux Options', 'FOOTER_OTKAZ', $redux['FOOTER_OTKAZ__auto_gen_pages_shortcodes_sds-options-and-settings']);
        }
    }
    add_action('init', 'register_redux_strings_for_translation');

// Функція для отримання перекладеного значення Redux опції
    function get_translated_redux_option($option_key, $default = '') {
        $redux = get_option('redux_sds_options_and_settings');
        $value = isset($redux[$option_key]) ? $redux[$option_key] : $default;

        if (function_exists('icl_t')) {
            // Отримуємо переклад
            return icl_t('Redux Options', str_replace('__auto_gen_pages_shortcodes_sds-options-and-settings', '', $option_key), $value);
        }

        return $value;
    }

// Хук для оновлення перекладів при збереженні Redux опцій
    function update_redux_translations($options, $changed_values) {
        if (function_exists('icl_register_string')) {
            foreach ($changed_values as $key => $value) {
                if ($key === 'FOOTER_SHORT__auto_gen_pages_shortcodes_sds-options-and-settings' ||
                    $key === 'FOOTER_OTKAZ__auto_gen_pages_shortcodes_sds-options-and-settings') {
                    icl_register_string('Redux Options', str_replace('__auto_gen_pages_shortcodes_sds-options-and-settings', '', $key), $value);
                }
            }
        }
        return $options;
    }
    add_filter('redux/options/redux_sds_options_and_settings/saved', 'update_redux_translations', 10, 2);

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

    if (!function_exists('get_string_between')) {
        function get_string_between($string, $start, $end) {
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }
    }

    if (!function_exists('get_site_email')) {
        function get_site_email() {
            global $email_auto_gen_pages_shortcodes_sds_options_and_settings;
            return empty($email_auto_gen_pages_shortcodes_sds_options_and_settings)
                ? 'info@' . $_SERVER['HTTP_HOST']
                : $email_auto_gen_pages_shortcodes_sds_options_and_settings;
        }
    }

    if (!function_exists('get_site_url')) {
        function get_site_url() {
            $protocol = is_ssl() ? 'https' : 'http';
            return $protocol . '://' . $_SERVER['HTTP_HOST'];
        }
    }

    if (!function_exists('load_markdown_file')) {
        function load_markdown_file($filename) {
            require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';
            $MarkdownParser = new \cebe\markdown\Markdown();
            return $MarkdownParser->parse(file_get_contents(dirname(__FILE__) . $filename));
        }
    }

    if (!function_exists('replace_variables')) {
        function replace_variables($content) {
            $replacements = [
                '{{%THIS_SITE%}}' => '<a href="' . get_site_url() . '">' . get_site_url() . '</a>',
                '{{%EMAIL%}}' => '<a href="mailto:' . get_site_email() . '">' . get_site_email() . '</a>',
                '%%Y%%' => date('Y'),
                '%%SITE_TITLE%%' => get_bloginfo('name'),
            ];

            return str_replace(array_keys($replacements), array_values($replacements), $content);
        }
    }

    if (!function_exists('get_excluded_posts')) {
        function get_excluded_posts() {
            $redux = get_option('redux_sds_options_and_settings');
            $excluded_ids = $redux['HTML_SITEMAP_SLUG_EXCLUDE_ID_POSTS__auto_gen_pages_shortcodes_sds-options-and-settings'] ?? '';
            return array_map('intval', array_filter(explode(',', str_replace(' ', '', $excluded_ids))));
        }
    }

    if (!function_exists('get_excluded_categories')) {
        function get_excluded_categories() {
            $redux = get_option('redux_sds_options_and_settings');
            $excluded_ids = $redux['HTML_SITEMAP_SLUG_EXCLUDE_ID_TERMS__auto_gen_pages_shortcodes_sds-options-and-settings'] ?? '';
            $excluded = array_map('intval', array_filter(explode(',', str_replace(' ', '', $excluded_ids))));

            global $sitepress;
            if ($sitepress) {
                foreach ($excluded as $term_id) {
                    $trid = $sitepress->get_element_trid($term_id, 'tax_category');
                    $translations = $sitepress->get_element_translations($trid, 'tax_category');
                    foreach ($translations as $translation) {
                        $excluded[] = $translation->element_id;
                    }
                }
            }

            return array_unique($excluded);
        }
    }

    if (!function_exists('generate_posts_sitemap')) {
        function generate_posts_sitemap($title_post) {
            $HTML = '<div class="rank-math-html-sitemap__section rank-math-html-sitemap__section--post-type rank-math-html-sitemap__section--post">';
            $HTML .= '<h2 class="rank-math-html-sitemap__title">' . $title_post . '</h2>';
            $HTML .= '<ul class="rank-math-html-sitemap__list">';

            $query = new WP_Query([
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'order' => 'ASC',
                'orderby' => 'date',
            ]);

            $excluded_posts = get_excluded_posts();

            foreach ($query->posts as $post) {
                if (!in_array($post->ID, $excluded_posts)) {
                    $HTML .= '<li class="rank-math-html-sitemap__item">
                            <a href="' . get_permalink($post->ID) . '" data_ind="' . $post->ID . '" class="rank-math-html-sitemap__link" target="_blank">' . $post->post_title . '</a>
                          </li>';
                }
            }

            $HTML .= '</ul></div>';
            return $HTML;
        }
    }

    if (!function_exists('generate_categories_sitemap')) {
        function generate_categories_sitemap($title_categories) {
            $HTML = '<div class="rank-math-html-sitemap__section rank-math-html-sitemap__section--taxonomy rank-math-html-sitemap__section--category">';
            $HTML .= '<h2 class="rank-math-html-sitemap__title">' . $title_categories . '</h2>';
            $HTML .= '<ul class="rank-math-html-sitemap__list">';

            $categories = get_categories([
                'orderby' => 'count',
                'order' => 'DESC',
                'hide_empty' => 0,
            ]);

            $excluded_categories = get_excluded_categories();

            foreach ($categories as $category) {
                if (!in_array($category->term_id, $excluded_categories)) {
                    $HTML .= '<li class="rank-math-html-sitemap__item">
                            <a href="' . get_term_link($category->term_id, 'category') . '" class="rank-math-html-sitemap__link" data_ind="' . $category->term_id . '" target="_blank">' . $category->name . '</a>
                          </li>';
                }
            }

            $HTML .= '</ul></div>';
            return $HTML;
        }
    }

    add_shortcode('SDStudio_PAGE_AUTOGEN', function($attributes) {
        $page_shortcode = $attributes['page'];
        if (isset($attributes['content'])){
            $content = $attributes['content'];
        } else {
            $content = null;
        }


        $current_lang = get_locale();

        $shortcode_map = [
            'OTKAZ' => '/_markdown/_SHORTCODE__otkaz_ot_otvetstvennosti/',
            'KONTACTS' => '/_markdown/_SHORTCODE__contacts/',
            'KONF' => '/_markdown/_SHORTCODE__politika_conf/',
            'FOOTER_OTKAZ' => '/_markdown/_SHORTCODE__footer_otkaz/',
            'FOOTER_COPY' => '/_markdown/_SHORTCODE__footer_copy_short/',
        ];

        $HTML = '';
        if (array_key_exists($page_shortcode, $shortcode_map) && $content !== "false") {
            $HTML = load_markdown_file($shortcode_map[$page_shortcode] . $current_lang . '.md');
            $HTML .= '<style>li.bf-breadcrumb-item.bf-breadcrumb-end {display: none !important;}</style>';
            // Обробка [name_page]
            $HTML = preg_replace('/\[name_page(.+?)name_page\]/', '', $HTML);
        } elseif ($page_shortcode == "HTML_SITEMAP") {
            if (!is_admin()) {
                $RAW_MD = load_markdown_file('/_markdown/_SHORTCODE__html_sitemap/' . $current_lang . '.md');
                $text_page = ($content !== "false") ? get_string_between($RAW_MD, '[text_page]', '[/text_page]') : '';
                $title_post = get_string_between($RAW_MD, '[title_post]', '[/title_post]');
                $title_categories = get_string_between($RAW_MD, '[title_categories]', '[/title_categories]');

                $HTML = $text_page . '<br>';
                $HTML .= '<style>li.bf-breadcrumb-item.bf-breadcrumb-end {display: none !important;}</style>';

                $url_end = '';
                global $sitepress;
                if ($sitepress) {
                    $sdstudio_current_post_lang = apply_filters('wpml_post_language_details', NULL, get_the_id())["language_code"];
                    $LocaleCurentSiteLaguage_GLOBAL = apply_filters('wpml_default_language', NULL);
                    if ($sdstudio_current_post_lang !== $LocaleCurentSiteLaguage_GLOBAL) {
                        $url_end = '/' . $sdstudio_current_post_lang;
                    }
                }

                $HTML = str_replace('{{%THIS_SITE%}}', '<a href="' . get_site_url() . $url_end . '">' . get_site_url() . $url_end . '</a>', $HTML);

                $HTML .= '<div class="rank-math-html-sitemap">';
                $HTML .= generate_posts_sitemap($title_post);
                $HTML .= generate_categories_sitemap($title_categories);
                $HTML .= '</div>';
                $HTML = preg_replace('/\[name_page(.+?)name_page\]/', '', $HTML);
            }
        }

        if ($page_shortcode == "FOOTER_COPY") {
            $redux = get_option( 'redux_sds_options_and_settings' );
            $FOOTER_SHORT__auto_gen_pages_shortcodes_sds_options_and_settings = $redux['FOOTER_SHORT__auto_gen_pages_shortcodes_sds-options-and-settings'];
            if (isset($FOOTER_SHORT__auto_gen_pages_shortcodes_sds_options_and_settings) && $FOOTER_SHORT__auto_gen_pages_shortcodes_sds_options_and_settings !== ""){
//                $HTML = $FOOTER_SHORT__auto_gen_pages_shortcodes_sds_options_and_settings;
                $HTML = get_translated_redux_option('FOOTER_SHORT__auto_gen_pages_shortcodes_sds-options-and-settings');
            } else {
                $HTML = load_markdown_file($shortcode_map[$page_shortcode] . $current_lang . '.md');
            }
            $HTML .= '<style>li.bf-breadcrumb-item.bf-breadcrumb-end {display: none !important;}</style>';
        }

        if ($page_shortcode == "FOOTER_OTKAZ") {
            $redux = get_option( 'redux_sds_options_and_settings' );
            $FOOTER_OTKAZ__auto_gen_pages_shortcodes_sds_options_and_settings = $redux['FOOTER_OTKAZ__auto_gen_pages_shortcodes_sds-options-and-settings'];
            if (isset($FOOTER_OTKAZ__auto_gen_pages_shortcodes_sds_options_and_settings) && $FOOTER_OTKAZ__auto_gen_pages_shortcodes_sds_options_and_settings !== ""){
                $HTML = get_translated_redux_option('FOOTER_OTKAZ__auto_gen_pages_shortcodes_sds-options-and-settings');
//                $HTML = $FOOTER_OTKAZ__auto_gen_pages_shortcodes_sds_options_and_settings;
            } else {
                $HTML = load_markdown_file($shortcode_map[$page_shortcode] . $current_lang . '.md');
            }
            $HTML .= '<style>li.bf-breadcrumb-item.bf-breadcrumb-end {display: none !important;}</style>';
        }


//vd($HTML);
        return replace_variables($HTML);
    });

    add_filter('the_content', 'replace_variables');

    /**
     * @param $title
     * @param null $id
     * @return mixed
     *
     * Автозамена названий страниц с шорткодаи
     *
     */
    function SDStudio_PAGE_AUTOGEN_title_updater( $title, $id = null ) {

//		if (!empty( wp_get_associated_nav_menu_items( $id ))) {
//			return $title;
//		}
        // В начале получим текущую локаль
        $current_lang = get_locale(); // "ru_RU"

        // Получение строки между значениями
        /**
         * @param $string
         * @param $start
         * @param $end
         * @return false|string
         *
         * $fullstring = 'this is my [tag]dog[/tag]';
         * $parsed = get_string_between($fullstring, '[tag]', '[/tag]');
         */
        if (!function_exists('get_string_between')){
            function get_string_between($string, $start, $end){
                $string = ' ' . $string;
                $ini = strpos($string, $start);
                if ($ini == 0) return '';
                $ini += strlen($start);
                $len = strpos($string, $end, $ini) - $ini;
                return substr($string, $ini, $len);
            }
        }



        if ( !is_admin() ) {
            //if ( !empty( wp_get_associated_nav_menu_items( $id ) ) && is_singular( 'page' ) && in_the_loop()) {
            if (  is_singular( 'page' ) && in_the_loop() ) {
                $page_id = get_the_ID();
                // Получаем контент
                $get_content = get_post($page_id);

                // Если в контенте страницы нет шорткода значит выходим, и не обрабатываем страницу дальше
                if (strpos($get_content->post_content, 'SDStudio_PAGE_AUTOGEN') == false) {
                    return $title;
                }


                if (strpos($get_content->post_content, 'SDStudio_PAGE_AUTOGEN page="OTKAZ"') !== false) {
                    $file_get = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__otkaz_ot_otvetstvennosti/' . $current_lang . '.md');
                }

                if (strpos($get_content->post_content, 'SDStudio_PAGE_AUTOGEN page="KONF"') !== false) {
                    $file_get = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__politika_conf/'.$current_lang.'.md');
                }

                if (strpos($get_content->post_content, 'SDStudio_PAGE_AUTOGEN page="KONTACTS"') !== false) {
                    $file_get = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__contacts/'.$current_lang.'.md');
                }

                if (strpos($get_content->post_content, 'SDStudio_PAGE_AUTOGEN page="HTML_SITEMAP"') !== false) {
                    $file_get = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__html_sitemap/'.$current_lang.'.md');
                }

                // Имя страницы
                $page_name = get_string_between($file_get, '[name_page]', '[/name_page]');
                return $page_name;

            } else {
                return $title;
            }
        }

        return $title;
    }
    add_filter( 'the_title', 'SDStudio_PAGE_AUTOGEN_title_updater', 10, 2 );

    /**
     * И удаляем обработку title в пунктах меню
     **/
    function wpse309151_remove_title_filter_nav_menu( $nav_menu, $args ) {
        // we are working with menu, so remove the title filter
        remove_filter( 'the_title', 'SDStudio_PAGE_AUTOGEN_title_updater', 10, 2 );
        return $nav_menu;
    }
    // this filter fires just before the nav menu item creation process
    add_filter( 'pre_wp_nav_menu', 'wpse309151_remove_title_filter_nav_menu', 10, 2 );

    function wpse309151_add_title_filter_non_menu( $items, $args ) {
        // we are done working with menu, so add the title filter back
        add_filter( 'the_title', 'SDStudio_PAGE_AUTOGEN_title_updater', 10, 2 );
        return $items;
    }
    // this filter fires after nav menu item creation is done
    add_filter( 'wp_nav_menu_items', 'wpse309151_add_title_filter_non_menu', 10, 2 );






if (!is_admin()){
    function sdstudio_replacer_for_autogenpages_callback($buffer) {
        // В начале получим текущую локаль
        $current_lang = get_locale(); // "ru_RU"

        // Получение строки между значениями
        /**
         * @param $string
         * @param $start
         * @param $end
         * @return false|string
         *
         * $fullstring = 'this is my [tag]dog[/tag]';
         * $parsed = get_string_between($fullstring, '[tag]', '[/tag]');
         */
        if (!function_exists('get_string_between')){
            function get_string_between($string, $start, $end){
                $string = ' ' . $string;
                $ini = strpos($string, $start);
                if ($ini == 0) return '';
                $ini += strlen($start);
                $len = strpos($string, $end, $ini) - $ini;
                return substr($string, $ini, $len);
            }
        }

//        if (strpos($get_content->post_content, 'SDStudio_PAGE_AUTOGEN page="OTKAZ"') !== false) {
//            $file_get = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__otkaz_ot_otvetstvennosti/' . $current_lang . '.md');
//        }
//
//        if (strpos($get_content->post_content, 'SDStudio_PAGE_AUTOGEN page="KONF"') !== false) {
//            $file_get = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__politika_conf/'.$current_lang.'.md');
//        }
//
//        if (strpos($get_content->post_content, 'SDStudio_PAGE_AUTOGEN page="KONTACTS"') !== false) {
//            $file_get = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__contacts/'.$current_lang.'.md');
//        }

        /**
         * REDUX - Захват опций темы
         */
        $redux = get_option( 'redux_sds_options_and_settings' );
        $new_link_KONF = $redux['KONF_SLUG_auto_gen_pages_shortcodes_sds-options-and-settings'];
        $new_link_OTKAZ = $redux['OTKAZ_SLUG_auto_gen_pages_shortcodes_sds-options-and-settings'];
        $new_link_KONTACTS = $redux['KONTACTS_SLUG_auto_gen_pages_shortcodes_sds-options-and-settings'];
        $new_link_HTML_SITEMAP = $redux['HTML_SITEMAP_SLUG_auto_gen_pages_shortcodes_sds-options-and-settings'];








        global $sitepress;
        // Отказ от ответственности
        // URL
        if ($sitepress){
            $buffer = str_replace(array('https://%%sdstudio_autogen__KONF_URL%%','http://%%sdstudio_autogen__KONF_URL%%','%%sdstudio_autogen__KONF_URL%%'),'/'.ICL_LANGUAGE_CODE.$new_link_KONF,$buffer);
            $buffer = str_replace(array('https://%%sdstudio_autogen__OTKAZ_URL%%','http://%%sdstudio_autogen__OTKAZ_URL%%','%%sdstudio_autogen__OTKAZ_URL%%'),'/'.ICL_LANGUAGE_CODE.$new_link_OTKAZ,$buffer);
            $buffer = str_replace(array('https://%%sdstudio_autogen__KONTACTS_URL%%','http://%%sdstudio_autogen__KONTACTS_URL%%','%%sdstudio_autogen__KONTACTS_URL%%'),'/'.ICL_LANGUAGE_CODE.$new_link_KONTACTS,$buffer);

            $buffer = str_replace(array('https://%%sdstudio_autogen__HTML_SITEMAP_URL%%','http://%%sdstudio_autogen__HTML_SITEMAP_URL%%','%%sdstudio_autogen__HTML_SITEMAP_URL%%'),'/'.ICL_LANGUAGE_CODE.$new_link_HTML_SITEMAP,$buffer);
        } else {
            $buffer = str_replace(array('https://%%sdstudio_autogen__KONF_URL%%','http://%%sdstudio_autogen__KONF_URL%%','%%sdstudio_autogen__KONF_URL%%'),$new_link_KONF,$buffer);
            $buffer = str_replace(array('https://%%sdstudio_autogen__OTKAZ_URL%%','http://%%sdstudio_autogen__OTKAZ_URL%%','%%sdstudio_autogen__OTKAZ_URL%%'),$new_link_KONF,$buffer);
            $buffer = str_replace(array('https://%%sdstudio_autogen__KONTACTS_URL%%','http://%%sdstudio_autogen__KONTACTS_URL%%','%%sdstudio_autogen__KONTACTS_URL%%'),$new_link_KONTACTS,$buffer);

            $buffer = str_replace(array('https://%%sdstudio_autogen__HTML_SITEMAP_URL%%','http://%%sdstudio_autogen__HTML_SITEMAP_URL%%','%%sdstudio_autogen__HTML_SITEMAP_URL%%'),$new_link_HTML_SITEMAP,$buffer);
        }
            // KONF
            $file_get_KONF = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__politika_conf/'.$current_lang.'.md');
            $new_name_KONF = get_string_between($file_get_KONF, '[name_page]', '[/name_page]');
            $buffer = str_replace('%%sdstudio_autogen__KONF_TITLE%%',$new_name_KONF,$buffer);
            // OTKAZ
            $file_get_OTKAZ = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__otkaz_ot_otvetstvennosti/'.$current_lang.'.md');
            $new_name_OTKAZ = get_string_between($file_get_OTKAZ, '[name_page]', '[/name_page]');
            $buffer = str_replace('%%sdstudio_autogen__OTKAZ_TITLE%%',$new_name_OTKAZ,$buffer);
            // KONTACTS
            $file_get_KONTACTS = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__contacts/'.$current_lang.'.md');
            $new_name_KONTACTS = get_string_between($file_get_KONTACTS, '[name_page]', '[/name_page]');
            $buffer = str_replace('%%sdstudio_autogen__KONTACTS_TITLE%%',$new_name_KONTACTS,$buffer);
            // HTML_SITEMAP
            $file_get_HTML_SITEMAP = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__html_sitemap/'.$current_lang.'.md');
            $new_name_HTML_SITEMAP = get_string_between($file_get_HTML_SITEMAP, '[name_page]', '[/name_page]');
            $buffer = str_replace('%%sdstudio_autogen__HTML_SITEMAP_TITLE%%',$new_name_HTML_SITEMAP,$buffer);

        /***
         * PageSpeed Fixes
         */
            $buffer = str_replace("font-face{font-family:'FontAwesome';","font-face{font-family:'FontAwesome';font-display: swap !important;",$buffer);
            $buffer = str_replace('font-face{font-family:"bs-icons";','font-face{font-family:"bs-icons";font-display: swap !important;',$buffer);
            // Fixes https://community.cloudflare.com/t/how-to-reduce-fontawesome-webfont-load-time-using-cloudflare/228056
            $buffer = str_replace('?v=4.7.0','',$buffer);


    //    dd($buffer);
        return $buffer;
    }

    function sdstudio_replacer_for_autogenpages_buffer_start() { ob_start("sdstudio_replacer_for_autogenpages_callback"); }
//    function sdstudio_replacer_for_autogenpages_buffer_end() { ob_end_flush(); }
    function sdstudio_replacer_for_autogenpages_buffer_end() {
        if (ob_get_length()) {
            ob_end_flush();
        }
    }

    add_action('after_setup_theme', 'sdstudio_replacer_for_autogenpages_buffer_start');
    add_action('shutdown', 'sdstudio_replacer_for_autogenpages_buffer_end');
}


    /**
     * Rank Math - SEO Title + Deslriptions для авто генерируемых страниц
     * https://bit.ly/3pb1wma
     */
    /***
     * Функція для розбору шорткоду та його атрибутів
     */
    if (!function_exists('parse_sdstudio_shortcode')) {
        function parse_sdstudio_shortcode_autogen($content)
        {
            $pattern = '/\[SDStudio_PAGE_AUTOGEN\s+([^\]]+)\]/';
            $matches = array();
            $attributes = array();

            if (preg_match($pattern, $content, $matches)) {
                $attr_string = $matches[1];
                $attr_pairs = explode(' ', $attr_string);

                foreach ($attr_pairs as $pair) {
                    $pair = trim($pair);
                    if (strpos($pair, '=') !== false) {
                        list($key, $value) = explode('=', $pair, 2);
                        $key = trim($key);
                        $value = trim($value, '"\'');
                        $attributes[$key] = $value;
                    }
                }
            }

            return $attributes;
        }
    }

    add_filter( "rank_math/frontend/title", function( $content ) {
        global $post;

        // Додаємо перевірку на існування $post
        if (!$post || !isset($post->post_content)) return $content;

        if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN') !== false) {

            // В начале получим текущую локаль
            $current_lang = get_locale(); // "ru_RU"

            if (!function_exists('get_string_between')) {
                function get_string_between($string, $start, $end)
                {
                    $string = ' ' . $string;
                    $ini = strpos($string, $start);
                    if ($ini == 0) return '';
                    $ini += strlen($start);
                    $len = strpos($string, $end, $ini) - $ini;
                    return substr($string, $ini, $len);
                }
            }

            // Перевірки на наявність різних шорткодів у контенті
            if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN page="OTKAZ"]') !== false) {
                $file_get_OTKAZ = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__otkaz_ot_otvetstvennosti/' . $current_lang . '.md');
                $page_name = get_string_between($file_get_OTKAZ, '[name_page]', '[/name_page]');
                $content = $page_name;
            }

            if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN page="KONF"]') !== false) {
                $file_get_KONF = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__politika_conf/' . $current_lang . '.md');
                $page_name = get_string_between($file_get_KONF, '[name_page]', '[/name_page]');
                $content = $page_name;
            }

            if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN page="KONTACTS"]') !== false) {
                $file_get_KONTACTS = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__contacts/'.$current_lang.'.md');
                $page_name = get_string_between($file_get_KONTACTS, '[name_page]', '[/name_page]');
                $content = $page_name;
            }

            if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN page="HTML_SITEMAP"]') !== false) {
                $file_get_HTML_SITEMAP = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__html_sitemap/'.$current_lang.'.md');
                $page_name = get_string_between($file_get_HTML_SITEMAP, '[name_page]', '[/name_page]');

                // Ссылка на главную страницу сайта
                $protocol = is_ssl() === TRUE ? 'https' : 'http';
                $url_this_site = $protocol . '://' . $_SERVER['HTTP_HOST']; // "https://domain.com"

                $url_end = '';
                global $sitepress;
                if ($sitepress) {
                    $sdstudio_current_post_lang = apply_filters( 'wpml_post_language_details', NULL, get_the_id() )["language_code"];
                    $LocaleCurentSiteLaguage_GLOBAL = apply_filters('wpml_default_language', NULL );
                    if ($sdstudio_current_post_lang !== $LocaleCurentSiteLaguage_GLOBAL){
                        $url_end =  '/'.$sdstudio_current_post_lang;
                    }
                }

                $content = $page_name.' - '.$url_this_site.$url_end;
            }
        }

        return $content;
    });


    add_filter( 'rank_math/frontend/description', function( $description ) {
        global $post;

        $short_attrs = parse_sdstudio_shortcode_autogen($post->post_content);
        if (isset($short_attrs['content']) && $short_attrs['content'] == 'false'){
            return replace_variables($description).'...';
        }

        // Перевірка, чи існує $post
        if (!$post) return $description;

        if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN') !== false) {

            // В начале получим текущую локаль
            $current_lang = get_locale(); // "ru_RU"

            // Email для страниц
            global $email_auto_gen_pages_shortcodes_sds_options_and_settings;
            $email = $email_auto_gen_pages_shortcodes_sds_options_and_settings;
            if (empty($email)){
                $email = 'info@'.$_SERVER['HTTP_HOST']; // "info@domain.com"
            }

            // Ссылка на главную страницу сайта
            $protocol = is_ssl() === TRUE ? 'https' : 'http';
            $url_this_site = $protocol . '://' . $_SERVER['HTTP_HOST']; // "https://domain.com"

            $HTML = null;
            // Перевірка на наявність різних шорткодів у контенті
            if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN page="KONTACTS"]') !== false) {
                $HTML = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__contacts/'.$current_lang.'.md');
            }

            if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN page="KONF"]') !== false) {
                $HTML = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__politika_conf/' . $current_lang . '.md');
            }

            if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN page="OTKAZ"]') !== false) {
                $HTML = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__otkaz_ot_otvetstvennosti/' . $current_lang . '.md');
            }

            if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN page="HTML_SITEMAP"]') !== false) {
                $HTML = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__html_sitemap/'.$current_lang.'.md');
            }

            // Функція для отримання рядка між двома значеннями
            if (!function_exists('get_string_between')){
                function get_string_between($string, $start, $end){
                    $string = ' ' . $string;
                    $ini = strpos($string, $start);
                    if ($ini == 0) return '';
                    $ini += strlen($start);
                    $len = strpos($string, $end, $ini) - $ini;
                    return substr($string, $ini, $len);
                }
            }

            // Удаляем имя страницы
            $HTML = preg_replace('/\[name_page(.+?)name_page\]/','',$HTML);

            if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN page="HTML_SITEMAP"]') !== false) {
                $HTML =  get_string_between($HTML, '[text_page]', '[/text_page]');
                $url_end = '';
                global $sitepress;
                if ($sitepress) {
                    $sdstudio_current_post_lang = apply_filters( 'wpml_post_language_details', NULL, get_the_id() )["language_code"];
                    $LocaleCurentSiteLaguage_GLOBAL = apply_filters('wpml_default_language', NULL );
                    if ($sdstudio_current_post_lang !== $LocaleCurentSiteLaguage_GLOBAL){
                        $url_end =  '/'.$sdstudio_current_post_lang;
                    }
                }

                $HTML = str_replace('{{%THIS_SITE%}}',$url_this_site.$url_end,$HTML);
            }

            $HTML = str_replace('{{%EMAIL%}}',$email,$HTML);
            $HTML = str_replace('{{%THIS_SITE%}}',$url_this_site,$HTML);
            $HTML = str_replace(array('*','_','#'),'',$HTML);

            $HTML = mb_substr($HTML, 0, 200);

            $description = $HTML.'...';
        }
        return $description;
    });


}