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
 * Активація rel-атрибутів для редактора посилань
 * Рефакторінг: використовуємо події замість перевизначення методів wpLink
 */
if ($enable_editposts_relfollow_posts_sds_options_and_settings == 1) {
    if (!function_exists('sdstudio_add_relfollow_in_link')) {
        add_action('after_wp_tiny_mce', 'sdstudio_add_relfollow_in_link');
        function sdstudio_add_relfollow_in_link() {
            ?>
            <script>
                (function() {
                    'use strict';

                    var debugMode = false; // Встановіть true для ввімкнення відлагодження

                    // Ініціалізація функціоналу rel-атрибутів
                    function initRelAttributesEditor() {
                        if (debugMode) console.log('SDStudio: initRelAttributesEditor called');

                        // Перевіряємо наявність необхідних об'єктів
                        if (typeof tinymce === 'undefined' || typeof wpLink === 'undefined') {
                            if (debugMode) console.warn('SDStudio: tinymce or wpLink not defined');
                            return;
                        }

                        const linkOptions = document.querySelector('#link-options');
                        if (!linkOptions) {
                            if (debugMode) console.warn('SDStudio: #link-options not found');
                            return;
                        }

                        if (linkOptions.querySelector('.sdstudio-rel-wrapper')) {
                            if (debugMode) console.log('SDStudio: Already initialized');
                            return; // Вже ініціалізовано
                        }

                        if (debugMode) console.log('SDStudio: Initializing rel-attributes UI');

                        // Додаємо наші чекбокси в один компактний блок з Grid
                        const relAttributesHTML = `
                            <div class="sdstudio-rel-wrapper">
                                <div class="sdstudio-rel-item"><label><input type="checkbox" id="sdstudio-wp-link-follow" /><strong style="color:green">💸 <code>rel="follow"</code></strong></label></div>
                                <div class="sdstudio-rel-item"><label><input type="checkbox" id="sdstudio-wp-link-dofollow" />📌 <code>rel="dofollow"</code></label></div>
                                <div class="sdstudio-rel-item"><label><input type="checkbox" id="sdstudio-wp-link-no-rel" /><strong>❌ Без rel</strong></label></div>
                                <div class="sdstudio-rel-item"><label><input type="checkbox" id="sdstudio-wp-link-ugc" /><code>rel="ugc"</code></label></div>
                                <div class="sdstudio-rel-item"><label><input type="checkbox" id="sdstudio-wp-link-noopener" /><code>rel="noopener"</code></label></div>
                                <div class="sdstudio-rel-item"><label><input type="checkbox" id="sdstudio-wp-link-noreferrer" /><code>rel="noreferrer"</code></label></div>
                                <div class="sdstudio-rel-item"><label><input type="checkbox" id="sdstudio-wp-link-bookmark" /><code>rel="bookmark"</code></label></div>
                                <div class="sdstudio-rel-item"><label><input type="checkbox" id="sdstudio-wp-link-alternate" /><code>rel="alternate"</code></label></div>
                                <div class="sdstudio-rel-item"><label><input type="checkbox" id="sdstudio-wp-link-author" /><code>rel="author"</code></label></div>
                                <div class="sdstudio-rel-item"><label><input type="checkbox" id="sdstudio-wp-link-canonical" /><code>rel="canonical"</code></label></div>
                                <div class="sdstudio-rel-item"><label><input type="checkbox" id="sdstudio-wp-link-help" /><code>rel="help"</code></label></div>
                                <div class="sdstudio-rel-item"><label><input type="checkbox" id="sdstudio-wp-link-license" /><code>rel="license"</code></label></div>
                                <div class="sdstudio-rel-item"><label><input type="checkbox" id="sdstudio-wp-link-search-rel" /><code>rel="search"</code></label></div>
                                <div class="sdstudio-rel-item"><label><input type="checkbox" id="sdstudio-wp-link-prev" /><code>rel="prev"</code></label></div>
                                <div class="sdstudio-rel-item"><label><input type="checkbox" id="sdstudio-wp-link-next" /><code>rel="next"</code></label></div>
                            </div>
                        `;
                        linkOptions.insertAdjacentHTML('beforeend', relAttributesHTML);

                        // Функція для отримання вибраних rel-атрибутів з чекбоксів
                        function getSelectedRelAttributes() {
                            try {
                                const noRelCheckbox = document.getElementById('sdstudio-wp-link-no-rel');
                                if (noRelCheckbox && noRelCheckbox.checked) {
                                    return null; // Без rel-атрибута
                                }

                                const relAttrs = [];
                                const relCheckboxes = {
                                    'sdstudio-wp-link-follow': 'follow',
                                    'sdstudio-wp-link-dofollow': 'dofollow',
                                    'sdstudio-wp-link-ugc': 'ugc',
                                    'sdstudio-wp-link-noopener': 'noopener',
                                    'sdstudio-wp-link-noreferrer': 'noreferrer',
                                    'sdstudio-wp-link-bookmark': 'bookmark',
                                    'sdstudio-wp-link-alternate': 'alternate',
                                    'sdstudio-wp-link-author': 'author',
                                    'sdstudio-wp-link-canonical': 'canonical',
                                    'sdstudio-wp-link-help': 'help',
                                    'sdstudio-wp-link-license': 'license',
                                    'sdstudio-wp-link-search-rel': 'search',
                                    'sdstudio-wp-link-prev': 'prev',
                                    'sdstudio-wp-link-next': 'next'
                                };

                                for (const [id, value] of Object.entries(relCheckboxes)) {
                                    const checkbox = document.getElementById(id);
                                    if (checkbox && checkbox.checked) {
                                        relAttrs.push(value);
                                    }
                                }

                                return relAttrs.length > 0 ? relAttrs.join(' ') : '';
                            } catch (e) {
                                console.error('SDStudio getSelectedRelAttributes error:', e);
                                return '';
                            }
                        }

                        // Перевизначаємо wpLink.getAttrs ТІЛЬКИ ОДИН РАЗ
                        if (!wpLink._sdstudio_original_getAttrs) {
                            if (debugMode) console.log('SDStudio: Wrapping wpLink.getAttrs');
                            wpLink._sdstudio_original_getAttrs = wpLink.getAttrs;

                            wpLink.getAttrs = function() {
                                if (debugMode) console.log('SDStudio: getAttrs called');
                                const attrs = wpLink._sdstudio_original_getAttrs.call(this);
                                if (debugMode) console.log('SDStudio: Original attrs:', attrs);

                                // Додаємо rel-атрибути з наших чекбоксів
                                const customRel = getSelectedRelAttributes();
                                if (customRel === null) {
                                    // Користувач вибрав "Без атрибуту rel"
                                    delete attrs.rel;
                                } else if (customRel) {
                                    attrs.rel = customRel;
                                }

                                if (debugMode) console.log('SDStudio: Modified attrs:', attrs);
                                return attrs;
                            };
                        }

                        // Функція для оновлення стану чекбоксів на основі поточного посилання
                        function updateRelCheckboxes() {
                            try {
                                const editor = tinymce.get(wpActiveEditor);
                                if (!editor || editor.isHidden()) {
                                    return;
                                }

                                const linkNode = editor.dom.getParent(editor.selection.getNode(), 'a[href]');
                                const rel = linkNode ? (editor.dom.getAttrib(linkNode, 'rel') || '') : '';
                                const relAttrs = rel ? rel.split(' ').map(r => r.trim()).filter(Boolean) : [];

                                // Оновлюємо стан чекбоксів
                                const checkboxMap = {
                                    'sdstudio-wp-link-no-rel': rel === '',
                                    'sdstudio-wp-link-follow': relAttrs.includes('follow'),
                                    'sdstudio-wp-link-dofollow': relAttrs.includes('dofollow'),
                                    'sdstudio-wp-link-ugc': relAttrs.includes('ugc'),
                                    'sdstudio-wp-link-noopener': relAttrs.includes('noopener'),
                                    'sdstudio-wp-link-noreferrer': relAttrs.includes('noreferrer'),
                                    'sdstudio-wp-link-bookmark': relAttrs.includes('bookmark'),
                                    'sdstudio-wp-link-alternate': relAttrs.includes('alternate'),
                                    'sdstudio-wp-link-author': relAttrs.includes('author'),
                                    'sdstudio-wp-link-canonical': relAttrs.includes('canonical'),
                                    'sdstudio-wp-link-help': relAttrs.includes('help'),
                                    'sdstudio-wp-link-license': relAttrs.includes('license'),
                                    'sdstudio-wp-link-search-rel': relAttrs.includes('search'),
                                    'sdstudio-wp-link-prev': relAttrs.includes('prev'),
                                    'sdstudio-wp-link-next': relAttrs.includes('next')
                                };

                                for (const [id, checked] of Object.entries(checkboxMap)) {
                                    const checkbox = document.getElementById(id);
                                    if (checkbox) {
                                        checkbox.checked = checked;
                                    }
                                }
                            } catch (e) {
                                console.error('SDStudio updateRelCheckboxes error:', e);
                            }
                        }

                        // Слухаємо подію wplink-open для оновлення чекбоксів
                        jQuery(document).on('wplink-open', updateRelCheckboxes);

                        // Обробка взаємовиключних чекбоксів
                        const exclusiveCheckboxes = ['sdstudio-wp-link-follow', 'sdstudio-wp-link-dofollow', 'sdstudio-wp-link-no-rel'];
                        exclusiveCheckboxes.forEach(id => {
                            const checkbox = document.getElementById(id);
                            if (checkbox) {
                                checkbox.addEventListener('change', function() {
                                    if (this.checked) {
                                        exclusiveCheckboxes.forEach(cbId => {
                                            if (cbId !== id) {
                                                const cb = document.getElementById(cbId);
                                                if (cb) cb.checked = false;
                                            }
                                        });
                                    }
                                });
                            }
                        });

                        // Обробка чекбокса "Без атрибуту rel"
                        const noRelCheckbox = document.getElementById('sdstudio-wp-link-no-rel');
                        if (noRelCheckbox) {
                            noRelCheckbox.addEventListener('change', function() {
                                if (this.checked) {
                                    // Знімаємо всі інші чекбокси
                                    document.querySelectorAll('.sdstudio-rel-item input[type="checkbox"]').forEach(cb => {
                                        if (cb !== this) cb.checked = false;
                                    });
                                }
                            });
                        }

                        // Обробка решти чекбоксів
                        document.querySelectorAll('.sdstudio-rel-item input[type="checkbox"]').forEach(checkbox => {
                            checkbox.addEventListener('change', function() {
                                if (this.checked && this.id !== 'sdstudio-wp-link-no-rel') {
                                    const noRel = document.getElementById('sdstudio-wp-link-no-rel');
                                    if (noRel) noRel.checked = false;
                                }
                            });
                        });
                    }

                    // Функція для безпечної ініціалізації з повторними спробами
                    function safeInit() {
                        if (typeof wpLink !== 'undefined' && wpLink.open) {
                            initRelAttributesEditor();
                        } else {
                            // Повторна спроба через 100ms, максимум 20 разів (2 секунди)
                            var attempts = 0;
                            var retryInit = setInterval(function() {
                                attempts++;
                                if (typeof wpLink !== 'undefined' && wpLink.open) {
                                    clearInterval(retryInit);
                                    initRelAttributesEditor();
                                } else if (attempts >= 20) {
                                    clearInterval(retryInit);
                                    console.warn('SDStudio: wpLink not found after 2 seconds');
                                }
                            }, 100);
                        }
                    }

                    // Запускаємо ініціалізацію при готовності DOM
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', safeInit);
                    } else {
                        safeInit();
                    }

                    // Додатково запускаємо при відкритті діалогу wplink
                    jQuery(document).on('wplink-open', function() {
                        setTimeout(initRelAttributesEditor, 50);
                    });
                })();
            </script>
            <style>
                /* Компактний Grid для наших чекбоксів */
                .sdstudio-rel-wrapper {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 4px 8px;
                    margin-top: 8px;
                    border-top: 1px dashed #ddd;
                    background-color: rgb(60 67 74 / 8%);
                    padding: 10px;
                }

                .sdstudio-rel-item label {
                    display: block;
                    font-size: 13.2px;
                    line-height: 1.4;
                }

                .sdstudio-rel-item code {
                    font-size: 12px;
                }

                /* Виправлення для результатів пошуку */
                div#most-recent-results,
                div#search-results {
                    position: relative;
                    display: contents;
                }

                /* Стилі для текстових підказок */
                p#wplink-link-existing-content,
                p#wplink-enter-url {
                    text-align: center;
                    font-weight: 700;
                }

                /* Для екранів шириною більше 786px */
                @media (min-width: 786px) {
                    div#wp-link-wrap {
                        min-width: 523px;
                    }
                }
            </style>
            <?php
        }
    }
}
