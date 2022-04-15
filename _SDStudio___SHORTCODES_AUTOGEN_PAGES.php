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
    
    add_shortcode('SDStudio_PAGE_AUTOGEN', function($attributes) {
    
        $page_shortcode = $attributes['page'];
    
        // Email для страниц
        global $email_auto_gen_pages_shortcodes_sds_options_and_settings;
        $email = $email_auto_gen_pages_shortcodes_sds_options_and_settings;
        if (empty($email)){
            $email = 'info@'.$_SERVER['HTTP_HOST']; // "info@domain.com"
        }
    
        // Ссылка на главную страницу сайта
        $protocol = is_ssl() === TRUE ? 'https' : 'http';
        $url_this_site = $protocol . '://' . $_SERVER['HTTP_HOST']; // "https://domain.com"
    
        // В начале получим текущую локаль
        $current_lang = get_locale(); // "ru_RU"
    
        // MarkDown
        require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
        $MarkdownParser = new \cebe\markdown\Markdown();
    
        if ($page_shortcode == "OTKAZ"){
            $HTML = $MarkdownParser->parse(file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__otkaz_ot_otvetstvennosti/'.$current_lang.'.md'));
            $HTML = $HTML.'<style>li.bf-breadcrumb-item.bf-breadcrumb-end {display: none !important;}</style>';
        }
        if ($page_shortcode == "KONTACTS"){
            $HTML = $MarkdownParser->parse(file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__contacts/'.$current_lang.'.md'));
            $HTML = $HTML.'<style>li.bf-breadcrumb-item.bf-breadcrumb-end {display: none !important;}</style>';
        }
        if ($page_shortcode == "KONF"){
            $HTML = $MarkdownParser->parse(file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__politika_conf/'.$current_lang.'.md'));
            $HTML = $HTML.'<style>li.bf-breadcrumb-item.bf-breadcrumb-end {display: none !important;}</style>';
        }

        if ($page_shortcode == "FOOTER_OTKAZ"){
            $HTML = $MarkdownParser->parse(file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__footer_otkaz/'.$current_lang.'.md'));
        }

        if ($page_shortcode == "FOOTER_COPY"){
            $HTML = $MarkdownParser->parse(file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__footer_copy_short/'.$current_lang.'.md'));
            $current_year = date('Y');
            $HTML = str_replace('%%Y%%',$current_year,$HTML);
            $current_site_title = get_bloginfo('name');
            $HTML = str_replace('%%SITE_TITLE%%',$current_site_title,$HTML);
        }
    
        $HTML = str_replace('{{%EMAIL%}}','<a href="mailto:'.$email.'">'.$email.'</a>',$HTML);
        $HTML = str_replace('{{%THIS_SITE%}}','<a href="'.$url_this_site.'">'.$url_this_site.'</a>',$HTML);
    
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
        // Удаляем имя страницы
        $HTML = preg_replace('/\[name_page(.+?)name_page\]/','',$HTML);
    
        // И готовый HTML
        $HTML = str_replace('{{%THIS_SITE%}}','<a href="'.$url_this_site.'">'.$url_this_site.'</a>',$HTML);

    
    
    
        return $HTML;
    });


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








        global $sitepress;
        // Отказ от ответственности
        // URL
        if ($sitepress){
            $buffer = str_replace(array('https://%%sdstudio_autogen__KONF_URL%%','http://%%sdstudio_autogen__KONF_URL%%','%%sdstudio_autogen__KONF_URL%%'),'/'.ICL_LANGUAGE_CODE.$new_link_KONF,$buffer);
            $buffer = str_replace(array('https://%%sdstudio_autogen__OTKAZ_URL%%','http://%%sdstudio_autogen__OTKAZ_URL%%','%%sdstudio_autogen__OTKAZ_URL%%'),'/'.ICL_LANGUAGE_CODE.$new_link_OTKAZ,$buffer);
            $buffer = str_replace(array('https://%%sdstudio_autogen__KONTACTS_URL%%','http://%%sdstudio_autogen__KONTACTS_URL%%','%%sdstudio_autogen__KONTACTS_URL%%'),'/'.ICL_LANGUAGE_CODE.$new_link_KONTACTS,$buffer);
        } else {
            $buffer = str_replace(array('https://%%sdstudio_autogen__KONF_URL%%','http://%%sdstudio_autogen__KONF_URL%%','%%sdstudio_autogen__KONF_URL%%'),$new_link_KONF,$buffer);
            $buffer = str_replace(array('https://%%sdstudio_autogen__OTKAZ_URL%%','http://%%sdstudio_autogen__OTKAZ_URL%%','%%sdstudio_autogen__OTKAZ_URL%%'),$new_link_KONF,$buffer);
            $buffer = str_replace(array('https://%%sdstudio_autogen__KONTACTS_URL%%','http://%%sdstudio_autogen__KONTACTS_URL%%','%%sdstudio_autogen__KONTACTS_URL%%'),$new_link_KONTACTS,$buffer);
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


    //    dd($buffer);
        return $buffer;
    }

    function sdstudio_replacer_for_autogenpages_buffer_start() { ob_start("sdstudio_replacer_for_autogenpages_callback"); }
    function sdstudio_replacer_for_autogenpages_buffer_end() { ob_end_flush(); }

    add_action('after_setup_theme', 'sdstudio_replacer_for_autogenpages_buffer_start');
    add_action('shutdown', 'sdstudio_replacer_for_autogenpages_buffer_end');
}


//if (function_exists('rank_math')){
//if (class_exists('Frontend_SEO_Score')){
    /**
     * Rank Math - SEO Title + Deslriptions для авто генерируемых страниц
     * https://bit.ly/3pb1wma
     */
//    dd(class_exists('RankMath'));
//    add_filter( "rank_math/opengraph/facebook/og_title", function( $content ) {
    add_filter( "rank_math/frontend/title", function( $content ) {
        global $post;
        if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN') !== false){

            // В начале получим текущую локаль
            $current_lang = get_locale(); // "ru_RU"

            /**
             * @param $string
             * @param $start
             * @param $end
             * @return false|string
             *
             * $fullstring = 'this is my [tag]dog[/tag]';
             * $parsed = get_string_between($fullstring, '[tag]', '[/tag]');
             */
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


            //OTKAZ
            if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN page="OTKAZ"]') !== false) {
                $file_get_OTKAZ = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__otkaz_ot_otvetstvennosti/' . $current_lang . '.md');
                $page_name = get_string_between($file_get_OTKAZ, '[name_page]', '[/name_page]');
                $content = $page_name;
            }

            //KONF
            if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN page="KONF"]') !== false) {
                $file_get_KONF = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__politika_conf/' . $current_lang . '.md');
                $page_name = get_string_between($file_get_KONF, '[name_page]', '[/name_page]');
                $content = $page_name;
            }

            //KONTACTS
            if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN page="KONTACTS"]') !== false) {
                $file_get_KONTACTS = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__contacts/'.$current_lang.'.md');
                $page_name = get_string_between($file_get_KONTACTS, '[name_page]', '[/name_page]');
                $content = $page_name;
            }
        }
        return $content;
    });


    add_filter( 'rank_math/frontend/description', function( $description ) {
        global $post;
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

            //KONTACTS
            if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN page="KONTACTS"]') !== false) {
                $HTML = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__contacts/'.$current_lang.'.md');
            }

            //KONF
            if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN page="KONF"]') !== false) {
                $HTML = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__politika_conf/' . $current_lang . '.md');
            }

            //OTKAZ
            if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN page="OTKAZ"]') !== false) {
                $HTML = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__otkaz_ot_otvetstvennosti/' . $current_lang . '.md');
            }


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
            // Удаляем имя страницы
            $HTML = preg_replace('/\[name_page(.+?)name_page\]/','',$HTML);
            $HTML = str_replace('{{%EMAIL%}}',$email,$HTML);
            $HTML = str_replace('{{%THIS_SITE%}}',$url_this_site,$HTML);
            $HTML = str_replace(array('*','_','#'),'',$HTML);
            $HTML = mb_substr($HTML, 0, 200);
            $description = $HTML.'...';
        }
        return $description;
    });

//}

}