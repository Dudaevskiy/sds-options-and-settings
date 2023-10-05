<?php

/**
 * REDUX - Захват опций темы
 */
$redux = get_option( 'redux_sds_options_and_settings' );

// URL - Logo
global $sds_enable_table_CSS_add_design_sds_options_and_settings;
$sds_enable_table_CSS_add_design_sds_options_and_settings = $redux['enable_table_CSS_add_design-sds-options-and-settings'];
if ($sds_enable_table_CSS_add_design_sds_options_and_settings == 1 ){

    if ( !function_exists( 'SDS_OPTIONS_AND_SETTINGS_enable_table_CSS' ) ) {

        if (is_admin()){
            return;
        }

//            wp_register_style('sdstudio_table_css', SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL . '_SDStudio_CSS_Styles/sdstudio_table_css.css');
//            wp_enqueue_style('sdstudio_table_css');

        function sdstudio_enqueue_styles() {
            wp_register_style('sdstudio_table_css', SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL . '_SDStudio_CSS_Styles/sdstudio_table_css.css');
            wp_enqueue_style('sdstudio_table_css');
        }
        add_action('wp_enqueue_scripts', 'sdstudio_enqueue_styles');

            /**
             * JS
             */
                add_action( 'wp_footer', 'art_responsive_tables' );
                function art_responsive_tables() {
                    if ( is_singular() ) {
                        ?>
                        <script>
                            jQuery(document).ready(function ($) {
                                $('article :not(pre) table').wrap('<div class="table-cover"></div>');
                            });
                        </script>
                        <style>
                            /*@media screen and (max-width: 1035px) {*/
                                .table-cover {
                                    width: 100%;
                                    overflow: auto;
                                    margin: 0 0 1em;
                                }
                            /*}*/
                        </style>
                        <?php
                    }
                }
    }

}