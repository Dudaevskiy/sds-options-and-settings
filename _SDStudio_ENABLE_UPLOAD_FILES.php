<?php
/**
 * REDUX - Захват опций темы
 */
$redux = get_option( 'redux_sds_options_and_settings' );

// SVG
global $svg_enable_upload_other_mmi_types_files_sds_options_and_settings;
$svg_enable_upload_other_mmi_types_files_sds_options_and_settings = $redux['svg_enable_upload_other_mmi_types_files_sds_options_and_settings'];

if ($svg_enable_upload_other_mmi_types_files_sds_options_and_settings == 1){
    // Allow SVG
    // if not upload add in first line svg file <?xml version="1.0" encoding="utf-8"? >
    function sdstudio_extra_mime_types( $mimes ) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
    add_filter( 'upload_mimes', 'sdstudio_extra_mime_types',1,1 );

    function sdstudio_fix_svg_thumb_display() {
        echo '<style>
td .media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail {
width: 100% !important;
height: auto !important;
}
.image-icon.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail { width: 60px !important;  height: auto !important; }
  </style>';
    }
    add_action('admin_head', 'sdstudio_fix_svg_thumb_display');
}
