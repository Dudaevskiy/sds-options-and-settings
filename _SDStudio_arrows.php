<?php

$redux = get_option('redux_sds_options_and_settings');

// URL - Logo
global $enable_arrows_pages_sds_options_and_settings;
$enable_arrows_pages_sds_options_and_settings = $redux['enable_arrows_pages_sds-options-and-settings'];

//dd($enable_arrows_pages_sds_options_and_settings);


if ($enable_arrows_pages_sds_options_and_settings == 1){


//    include_once(ABSPATH . 'wp-includes/pluggable.php');

//ddd(get_post_meta(9843));

//    if( current_user_can('editor') || current_user_can('administrator') ) {
    add_action("wp_head", "wp_head_css");
    function wp_head_css()
    {
        global $post;

        $post_id = get_the_ID();
        $args = array('post_status' => 'publish','post_status' => $post_id);
        $pagelist = get_posts($args);
//            s($pagelist)
//            $pagelist = get_posts($args);
//            s($post_id->post_status);
//        s($post);
//            if( $post->post_status == 'publish' ){
        if(is_single()) {
            ?>
            <div id="sdstudio-editor-tools-next-prev-btns">

                <?php

                global $post;

                $previous = get_previous_post(true);
                $next = get_next_post(true);
                ?>

                <!--            <div class="navigation">-->
                <?php if ($previous) { ?>
                    <div class="alignleft">
                        <a href="<?php echo get_permalink($previous); ?>"
                           title="<?php echo get_the_title($previous); ?>">&laquo;</a>
                    </div>
                <?php }
                if ($next) { ?>
                    <div class="alignright">
                        <a href="<?php echo get_permalink($next); ?>"
                           title="<?php echo get_the_title($next); ?>">&raquo;</a>
                    </div>
                <?php } ?>
                <!--            </div>-->
                <!-- .navigation -->


                <?php //previous_post_link (); ?>
                <?php //next_post_link (); ?>
                <!--            <a href="#" class="previous">&laquo; Предыдущий пост черновик</a>-->
                <!--            <a href="#" class="next">Следущий пост черновик &raquo;</a>-->

                <!--    <a href="#" class="previous round">&#8249;</a>-->
                <!--    <a href="#" class="next round">&#8250;</a>-->
                <style>

                    div#sdstudio-editor-tools-next-prev-btns{
                        z-index:9999;
                        position:fixed;
                        width:100%;
                    }

                    div#sdstudio-editor-tools-next-prev-btns .alignleft a {
                        color: white;
                        line-height: 1.4em;
                        text-decoration: blink;
                        font-size: 2.5em;
                        position: absolute;
                        margin-left: 35px;
                        text-shadow:
                                -1px -1px 0 #000,
                                1px -1px 0 #000,
                                -1px 1px 0 #000,
                                1px 1px 0 #000;
                    }

                    div#sdstudio-editor-tools-next-prev-btns .alignright a {
                        color: white;
                        line-height: 1.4em;
                        text-decoration: blink;
                        font-size: 2.5em;
                        position: absolute;
                        margin-right: 35px;
                        right: 0px;
                        text-shadow:
                                -1px -1px 0 #000,
                                1px -1px 0 #000,
                                -1px 1px 0 #000,
                                1px 1px 0 #000;
                    }
                    @media screen and (max-width:800px){
                        div#sdstudio-editor-tools-next-prev-btns{
                            z-index:9999;
                            position:relative;
                            width:100%;
                        }

                        div#sdstudio-editor-tools-next-prev-btns .alignleft a {
                            color: #232f75;
                            margin-top:-10px;
                            line-height: 1.5em;
                            text-decoration: blink;
                            font-size: 2.5em;
                            position: absolute;
                            z-index:9;
                            margin-left: 15px;
                            text-shadow:none;
                            text-shadow:
                                    -1px -1px 0 white,
                                    1px -1px 0 white,
                                    -1px 1px 0 white,
                                    1px 1px 0 white;
                        }

                        div#sdstudio-editor-tools-next-prev-btns .alignright a {
                            color: #232f75;
                            margin-top:-10px;
                            line-height: 1.5em;
                            z-index:9;
                            text-decoration: blink;
                            font-size: 2.5em;
                            position: absolute;
                            margin-right: 15px;
                            text-shadow:none;
                            text-shadow:
                                    -1px -1px 0 white,
                                    1px -1px 0 white,
                                    -1px 1px 0 white,
                                    1px 1px 0 white;
                        }


                        div#sdstudio-editor-tools-next-prev-btns .alignleft,
                        div#sdstudio-editor-tools-next-prev-btns .alignright{
                            margin-top: 165px;
                            margin-bottom: -150px;
                        }
                        body div#sdstudio-editor-tools-next-prev-btns{
                            /* right:0px !important; */
                            /*z-index: 0;*/
                        }

                        div#sdstudio-editor-tools-next-prev-btns{
                            /*     display:none; */
                        }

                        .container-page-item-title{
                            margin-left:0px !important;
                            margin-right:0px !important;
                        }

                        body .container.container-page-item-title.aos-init.aos-animate .col-md-12.col-overlay .col-md-12 {
                            padding-top:0px !important;
                            padding-left: 20px !important;
                            padding-right: 20px !important;
                        }
                    }
                </style>
            </div>

            <?php

        }
    }
//    }
//ddd(get_post_meta(9843));


}