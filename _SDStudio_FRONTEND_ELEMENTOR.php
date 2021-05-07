<?php
/**
* REDUX - Захват опций темы
*/
$redux = get_option( 'redux_sds_options_and_settings' );

// Активация опции Elementor addons
global $sds_options_and_settings__gallery_settings_opt;
$enable_elementor_frontend_addons_sds_options_and_settings = $redux['enable_elementor_frontend_addons_sds-options-and-settings'];

// Отобразить счетчик просмотра поста
global $enable_posts_counter_sds_options_and_settings;
$enable_posts_counter_sds_options_and_settings = $redux['enable_posts_counter_sds-options-and-settings'];

// Отобразить счетчик ретинга поста
global $enable_posts_like_raiteng_sds_options_and_settings;
$enable_posts_like_raiteng_sds_options_and_settings = $redux['enable_posts_like_raiteng_sds-options-and-settings'];


/**
 * FUNCTIONS
 */

// -----------------------------------------------------------------------
// ------- Post Count START
// -----------------------------------------------------------------------

function SDStudio_getPostViews($current_post_id){
    $count_key = 'post_views_count';
    $count = get_post_meta($current_post_id, $count_key, true);
    if($count==''){
        delete_post_meta($current_post_id, $count_key);
        add_post_meta($current_post_id, $count_key, '0');
        // return "0 просмотров";
        return "0 ";
    }
    // return $count.' просмотров';
    return $count.' ';
}


/**
 * @return string
 * Получение текущей страницы сайта
 */
// Обновляем количество просмотров
function SDStudio_setPostViews($current_post_id) {
    if (!$current_post_id){
        global $post;
        $current_post_id = $post->ID;
    }
    $count_key = 'post_views_count';
    $count = get_post_meta($current_post_id, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($current_post_id, $count_key);
        add_post_meta($current_post_id, $count_key, '0');
    }else{
        $count++;
        update_post_meta($current_post_id, $count_key, $count);
    }
}
add_action('wp_head','SDStudio_setPostViews');

add_filter('manage_posts_columns', 'SDStudio_posts_column_views');
add_action('manage_posts_custom_column', 'SDStudio_posts_custom_column_view',5,2);
function SDStudio_posts_column_views($defaults){
    // $defaults['post_views'] = __('просмотров');
    $defaults['post_views'] = __('Views');
    return $defaults;
}
function SDStudio_posts_custom_column_view($column_name, $id){
    if($column_name === 'post_views'){
        echo SDStudio_getPostViews(get_the_ID());
    }
}
// -----------------------------------------------------------------------
// ------- Post Count END
// -----------------------------------------------------------------------





// -----------------------------------------------------------------------
// ------- Like Button START
// -----------------------------------------------------------------------
add_action( 'wp_enqueue_scripts', 'pt_like_it_scripts' );
function pt_like_it_scripts() {
    if( is_single() ) {

//        wp_enqueue_style( 'like-it', trailingslashit( plugin_dir_url( __FILE__ ) ).'_LikeButton/like-it.css' );

        if (!wp_script_is( 'jquery', 'enqueued' )) {
            wp_enqueue_script( 'jquery' );// Comment this line if you theme has already loaded jQuery
        }
        wp_enqueue_script( 'like-it', trailingslashit( plugin_dir_url( __FILE__ ) ).'_LikeButton/like-it.js', array('jquery'), '1.0', true );

        wp_localize_script( 'like-it', 'likeit', array(
            'ajax_url' => admin_url( 'admin-ajax.php' )
        ));
    }
}
add_action( 'wp_ajax_nopriv_pt_like_it', 'pt_like_it' );
add_action( 'wp_ajax_pt_like_it', 'pt_like_it' );


function pt_like_it() {

    if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'pt_like_it_nonce' ) || ! isset( $_REQUEST['nonce'] ) ) {
        exit( "No naughty business please" );
    }

    $likes = get_post_meta( $_REQUEST['post_id'], '_pt_likes', true );
    $likes = ( empty( $likes ) ) ? 0 : $likes;
    $new_likes = $likes + 1;

    update_post_meta( $_REQUEST['post_id'], '_pt_likes', $new_likes );

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        echo $new_likes;
        die();
    }
    else {
        wp_redirect( get_permalink( $_REQUEST['post_id'] ) );
        exit();
    }
}


//add_filter( 'the_content', 'like_it_button_html', 99 );
//
//function like_it_button_html( $content ) {
//    $like_text = '';
//    if ( is_single() ) {
//        $nonce = wp_create_nonce( 'pt_like_it_nonce' );
//        $link = admin_url('admin-ajax.php?action=pt_like_it&post_id='.$post->ID.'&nonce='.$nonce);
//        $likes = get_post_meta( get_the_ID(), '_pt_likes', true );
//        $likes = ( empty( $likes ) ) ? 0 : $likes;
//        $like_text = '
//                    <div class="pt-like-it">
//                        <a class="like-button" href="'.$link.'" data-id="' . get_the_ID() . '" data-nonce="' . $nonce . '">' .
//            __( 'Like it' ) .
//            '</a>
//                        <span id="like-count-'.get_the_ID().'" class="like-count">' . $likes . '</span>
//                    </div>';
//    }
//    return $content . $like_text;
//}

