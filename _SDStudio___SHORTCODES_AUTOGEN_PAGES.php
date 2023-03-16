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

        // Получение строки между значениями
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

        if ($page_shortcode == "HTML_SITEMAP"){
            $RAW_MD = $MarkdownParser->parse(file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__html_sitemap/'.$current_lang.'.md'));
            $text_page = get_string_between($RAW_MD, '[text_page]', '[/text_page]');
            $title_post = get_string_between($RAW_MD, '[title_post]', '[/title_post]');
            $title_categories = get_string_between($RAW_MD, '[title_categories]', '[/title_categories]');


            $HTML = $text_page.'<br>';
            $HTML = $HTML.'<style>li.bf-breadcrumb-item.bf-breadcrumb-end {display: none !important;}</style>';

            $url_end = '';
            global $sitepress;
            if ($sitepress) {
                $sdstudio_current_post_lang = apply_filters( 'wpml_post_language_details', NULL, get_the_id() )["language_code"];
                $LocaleCurentSiteLaguage_GLOBAL = apply_filters('wpml_default_language', NULL );
                if ($sdstudio_current_post_lang !== $LocaleCurentSiteLaguage_GLOBAL){
                    $url_end =  '/'.$sdstudio_current_post_lang;
                }
            }

            $HTML = str_replace('{{%THIS_SITE%}}','<a href="'.$url_this_site.$url_end.'" >'.$url_this_site.$url_end.'</a>',$HTML);


            $HTML .= '<div class="rank-math-html-sitemap">';

            /***
             * POSTS
             */
            $HTML .= '<div class="rank-math-html-sitemap__section rank-math-html-sitemap__section--post-type rank-math-html-sitemap__section--post">';
            $HTML .= '    <h2 class="rank-math-html-sitemap__title">'.$title_post.'</h2>';
            $HTML .= '<ul class="rank-math-html-sitemap__list">';

            $query = new WP_Query( array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'order' => 'ASC',
                'orderby' => 'date',
//                'fields' => 'ids'
            ));


            /**
             * Получаем ID постов которые нужно исключить из вывода
             */
            $redux = get_option( 'redux_sds_options_and_settings' );
            $HTML_SITEMAP_SLUG_EXCLUDE_ID_POSTS = $redux['HTML_SITEMAP_SLUG_EXCLUDE_ID_POSTS__auto_gen_pages_shortcodes_sds-options-and-settings'];
            $HTML_SITEMAP_SLUG_EXCLUDE_ID_POSTS = str_replace(' ','',$HTML_SITEMAP_SLUG_EXCLUDE_ID_POSTS);

            $term_exclude = null;
            $term_add_in_exclude_posts = [];

            global $sitepress;
            if (strpos($HTML_SITEMAP_SLUG_EXCLUDE_ID_POSTS, ',') !== false){
                $term_exclude = explode(',',$HTML_SITEMAP_SLUG_EXCLUDE_ID_POSTS);
                /***
                 * Добавляем переводы
                 */
                foreach ($term_exclude as $term){
                    // Получаем переводы категории
                    $element_type = 'post_post';
                    $trid = $sitepress->get_element_trid((int)$term, $element_type);
                    $translation_terms = $sitepress->get_element_translations($trid, $element_type);

                    if ($translation_terms){
                        foreach ($translation_terms as $add_translation_excludes){
                            $term_add_in_exclude_posts[] = $add_translation_excludes->element_id;
                        }
                    } else {
                        $term_add_in_exclude_posts[] = $term;
                    }
                }



            } else if ($HTML_SITEMAP_SLUG_EXCLUDE_ID_POSTS && $HTML_SITEMAP_SLUG_EXCLUDE_ID_POSTS !== ""){
                $term_add_in_exclude_posts[] = $HTML_SITEMAP_SLUG_EXCLUDE_ID_POSTS;
            }


            foreach ($query->posts as $post){
//                <span class="rank-math-html-sitemap__date">'.$post->post_date.'</span>
                if ($term_add_in_exclude_posts && !in_array($post->ID,$term_add_in_exclude_posts ) || $HTML_SITEMAP_SLUG_EXCLUDE_ID_POSTS == "") {
                    $HTML .= '          <li class="rank-math-html-sitemap__item">
                                  <a href="' . get_permalink($post->ID) . '" data_ind="' . $post->ID . '" class="rank-math-html-sitemap__link" target="_blank">' . $post->post_title . '</a>
                                </li>';
                }
            }

            $HTML .= '</ul>';
            $HTML .= '</div>';

            /***
             * CATEGORIES
             */
            $HTML .= '<div class="rank-math-html-sitemap__section rank-math-html-sitemap__section--taxonomy rank-math-html-sitemap__section--category">';
            $HTML .= '    <h2 class="rank-math-html-sitemap__title">'.$title_categories.'</h2>';
            $HTML .= '<ul class="rank-math-html-sitemap__list">';




            $args = [
//            'show_option_all'    => 'Усі',
                'orderby' => 'count',
                'order' => 'DESC',
                'hide_empty' => 0,
                'selected' => isset($_REQUEST['wp_dropdown_categories']) ? $_REQUEST['wp_dropdown_categories'] : '',
                'hierarchical' => 1,
                'name' => 'wp_dropdown_categories',
                'taxonomy' => 'category',
                'hide_if_empty' => true,
                // Запрещаем вывод всего списка категорий в HTML документа
                'echo' => false,
                'value_field' => array('term_id', 'description', 'parent')
            ];

            $all_get_terms = wp_dropdown_categories($args);
            $all_get_terms = preg_replace("/<select(.+?)>/","", $all_get_terms);
            $all_get_terms = preg_replace("/<\/select>/","", $all_get_terms);
            $all_get_terms = explode("\n", $all_get_terms);


            /**
             * Получаем ID категорий которіе нужно исключить из вівода
             */
            $redux = get_option( 'redux_sds_options_and_settings' );
            $HTML_SITEMAP_SLUG_EXCLUDE_ID_TERMS = $redux['HTML_SITEMAP_SLUG_EXCLUDE_ID_TERMS__auto_gen_pages_shortcodes_sds-options-and-settings'];
            $HTML_SITEMAP_SLUG_EXCLUDE_ID_TERMS = str_replace(' ','',$HTML_SITEMAP_SLUG_EXCLUDE_ID_TERMS);

            $term_exclude = null;
            $term_add_in_exclude = [];

            global $sitepress;
            if (strpos($HTML_SITEMAP_SLUG_EXCLUDE_ID_TERMS, ',') !== false){
                $term_exclude = explode(',',$HTML_SITEMAP_SLUG_EXCLUDE_ID_TERMS);
                /***
                 * Добавляем переводы
                 */
                foreach ($term_exclude as $term){
                    // Получаем переводы категории
                    $element_type = 'tax_category';
                    $trid = $sitepress->get_element_trid((int)$term, $element_type);
                    $translation_terms = $sitepress->get_element_translations($trid, $element_type);

                    if ($translation_terms){
                        foreach ($translation_terms as $add_translation_excludes){
                            $term_add_in_exclude[] = $add_translation_excludes->element_id;
                        }
                    } else {
                        $term_add_in_exclude[] = $term;
                    }
                }



            } else if ($HTML_SITEMAP_SLUG_EXCLUDE_ID_TERMS && $HTML_SITEMAP_SLUG_EXCLUDE_ID_TERMS !== ""){
                $term_add_in_exclude[] = $HTML_SITEMAP_SLUG_EXCLUDE_ID_TERMS;
            }
                foreach ($all_get_terms as $get_term) {
                    if ($get_term !== "")  {
                        $id_term = explode('value="', $get_term)[1];
                        $id_term = explode('">', $id_term)[0];

                        $title_term = explode('</option>', $get_term)[0];
                        $title_term = explode('">', $title_term)[1];

                        if ($term_add_in_exclude && !in_array($id_term,$term_add_in_exclude ) || $HTML_SITEMAP_SLUG_EXCLUDE_ID_TERMS == ""){
                            $HTML .= '          <li class="rank-math-html-sitemap__item">
                                          <a href="' . get_term_link((int)$id_term, 'category') . '" class="rank-math-html-sitemap__link"  data_ind="' . $id_term . '" target="_blank">' . $title_term . '</a>
                                          
                                        </li>';
                        }
                    }
                }
            $HTML .= '</ul>';
            $HTML .= '</div>';

            $HTML .= '</div>';
        }
    
        $HTML = str_replace('{{%EMAIL%}}','<a href="mailto:'.$email.'">'.$email.'</a>',$HTML);
        $HTML = str_replace('{{%THIS_SITE%}}','<a href="'.$url_this_site.'">'.$url_this_site.'</a>',$HTML);
    

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

            //HTML_SITEMAP
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

            //HTML_SITEMAP
            if (strpos($post->post_content, '[SDStudio_PAGE_AUTOGEN page="HTML_SITEMAP"]') !== false) {
                $HTML = file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__html_sitemap/'.$current_lang.'.md');
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
            //HTML_SITEMAP
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

//}

}