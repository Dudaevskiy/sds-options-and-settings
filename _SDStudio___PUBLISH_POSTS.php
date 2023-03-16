<?php
/**
 * REDUX - Захват опций темы
 */
$redux = get_option( 'redux_sds_options_and_settings' );

// Отключить отображение во всю ширину в редакторе Gutenberg
global $enable_disable_full_width_guthenberg_sds_options_and_settings;
$enable_disable_full_width_guthenberg_sds_options_and_settings = $redux['enable_disable_full_width_guthenberg_sds-options-and-settings'];




// Активация опции настройки публикации записей
global $enable_publish_posts_sds_options_and_settings;
$enable_publish_posts_sds_options_and_settings = $redux['enable_publish_posts_sds-options-and-settings'];

// Enable
global $publish_posts_only_select_users_enable_publish_posts_sds_options_and_settings;
$publish_posts_only_select_users_enable_publish_posts_sds_options_and_settings = $redux['publish_posts_only_select_users_enable_publish_posts_sds-options-and-settings'];

// Emails
global $email_users_publish_sdstudio_editor_tools;
$email_users_publish_sdstudio_editor_tools = $redux['email_users_publish_posts_only_select_users_enable_publish_posts_sds-options-and-settings'];


// Emails
global $enable_editposts_relfollow_posts_sds_options_and_settings;
$enable_editposts_relfollow_posts_sds_options_and_settings = $redux['enable_editposts_relfollow_posts_sds-options-and-settings'];

// RankMatch KeyWords
global $enable_editposts_rankmatch_keywords_posts_sds;
$enable_editposts_rankmatch_keywords_posts_sds = $redux['enable_editposts_rankmatch_keywords_posts_sds-options-and-settings'];

if ($enable_editposts_rankmatch_keywords_posts_sds == 1){
    /**
    /**
     * Add <meta name="keywords" content="focus keywords">.
     */
    add_filter( 'rank_math/frontend/show_keywords', '__return_true');
}



if ($enable_disable_full_width_guthenberg_sds_options_and_settings == 1){
    /**
     * Отключаем отображение поста в полную ширину для Guthenberg
     */
    if (is_admin()) {
        function jba_disable_editor_fullscreen_by_default() {
            $script = "jQuery( window ).load(function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } });";
            wp_add_inline_script( 'wp-blocks', $script );
        }
        add_action( 'enqueue_block_editor_assets', 'jba_disable_editor_fullscreen_by_default' );
    }
}