// -----------------------------------------------------------------------
// ------- Like Button END
// -----------------------------------------------------------------------

/***
 * END FUNCTIONS
 */


if ($sds_options_and_settings__gallery_settings_opt == 1) {



}


/**
 * Elementor Динамически генерируемая сума по формуле цена * метраж
 * https://developers.elementor.com/dynamic-tags/
 */
//Class Elementor_SDStudio_REPLACER_1_price_base extends \Elementor\Core\DynamicTags\Tag {
class Elementor_SDStudio_OptAndSet_DynData extends \Elementor\Core\DynamicTags\Tag
{

    /**
     * Get Name
     *
     * Returns the Name of the tag
     *
     * @return string
     * @since 2.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'server-variable';
    }

    /**
     * Get Title
     *
     * Returns the title of the Tag
     *
     * @return string
     * @since 2.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return __('SDStudio options and settings - ДИНАМИЧЕСКИЕ ДАННЫЕ', 'elementor-pro');
    }

    /**
     * Get Group
     *
     * Returns the Group of the tag
     *
     * @return string
     * @since 2.0.0
     * @access public
     *
     */
    public function get_group()
    {
        return 'request-variables';
    }

    /**
     * Get Categories
     *
     * Returns an array of tag categories
     *
     * @return array
     * @since 2.0.0
     * @access public
     *
     */
    public function get_categories()
    {
        return [\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY];
    }

    /**
     * Register Controls
     *
     * Registers the Dynamic tag controls
     *
     * @return void
     * @since 2.0.0
     * @access protected
     *
     */
    protected function _register_controls()
    {

        $variables = [];
        $variables['SET_1_CounterPosts']      = '1) Счетчик просмотров страниц и записей (любого типа)';
        $variables['SET_2_LikeButton']        = '2) Счетчик лайков страниц и записей (любого типа)';
        $variables['SET_3_CounterComments']   = '3) Счетчик комментариев';
        $variables['SET_4_ReadTime']   = '3) Время чтения';

        $this->add_control(
            'param_name',
            [
                'label' => __('Param Name', 'elementor-pro'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $variables,
            ]
        );
    }

    /**
     * Render
     *
     * Prints out the value of the Dynamic tag
     *
     * @return void
     * @since 2.0.0
     * @access public
     *
     */
    public function render()
    {
        /**
         * 1) Счетчик просмотров страниц и записей (любого типа)
         */
        if ($this->get_settings('param_name') === 'SET_1_CounterPosts') {
            global $post;
            // Получаем ID текущего поста
            $ID = $post->ID;
            $count_key = 'post_views_count';
            $count = get_post_meta($ID, $count_key, true);
            echo $count;
        }

        /**
         * 2) Счетчик лайков страниц и записей (любого типа)
         */
        if($this->get_settings('param_name') === 'SET_2_LikeButton'){
            $like_text = '';
            if ( is_single() ) {
                $nonce = wp_create_nonce( 'pt_like_it_nonce' );
                $link = admin_url('admin-ajax.php?action=pt_like_it&post_id='.$post->ID.'&nonce='.$nonce);
                $likes = get_post_meta( get_the_ID(), '_pt_likes', true );
                $likes = ( empty( $likes ) ) ? 0 : $likes;
                $like_text = '
                            <div class="pt-like-it" style="cursor: pointer;">
                                <a class="like-button" href="'.$link.'" data-id="' . get_the_ID() . '" data-nonce="' . $nonce . '">' .
                    __( '' ) .
                    '</a>
                                <span id="like-count-'.get_the_ID().'" class="like-count">' . $likes . '</span>
                            </div>';
            }
//            return $content . $like_text;
            echo $like_text;
        }
        /**
         * 3) Счетчик комментариев
         */
        if ($this->get_settings('param_name') === 'SET_3_CounterComments'){
            global $post;
            $commentcount = get_comments_number( $post->ID );
            echo $commentcount;
        }

        //$variables['SET_4_ReadTime']   = '3) Время чтения';
        /**
         * 4) Время чтения
         */
        if ($this->get_settings('param_name') === 'SET_4_ReadTime'){
            global $post;
            $content = get_post_field( 'post_content', $post->ID );
            $word_count = str_word_count( strip_tags( $content ) );
            $readingtime = ceil($word_count / 200);

            if ($readingtime == '0'){
                $readingtime = 1;
            }

            if ($readingtime == 1) {
                $timer = __(" minute");
            } else {
                $timer = __(" minutes");
            }
            $totalreadingtime = $readingtime . $timer;

//            return $totalreadingtime;
            echo $totalreadingtime;
//            echo $commentcount;
        }


    }
}

add_action('elementor/dynamic_tags/register_tags', function ($dynamic_tags) {

    // In our Dynamic Tag we use a group named request-variables so we need
    // To register that group as well before the tag
    \Elementor\Plugin::$instance->dynamic_tags->register_group('request-variables', [
        'title' => 'SDStudio options and settings'
    ]);


    // Finally register the tag
    $dynamic_tags->register_tag('Elementor_SDStudio_OptAndSet_DynData');
});





