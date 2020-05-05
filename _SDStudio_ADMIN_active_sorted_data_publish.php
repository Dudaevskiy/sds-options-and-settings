<?php
$redux = get_option( 'redux_sds_options_and_settings' );

$enable_ADMIN_page_post_sorted_sds_options_and_settings = $redux['enable_ADMIN_page_post_sorted-sds-options-and-settings'];

if ($enable_ADMIN_page_post_sorted_sds_options_and_settings == 1 ) {
//dd($enable_ADMIN_page_post_sorted_sds_options_and_settings);
// Сортируем посты по дате в админке:
// ------------------------------------------------------------------------
    add_action('pre_get_posts', 'change_order_post_list', 1 );
    function change_order_post_list( $query ){
        if( is_admin() && $query->is_main_query() && $query->query_vars['post_type'] == 'post' ) {
            $query->set( 'orderby', 'data' );
        }
    }
// Сортируем страницы по дате в админке:
// ------------------------------------------------------------------------
    function set_post_order_in_admin( $wp_query ) {
        global $pagenow;
        if ( is_admin() && 'edit.php' == $pagenow && !isset($_GET['orderby'])) {
            $wp_query->set( 'orderby', 'data' );
            $wp_query->set( 'order', 'DSC' );
        }
    }
    add_filter('pre_get_posts', 'set_post_order_in_admin' );
}