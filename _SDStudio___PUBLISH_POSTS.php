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

/***
 *
 */
if ($enable_editposts_relfollow_posts_sds_options_and_settings == 1) {
    if (!function_exists('sdstudio_add_relfollow_in_link')) {
        add_action('after_wp_tiny_mce', 'sdstudio_add_relfollow_in_link');
        function sdstudio_add_relfollow_in_link() {
            ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    if (typeof tinymce !== 'undefined' && typeof _ !== 'undefined' && typeof wpLink !== 'undefined') {
                        const linkOptions = document.querySelector('#link-options');
                        if (linkOptions) {
                            const newCheckboxes = `
                                <div class="link-rel-attributes" style="
                                    display: block;
                                    max-width: 217px;
                                    margin: 0 auto;
                                    border-top: 2px grey dashed;
                                    margin-top: 10px;
                                ">
                                    <label><input type="checkbox" id="wp-link-follow" /><strong style="color:green">💸 Установить <code>rel="follow"</code></strong></label>
                                    <label><input type="checkbox" id="wp-link-dofollow" />📌 Установить  <code>rel="dofollow"</code></label>
                                    <label><input type="checkbox" id="wp-link-no-rel" /> <strong>❌ Без атрибуту rel</strong></label>
                                    <label><input type="checkbox" id="wp-link-ugc" /> Добавить <code>rel="ugc"</code></label>
                                    <label><input type="checkbox" id="wp-link-noopener" /> Добавить <code>rel="noopener"</code></label>
                                    <label><input type="checkbox" id="wp-link-noreferrer" /> Добавить <code>rel="noreferrer"</code></label>
                                    <label><input type="checkbox" id="wp-link-bookmark" /> Добавить <code>rel="bookmark"</code></label>
                                    <label><input type="checkbox" id="wp-link-alternate" /> Добавить <code>rel="alternate"</code></label>
                                    <label><input type="checkbox" id="wp-link-author" /> Добавить <code>rel="author"</code></label>
                                    <label><input type="checkbox" id="wp-link-canonical" /> Добавить <code>rel="canonical"</code></label>
                                    <label><input type="checkbox" id="wp-link-help" /> Добавить <code>rel="help"</code></label>
                                    <label><input type="checkbox" id="wp-link-license" /> Добавить <code>rel="license"</code></label>
                                    <label><input type="checkbox" id="wp-link-search" /> Добавить <code>rel="search"</code></label>
                                    <label><input type="checkbox" id="wp-link-prev" /> Добавить <code>rel="prev"</code></label>
                                    <label><input type="checkbox" id="wp-link-next" /> Добавить <code>rel="next"</code></label>
                                </div>
                            `;
                            linkOptions.insertAdjacentHTML('beforeend', newCheckboxes);

                            const originalWpLink = Object.assign({}, wpLink);

                            wpLink.getAttrs = function() {
                                const attrs = originalWpLink.getAttrs();

                                // Видаляємо атрибут rel, якщо вибрано "Без атрибуту rel"
                                if (document.getElementById('wp-link-no-rel').checked) {
                                    delete attrs.rel;
                                    return attrs;
                                }

                                const relAttrs = [];
                                if (document.getElementById('wp-link-follow').checked) relAttrs.push('follow');
                                if (document.getElementById('wp-link-dofollow').checked) relAttrs.push('dofollow');
                                if (document.getElementById('wp-link-ugc').checked) relAttrs.push('ugc');
                                if (document.getElementById('wp-link-noopener').checked) relAttrs.push('noopener');
                                if (document.getElementById('wp-link-noreferrer').checked) relAttrs.push('noreferrer');
                                if (document.getElementById('wp-link-bookmark').checked) relAttrs.push('bookmark');
                                if (document.getElementById('wp-link-alternate').checked) relAttrs.push('alternate');
                                if (document.getElementById('wp-link-author').checked) relAttrs.push('author');
                                if (document.getElementById('wp-link-canonical').checked) relAttrs.push('canonical');
                                if (document.getElementById('wp-link-help').checked) relAttrs.push('help');
                                if (document.getElementById('wp-link-license').checked) relAttrs.push('license');
                                if (document.getElementById('wp-link-search').checked) relAttrs.push('search');
                                if (document.getElementById('wp-link-prev').checked) relAttrs.push('prev');
                                if (document.getElementById('wp-link-next').checked) relAttrs.push('next');

                                if (relAttrs.length > 0) {
                                    attrs.rel = relAttrs.join(' ');
                                } else {
                                    delete attrs.rel;
                                }

                                return attrs;
                            };

                            wpLink.mceRefresh = function(searchStr, text) {
                                originalWpLink.mceRefresh(searchStr, text);
                                const editor = tinymce.get(wpActiveEditor);
                                if (typeof editor !== 'undefined' && !editor.isHidden()) {
                                    const linkNode = editor.dom.getParent(editor.selection.getNode(), 'a[href]');
                                    if (linkNode) {
                                        const rel = editor.dom.getAttrib(linkNode, 'rel');
                                        const relAttrs = rel.split(' ');

                                        document.getElementById('wp-link-no-rel').checked = rel === '';
                                        document.getElementById('wp-link-follow').checked = relAttrs.includes('follow');
                                        document.getElementById('wp-link-dofollow').checked = relAttrs.includes('dofollow');
                                        document.getElementById('wp-link-ugc').checked = relAttrs.includes('ugc');
                                        document.getElementById('wp-link-noopener').checked = relAttrs.includes('noopener');
                                        document.getElementById('wp-link-noreferrer').checked = relAttrs.includes('noreferrer');
                                        document.getElementById('wp-link-bookmark').checked = relAttrs.includes('bookmark');
                                        document.getElementById('wp-link-alternate').checked = relAttrs.includes('alternate');
                                        document.getElementById('wp-link-author').checked = relAttrs.includes('author');
                                        document.getElementById('wp-link-canonical').checked = relAttrs.includes('canonical');
                                        document.getElementById('wp-link-help').checked = relAttrs.includes('help');
                                        document.getElementById('wp-link-license').checked = relAttrs.includes('license');
                                        document.getElementById('wp-link-search').checked = relAttrs.includes('search');
                                        document.getElementById('wp-link-prev').checked = relAttrs.includes('prev');
                                        document.getElementById('wp-link-next').checked = relAttrs.includes('next');
                                    }
                                }
                            };

                            document.querySelectorAll('.link-rel-attributes input[type="checkbox"]').forEach(checkbox => {
                                checkbox.addEventListener('change', function() {
                                    if (this.checked && this.id !== 'wp-link-no-rel') {
                                        document.getElementById('wp-link-no-rel').checked = false;
                                    } else if (this.id === 'wp-link-no-rel' && this.checked) {
                                        document.querySelectorAll('.link-rel-attributes input[type="checkbox"]').forEach(cb => {
                                            if (cb.id !== 'wp-link-no-rel') cb.checked = false;
                                        });
                                    }
                                });
                            });

                            document.getElementById('wp-link-no-rel').addEventListener('change', function() {
                                if (this.checked) {
                                    // Знімаємо всі інші чекбокси
                                    document.querySelectorAll('.link-rel-attributes input[type="checkbox"]').forEach(cb => {
                                        if (cb !== this) cb.checked = false;
                                    });

                                    // Видаляємо атрибут rel з поточного посилання
                                    const editor = tinymce.get(wpActiveEditor);
                                    if (editor && !editor.isHidden()) {
                                        const linkNode = editor.dom.getParent(editor.selection.getNode(), 'a[href]');
                                        if (linkNode) {
                                            editor.dom.setAttrib(linkNode, 'rel', null);
                                        }
                                    }
                                }
                            });

                            const exclusiveCheckboxes = ['wp-link-follow', 'wp-link-dofollow', 'wp-link-no-rel'];
                            exclusiveCheckboxes.forEach(id => {
                                document.getElementById(id).addEventListener('change', function() {
                                    if (this.checked) {
                                        exclusiveCheckboxes.forEach(cbId => {
                                            if (cbId !== this.id) {
                                                document.getElementById(cbId).checked = false;
                                            }
                                        });
                                    }
                                });
                            });
                        }
                    }
                });
            </script>
            <style>
                #wp-link #link-options .link-rel-attributes {
                    padding: 3px 0 0;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
                #wp-link #link-options .link-rel-attributes label {
                    display: block;
                    margin-bottom: 5px;
                }
                .has-text-field #wp-link .query-results {
                    top: 500px;
                }
                div#most-recent-results {
                    display: contents;
                }
            </style>
            <?php
        }
    }
}
