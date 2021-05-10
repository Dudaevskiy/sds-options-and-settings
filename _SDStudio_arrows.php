<?php
// В данном случае обязательно используем wp-load
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
//include_once(ABSPATH . 'wp-includes/pluggable.php');
$redux = get_option('redux_sds_options_and_settings');

// URL - Logo
global $enable_arrows_pages_sds_options_and_settings;
$enable_arrows_pages_sds_options_and_settings = $redux['enable_arrows_pages_sds-options-and-settings'];

// Отображаем только для админа сайта
global $enable_arrows_only_for_admin_pages_sds_options_and_settings;
$enable_arrows_only_for_admin_pages_sds_options_and_settings = $redux['enable_arrows_only_for_admin_pages_sds-options-and-settings'];



if ($enable_arrows_pages_sds_options_and_settings == 1){

    if ($enable_arrows_only_for_admin_pages_sds_options_and_settings == 1){
        include_once(ABSPATH . 'wp-includes/pluggable.php');
        if ( !current_user_can( 'administrator' ) ) {

            return false;
//            add_action( 'admin_bar_menu', 'wpse17689_admin_bar_menu' );
        }
//        function wpse17689_admin_bar_menu( $wp_admin_bar )
//        {
//
//    //// MAGIC
//
//        }
    }




    /**
     * Подключаем Eleganttips
     * https://eleganttips.herokuapp.com/
     *
     */

        add_action('init', 'SDStudio_content_assistant__Eleganttips_css');
        function SDStudio_content_assistant__Eleganttips_css() {
            // IMAGES
            //wp_enqueue_script('SDStudio_content_assistant__IMAGES', SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL . '__IMAGES.js');
            // tooltipster
//            wp_enqueue_script('tipso_js', SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL . '_tipso/src/tipso.js');
            //        wp_enqueue_script('tooltipster_js', SDS_EDITOR_TOOLS__PLUGIN_URL . 'tooltipster/dist/js/tooltipster.bundle.js');
            wp_register_style('Eleganttips_css', SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL . '_eleganttips/eleganttips.min.css');
            //        wp_register_style('SweetAlert2_CUSTOM', SDS_EDITOR_TOOLS__PLUGIN_URL . 'sweetalert2/__SweetAlert2_CUSTOM.css');
        }
        add_action('wp_enqueue_scripts', 'SDStudio_content_assistant__Eleganttips_css_enqueue');
        function SDStudio_content_assistant__Eleganttips_css_enqueue(){
            wp_enqueue_style('Eleganttips_css');
        }


    /**
     * Подключаем Tipso
     * Функция рабочая, просто пока не дописал всплывающие сообщения. Вот и отключил.
     */
//    if (!function_exists('SDStudio_content_assistant__other_scripts_css')){
//        add_action('init', 'SDStudio_content_assistant__other_scripts_css');
//        function SDStudio_content_assistant__other_scripts_css() {
//            // IMAGES
//            //wp_enqueue_script('SDStudio_content_assistant__IMAGES', SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL . '__IMAGES.js');
//            // tooltipster
//            wp_enqueue_script('tipso_js', SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL . '_tipso/src/tipso.js');
//            //        wp_enqueue_script('tooltipster_js', SDS_EDITOR_TOOLS__PLUGIN_URL . 'tooltipster/dist/js/tooltipster.bundle.js');
//            wp_register_style('tipso_css', SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL . '_tipso/src/tipso.css');
//            //        wp_register_style('SweetAlert2_CUSTOM', SDS_EDITOR_TOOLS__PLUGIN_URL . 'sweetalert2/__SweetAlert2_CUSTOM.css');
//        }
//        add_action('wp_enqueue_scripts', 'SDStudio_content_assistant__other_scripts_css_enqueue_style');
//        function SDStudio_content_assistant__other_scripts_css_enqueue_style(){
//            wp_enqueue_style('tipso_css');
//        }
//    }



    add_action("wp_head", "wp_head_css");
    function wp_head_css()
    {
//        global $post;

        if(is_single()) {
            /**
             * Функция для получения следующей и предидущейщей ссылки для любого типа постов
             * @param string $direction
             * @param string $type
             * @param $current
             * @return mixed|string
             * https://bit.ly/3eAYFeZ
             * custom_posttype_get_adjacent_ID('prev', 'project', get_the_ID());
             */
            function custom_posttype_get_adjacent_ID($direction = 'prev', $type, $current) {
                // Получаем статус поста
                $post_id = get_the_ID();
                $post_data = get_postdata($post_id);
                $post_status = $post_data['post_status'];

                // Get all posts with this custom post type
                $query = array(
                    'post_type'=> $type,
                    'post_status' => $post_status,
                    'posts_per_page' => -1,
                    'orderby' => 'publish_date',
                    'order' => 'ASC',
                    // Получаем только ID
                    'fields' => 'ids',
                );
                global $sitepress;
                // ✅ WPML ENABLE
                if ($sitepress && $query['post_type'] !== 'orig_post') {
                    // Применение данного фильтра исключает дублирование постов в запросе
                    $query['suppress_filters'] = '0';

                    $current_lang = $sitepress->get_current_language();
                    $sitepress->switch_lang($current_lang );
                }

//                dd($query);

                $posts  = get_posts($query);

                // Получаем первый и последний элемент
                $firstEle = $posts[0];
                $lastEle = $posts[count($posts) - 1];
                // Общая длинна массива
                $postsLength = sizeof($posts)-1;

                $currentIndex = 0;
                $index = 0;
                $result = 0;

                // Iterate all posts in order to find the current one
                foreach($posts as $p){
                    if($p == $current) $currentIndex = $index;
                    $index++;
                }

                if($direction == 'prev') {
                    // If it's 'prev' return the previous one unless it's the first one, in this case return the last.
                    $result = !$currentIndex ? $posts[$postsLength] : $posts[$currentIndex - 1];
                    // Если это последний пост с текущим статусом то присваиваем #
                    if ($result == $lastEle){
                        $result = '#';
                    }
                } else {
                    // If it's 'next' return the next one unless it's the last one, in this case return the first.
                    $result = $currentIndex == $postsLength ? $posts[0] : $posts[$currentIndex + 1];
                    // Если это первый пост с текущим статусом то присваиваем #
                    if ($result == $firstEle){
                        $result = '#';
                    }
                }
                return $result;
            }

            /**
             * Получаем номер в списке среди постов для next & prev
             * @param $direction - next || prev
             * @param string $type - post
             * @param $current - post_id
             */
            global $SDStudio_PostsLength;
            function CURRENT_NUM_in_posts_get_adjacent_ID($direction, $type)
            {
//                dd($type);
                // Получаем статус поста
                $post_id = get_the_ID();
                $post_data = get_postdata($post_id);
                $post_status = $post_data['post_status'];



                // Get all posts with this custom post type
                $query = array(
                    'post_type' => $type,
                    'post_status' => $post_status,
                    'posts_per_page' => -1,
                    'orderby' => 'publish_date',
                    'order' => 'ASC',
                    // Получаем только ID
                    'fields' => 'ids',
                );



                global $sitepress;
                // ✅ WPML ENABLE
                if ($sitepress && $query['post_type'] !== 'orig_post') {

                    // Применение данного фильтра исключает дублирование постов в запросе
                    $query['suppress_filters'] = '0';

                    $current_lang = $sitepress->get_current_language();
                    $sitepress->switch_lang($current_lang );
                }

//                dd($query);


                $posts = get_posts($query);
                // Получаем первый и последний элемент
                $firstEle = $posts[0];
                $lastEle = $posts[count($posts) - 1];
                // Общая длинна массива
                global $SDStudio_PostsLength;
                $SDStudio_PostsLength = sizeof($posts) - 1;
                $postsLength = sizeof($posts) - 1;


                $currentIndex = 0;
                $index = 0;
                $result = 0;

                // Iterate all posts in order to find the current one
                foreach ($posts as $p) {
                    if ($p == $post_id) $currentIndex = $index;
                    $index++;
                }
                if($direction == 'prev') {
                    // If it's 'prev' return the previous one unless it's the first one, in this case return the last.
                    $result = $currentIndex - 1;
                    // Если это последний пост с текущим статусом то присваиваем #
                } else {
                    // If it's 'next' return the next one unless it's the last one, in this case return the first.
                    $result = $currentIndex + 1;
                    // Если это первый пост с текущим статусом то присваиваем #
                }
                return $result;
            }

            // Получаем статус поста
            $post_id = get_the_ID();
            $post_data = get_postdata($post_id);
            $post_type = $post_data['post_type'];
//            dd($post_type);
            $post_status = $post_data['post_status'];

            $prev_num = CURRENT_NUM_in_posts_get_adjacent_ID('prev', $type = $post_type);
            $next_num = CURRENT_NUM_in_posts_get_adjacent_ID('next', $type = $post_type);
            global $SDStudio_PostsLength;
            ?>
            <div id="sdstudio-editor-tools-next-prev-btns">
                <?php

                if ($post_status == 'publish'){
                    if ($post_type == 'post') {
                        $PrevLink = '/?p=' . custom_posttype_get_adjacent_ID('prev', $post_type, get_the_ID());
                        $NextLink = '/?p=' . custom_posttype_get_adjacent_ID('next', $post_type, get_the_ID());
                    } else if ($post_type == 'orig_post') {
                        $PrevLink = get_the_permalink( custom_posttype_get_adjacent_ID('prev', $post_type, get_the_ID())   );
                        $NextLink = get_the_permalink( custom_posttype_get_adjacent_ID('next', $post_type, get_the_ID())   );
                    }
                } else {
                    if ($post_type == 'post') {
                        // Для всех других статусов, делаем ссылку для просмотра
                        $PrevLink = '/?p='.custom_posttype_get_adjacent_ID('prev', $post_type, get_the_ID()).'&preview=true';
                        $NextLink = '/?p='.custom_posttype_get_adjacent_ID('next', $post_type, get_the_ID()).'&preview=true';
                    } else if ($post_type == 'orig_post') {
                        $PrevLink = get_the_permalink( custom_posttype_get_adjacent_ID('prev', $post_type, get_the_ID())   );
                        $NextLink = get_the_permalink( custom_posttype_get_adjacent_ID('next', $post_type, get_the_ID())   );
                    }
                }

                if (custom_posttype_get_adjacent_ID('prev', $post_type, get_the_ID())){
                    ?>
                    <div class="alignleft sdstudio_PrevLink">
                        <a href="<?php echo $PrevLink; ?>">
                            <button class="et" style="
                                border: none;
                                text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
                                background-color: transparent !important;
                            ">
                                                            «
                                <span class="et-right-bottom" style="
                                    border: none;
                                    background-color: white;
                                    max-width: 168px;
                                ">

                                    <span style="text-align: left;min-width: 100%;display: block;margin-top: -13px;"">
                                        <b><?php echo $prev_num?></b> из <?php echo $SDStudio_PostsLength?>
                                    </span>
                                    <hr style="
                                        margin-top: -10px;
                                        margin-bottom: 7px;
                                    ">
                                    <div style="
                                        line-height: 1.3;
                                        font-size: 14px;
                                    ">
                                        <b><?php echo get_the_title(custom_posttype_get_adjacent_ID('prev', $post_type, get_the_ID()))?></b>
                                    </div>

                                    <img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(custom_posttype_get_adjacent_ID('prev', $post_type, get_the_ID())))[0]?>" class="SDStudio-edit-img-image" style="max-width:150px;padding-top: 6px;">
                                </span>
                            </button>
                        </a>
                    </div>
                    <?
                }

                if (custom_posttype_get_adjacent_ID('next', $post_type, get_the_ID())){
                    ?>
                    <div class="alignright sdstudio_NextLink">
                        <a href="<?php echo $NextLink; ?>" title="<?php echo get_the_title(custom_posttype_get_adjacent_ID('next', $post_type, get_the_ID()))?>">
                            <button class="et" style="
                                text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
                                border: none;
                                background-color: transparent !important;
                            ">
                                &raquo;
                                <span class="et-left-bottom" style="
                                    border: none;
                                    background-color: white;
                                    max-width: 168px;
                                ">
                                    <span style="text-align: right;min-width: 100%;display: block;margin-top: -13px;">
                                        <b><?php echo $next_num?></b> из <?php echo $SDStudio_PostsLength?>
                                    </span>

                                    <hr style="
                                        margin-top: -10px;
                                        margin-bottom: 7px;
                                    ">
                                    <div style="
                                        line-height: 1.3;
                                        font-size: 14px;
                                    ">
                                        <b><?php echo get_the_title(custom_posttype_get_adjacent_ID('next', $post_type, get_the_ID()))?></b>
                                    </div>

                                    <img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(custom_posttype_get_adjacent_ID('next', $post_type, get_the_ID())))[0]?>" class="SDStudio-edit-img-image" style="max-width:150px;padding-top: 6px;">
                                </span>
                            </button>
                        </a>
                    </div>
                <?php
                }
?>
                <style>

                    div#sdstudio-editor-tools-next-prev-btns{
                        z-index:9999;
                        position:fixed;
                        width:100%;
                    }

                    div#sdstudio-editor-tools-next-prev-btns .alignleft a {
                        color: white;
                        line-height: 1.4em;
                        text-decoration: blink;
                        font-size: 2.5em;
                        position: absolute;
                        margin-left: 35px;
                        text-shadow:
                                -1px -1px 0 #000,
                                1px -1px 0 #000,
                                -1px 1px 0 #000,
                                1px 1px 0 #000;
                    }

                    div#sdstudio-editor-tools-next-prev-btns .alignright a {
                        color: white;
                        line-height: 1.4em;
                        text-decoration: blink;
                        font-size: 2.5em;
                        position: absolute;
                        margin-right: 35px;
                        right: 0px;
                        text-shadow:
                                -1px -1px 0 #000,
                                1px -1px 0 #000,
                                -1px 1px 0 #000,
                                1px 1px 0 #000;
                    }
                    @media screen and (max-width:800px){
                        div#sdstudio-editor-tools-next-prev-btns{
                            z-index:9999;
                            position:relative;
                            width:100%;
                        }

                        div#sdstudio-editor-tools-next-prev-btns .alignleft a {
                            color: #232f75;
                            margin-top:-10px;
                            line-height: 1.5em;
                            text-decoration: blink;
                            font-size: 2.5em;
                            position: absolute;
                            z-index:9;
                            margin-left: 15px;
                            text-shadow:none;
                            text-shadow:
                                    -1px -1px 0 white,
                                    1px -1px 0 white,
                                    -1px 1px 0 white,
                                    1px 1px 0 white;
                        }

                        div#sdstudio-editor-tools-next-prev-btns .alignright a {
                            color: #232f75;
                            margin-top:-10px;
                            line-height: 1.5em;
                            z-index:9;
                            text-decoration: blink;
                            font-size: 2.5em;
                            position: absolute;
                            margin-right: 15px;
                            text-shadow:none;
                            text-shadow:
                                    -1px -1px 0 white,
                                    1px -1px 0 white,
                                    -1px 1px 0 white,
                                    1px 1px 0 white;
                        }


                        div#sdstudio-editor-tools-next-prev-btns .alignleft,
                        div#sdstudio-editor-tools-next-prev-btns .alignright{
                            margin-top: 165px;
                            margin-bottom: -150px;
                        }
                        body div#sdstudio-editor-tools-next-prev-btns{
                            /* right:0px !important; */
                            /*z-index: 0;*/
                        }

                        div#sdstudio-editor-tools-next-prev-btns{
                            /*     display:none; */
                        }

                        .container-page-item-title{
                            margin-left:0px !important;
                            margin-right:0px !important;
                        }

                        body .container.container-page-item-title.aos-init.aos-animate .col-md-12.col-overlay .col-md-12 {
                            padding-top:0px !important;
                            padding-left: 20px !important;
                            padding-right: 20px !important;
                        }

                    }

                    /* Скрываем с пустыми значениями */
                    div.alignright a[href^="/?p=#"],
                    div.alignright a[href^="#"] {
                        display: none !important;
                    }
                    div.alignleft a[href^="/?p=#"],
                    div.alignleft a[href^="#"]{
                        display: none !important;
                    }
                </style>
            </div>

            <?php


        }
    }
//    }
//ddd(get_post_meta(9843));


}