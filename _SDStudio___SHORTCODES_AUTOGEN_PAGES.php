<?php
include_once(ABSPATH . 'wp-includes/pluggable.php');
/**
 * REDUX - Захват опций темы
 */
$redux = get_option( 'redux_sds_options_and_settings' );

//dd($redux);

global $email_auto_gen_pages_shortcodes_sds_options_and_settings;
$email_auto_gen_pages_shortcodes_sds_options_and_settings = $redux['email_auto_gen_pages_shortcodes_sds-options-and-settings'];





if ($enable_jivosite_sds_options_and_settings == 1 && !empty($enable_jivosite_sds_options_and_settings)) {

}


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






// Email для страниц
$email = $email_auto_gen_pages_shortcodes_sds_options_and_settings;
if (empty($email)){
    $email = 'info@'.$_SERVER['HTTP_HOST']; // "info@domain.com"
}

// Ссылка на главную страницу сайта
$protocol = is_ssl() === TRUE ? 'https' : 'http';
$url_this_site = $protocol . '://' . $_SERVER['HTTP_HOST']; // "https://domain.com"




//SDStudio_PAGE_AUTOGEN page="OTKAZ"

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
    }
    if ($page_shortcode == "KONTACTS"){
        $HTML = $MarkdownParser->parse(file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__contacts/'.$current_lang.'.md'));
    }
    if ($page_shortcode == "KONF"){
        $HTML = $MarkdownParser->parse(file_get_contents(dirname(__FILE__) . '/_markdown/_SHORTCODE__politika_conf/'.$current_lang.'.md'));
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
    $HTML = $HTML.'<style>li.bf-breadcrumb-item.bf-breadcrumb-end {display: none !important;}</style>';



    return $HTML;
});


function pppp_title_update( $title, $id = null ) {

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

    if ( ! is_admin() ) {
        if(is_singular(array('page'))){
            if(in_the_loop()){
                $page_id = get_the_ID();
                // Получаем контент
                $get_content = get_post($page_id);


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

            }
        }
    }

    return $title;
}
add_filter( 'the_title', 'pppp_title_update', 10, 2 );

//%%sdstudio_autogen__disclamer%%
//gdpr_cookie_law_more