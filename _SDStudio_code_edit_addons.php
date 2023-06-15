<?php
$redux = get_option( 'redux_sds_options_and_settings' );

global $enable_js_descript_code_edit_sds_options_and_settings;
$enable_js_descript_code_edit_sds_options_and_settings = $redux['enable_js_descript_code_edit_sds-options-and-settings'];
if ($enable_js_descript_code_edit_sds_options_and_settings == 1 ){

    if (!is_admin()){
        add_filter( 'script_loader_tag', 'sdstudio_add_script_handle', 10, 3 );
        function sdstudio_add_script_handle( $tag, $handle, $src ) {
            return str_replace( '<script', sprintf(
                '<script data-handle="%1$s"',
                esc_attr( $handle )
            ), $tag );
        }
    }

}