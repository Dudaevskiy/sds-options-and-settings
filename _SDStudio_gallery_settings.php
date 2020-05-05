<?php
/**
 *
 * @_1_ГАЛЕРЕЯ_ИЗОБРАЖЕНИЙ
 *
 */

/**
 * REDUX - Захват опций темы
 */
$redux = get_option( 'redux_sds_options_and_settings' );

// URL - Logo
global $sds_options_and_settings__gallery_settings_opt;
$sds_options_and_settings__gallery_settings_opt = $redux['gallery_settings_opt-page-posts-sds-options-and-settings'];
global $sds_options_and_settings__enable_gallery_settings_opt;
$sds_options_and_settings__enable_gallery_settings_opt = $redux['enable_gallery_settings_opt-page-posts-sds-options-and-settings'];
//dd($sds_options_and_settings__enable_gallery_settings_opt );


// Галереи WordPress Всегда использовать линк на медиа файл при создании галереи
/**
 * Set default link type to “file” for image galleries when link isn't set
 */
/*function my_gallery_default_type_set_link( $settings ) {
    $settings['galleryDefaults']['link'] = 'file';
    return $settings;
}
add_filter( 'media_view_settings', 'my_gallery_default_type_set_link');*/

/**
 * SDStudio - https://techblog.sdstudio.top/blog/wordpress-ssylka-na-media-fajl-po-umolchaniyu-dlya-galerei-izobrazhenij
 * Установка типа ссылки по умолчанию на медиа файл для галерей изображений
 */
function my_gallery_default_type_set_link( $settings ) {
    global $sds_options_and_settings__gallery_settings_opt;

    $settings['galleryDefaults']['link'] = 'file';
    $settings['galleryDefaults']['size'] = 'thumbnail';
    $settings['galleryDefaults']['columns'] = $sds_options_and_settings__gallery_settings_opt;
    return $settings;
}
if ($sds_options_and_settings__enable_gallery_settings_opt == 1 ){
    add_filter( 'media_view_settings', 'my_gallery_default_type_set_link');
}


?>