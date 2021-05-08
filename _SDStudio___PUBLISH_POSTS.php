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