if ($enable_publish_posts_sds_options_and_settings == 1) {


    /**
     * Не публиковать записи и страницы если не установлены обложки
     */
    if ($redux['email_users_publish_posts_only_select_users_enable_publish_posts_sds-options-and-settings'] == 1){

        //требование обязательной установки миниатюры записи end
        add_action('save_post', 'sdstudio_ed_tools_wph_require_featured_image', -1);

        //требование обязательной установки миниатюры записи start
        function sdstudio_ed_tools_wph_require_featured_image($post_id) {

            // dd('qwdwd');


            $post = get_post($post_id);

            if($post->post_type == 'post' && $post->post_status == 'publish' && !has_post_thumbnail($post_id) || $post->post_type == 'page' && $post->post_status == 'publish' && !has_post_thumbnail($post_id)) {

                // if ($post->post_type !== 'post' || $post->post_type !== 'page' ){
                // return false;
                // }
                $post->post_status = 'draft';
                // dd($post->post_status);
                wp_update_post($post);

                $message = '<p>Запись не опубликована, так как не была установлена миниатюра записи!</p><p><a href="' . admin_url('post.php?post=' .
                        $post_id . '&action=edit') . '">Вернуться назад и установить 
        миниатюру</a></p>';
                wp_die($message, 'Ошибка - отсутствует миниатюра!');
            }
        }

    }






    if ($publish_posts_only_select_users_enable_publish_posts_sds_options_and_settings == 1 && !empty($email_users_publish_sdstudio_editor_tools)) {
//        if (is_admin()){

//            var_dump($email_users_publish_sdstudio_editor_tools);
            add_action( 'save_post', 'CheckCurrentUserForPublishPosts', 10, 3 );
            function CheckCurrentUserForPublishPosts( $post_ID, $post ) {
                if( $post->post_type == 'post' || $post->post_type == 'page' ) {

                    if ($post->post_status == 'trash'){
                        return false;
                    }
                    /**
                     * Получаем текущего пользователя
                     */
                    $current_user = wp_get_current_user();
                    $user_email = $current_user->user_email;

                    /**
                     * @param $email_current_user - Email Текущего пользователя на сайте
                     * @param $email_in_options - Email пользователя(пользователей) в из опций плагина
                     * @return bool
                     */
                    if (!function_exists('check_email_this_user_sds'))   {
                            function check_email_this_user_sds($email_current_user, $email_in_options){
                                $email_users_publish_sdstudio_editor_tools = $email_in_options;
                                if (strpos($email_users_publish_sdstudio_editor_tools, ',') == false){
                                    if ($email_current_user == $email_users_publish_sdstudio_editor_tools){
                                        return true;
                                    } else {
                                        return false;
                                    }
                                } else {
                                    $tmp = false;
                                    $email_users_publish_sdstudio_editor_tools = explode(',',$email_users_publish_sdstudio_editor_tools);

                                    foreach ($email_users_publish_sdstudio_editor_tools as $email){
                                        if ($email == $email_current_user){
                                            $tmp = true;
                                        }
                                    }
                                    if ($tmp == true){
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
                            }


                            /**
                             * Делаем проверку пользователя
                             */
                            global $email_users_publish_sdstudio_editor_tools;
                            if (check_email_this_user_sds($user_email,$email_users_publish_sdstudio_editor_tools) !== true){
                                global $post;
                                $get_post = get_post($post_ID);
                                $post_type = $get_post->post_type;

                                $update_post = array(
                                    'post_type' => $post_type,
                                    'ID' => $post_ID,
                                    'post_status' => 'pending',
                                );
                                // Присваиваем посту статус на утверждении
                                wp_update_post($update_post);
                            }
                    }
                }
            }

    }

}

/**
 * Rel follow
 */
if ($enable_editposts_relfollow_posts_sds_options_and_settings == 1){
    /**
     * Add a 'Add rel="follow" to link' checkbox to the WordPress link editor
     *
     * @see https://danielbachhuber.com/tip/rel-follow-link-modal/
     */
    if (!function_exists('sdstudio_add_relfollow_in_link')){
        add_action( 'after_wp_tiny_mce', 'sdstudio_add_relfollow_in_link');
        function sdstudio_add_relfollow_in_link(){
            ?>
            <script>
                // Отключаем nofollow если отмечен follow
                jQuery(document).on('click', 'input#wp-link-follow', function() {
                    if( jQuery(this).is(':checked'))  //  or  this.checked
                    {
                        jQuery('input#wp-link-nofollow').attr("disabled", true);
                    } else {
                        jQuery('input#wp-link-nofollow').removeAttr("disabled");
                    }
                });


                // Отключаем follow если отмечен nofollow
                jQuery(document).on('click', 'input#wp-link-nofollow', function() {
                    if( jQuery(this).is(':checked'))  //  or  this.checked
                    {
                        jQuery('input#wp-link-follow').attr("disabled", true);
                    } else {
                        jQuery('input#wp-link-follow').removeAttr("disabled");
                    }
                });



                var originalWpLink;
                // Ensure both TinyMCE, underscores and wpLink are initialized
                if ( typeof tinymce !== 'undefined' && typeof _ !== 'undefined' && typeof wpLink !== 'undefined' ) {
                    // Ensure the #link-options div is present, because it's where we're appending our checkbox.
                    if ( tinymce.$('#link-options').length ) {
                        // Append our checkbox HTML to the #link-options div, which is already present in the DOM.
                        tinymce.$('#link-options').append(<?php echo json_encode( '<div class="link-follow"><label><span></span><input type="checkbox" id="wp-link-follow" /> Добавить  <code style="color:green">rel="follow"</code></label></div>' ); ?>);
                        // Clone the original wpLink object so we retain access to some functions.
                        originalWpLink = _.clone( wpLink );
                        wpLink.addRelfollow = tinymce.$('#wp-link-follow');
                        // Override the original wpLink object to include our custom functions.
                        wpLink = _.extend( wpLink, {
                            /**
                             * Fetch attributes for the generated link based on
                             * the link editor form properties.
                             *
                             * In this case, we're calling the original getAttrs()
                             * function, and then including our own behavior.
                             */
                            getAttrs: function() {
                                console.log('1️⃣');
                                var attrs = originalWpLink.getAttrs();

                                if (!jQuery('input#wp-link-sponsored').is(":checked")){
                                    attrs.rel = '';
                                }

                                attrs.rel = wpLink.addRelfollow.prop( 'checked' ) ? 'follow' : '';

                                if (jQuery('input#wp-link-nofollow').is(":checked")){
                                    attrs.rel = 'nofollow'
                                }

                                if (jQuery('input#wp-link-sponsored').is(":checked")){
                                    attrs.rel = attrs.rel+' sponsored'
                                }

                                console.log(attrs);
                                return attrs;
                            },
                            /**
                             * Build the link's HTML based on attrs when inserting
                             * into the text editor.
                             *
                             * In this case, we're completely overriding the existing
                             * function.
                             */
                            buildHtml: function( attrs ) {
                                console.log('2️⃣');
                                var html = '<a href="' + attrs.href + '"';

                                if ( attrs.target ) {
                                    html += ' target="' + attrs.target + '"';
                                }
                                if ( attrs.rel ) {
                                    html += ' rel="' + attrs.rel + '"';
                                }
                                return html + '>';
                            },
                            /**
                             * Set the value of our checkbox based on the presence
                             * of the rel='follow' link attribute.
                             *
                             * In this case, we're calling the original mceRefresh()
                             * function, then including our own behavior
                             */
                            mceRefresh: function( searchStr, text ) {
                                console.log('2️⃣');
                                originalWpLink.mceRefresh( searchStr, text );
                                var editor = window.tinymce.get( window.wpActiveEditor )
                                if ( typeof editor !== 'undefined' && ! editor.isHidden() ) {
                                    var linkNode = editor.dom.getParent( editor.selection.getNode(), 'a[href]' );
                                    if ( linkNode ) {
                                        wpLink.addRelfollow.prop( 'checked', 'follow' === editor.dom.getAttrib( linkNode, 'rel' ) );
                                        if (jQuery(linkNode).attr('rel') === 'follow noopener'
                                            || jQuery(linkNode).attr('rel') === 'follow noopener sponsored'
                                            || jQuery(linkNode).attr('rel') === 'follow sponsored'){
                                            jQuery('input#wp-link-follow').prop('checked', true);
                                            // Отключаем nofollow
                                            jQuery('input#wp-link-follow').removeAttr("disabled");
                                            jQuery('input#wp-link-nofollow').attr("disabled", true);
                                        }

                                        // if (jQuery(linkNode).attr('rel') === 'nofollow noopener'
                                        //     || jQuery(linkNode).attr('rel') === 'nofollow noopener sponsored'
                                        //     || jQuery(linkNode).attr('rel') === 'nofollow sponsored'){
                                        //     // Отключаем follow
                                        //     jQuery('input#wp-link-nofollow').removeAttr("disabled");
                                        //     jQuery('input#wp-link-follow').attr("disabled", true);
                                        // }
                                    }
                                }
                            }
                        });
                    }
                }
            </script>
            <style>
                #wp-link #link-options .link-follow {
                    padding: 3px 0 0;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
                #wp-link #link-options .link-follow label span {
                    width: 83px;
                }

                .has-text-field #wp-link .query-results {
                    top: 223px;
                }
            </style>
            <?php
        }
    }
}

