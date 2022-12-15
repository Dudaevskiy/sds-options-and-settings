<?php
/**
 * AddToAny
 */

$redux = get_option( 'redux_sds_options_and_settings' );
global $sds_options_and_settings__enable_sweetalert2_for_AddToAny;
$sds_options_and_settings__enable_sweetalert2_for_AddToAny = $redux['enable_sweetalert2_for_AddToAny'];

global $sds_options_and_settings__enable_sweetalert2_for_AddToAny_REDUX;
$sds_options_and_settings__enable_sweetalert2_for_AddToAny_REDUX = $redux;

global $enable_sweetalert2_for_AddToAny_activate_social;
$enable_enable_sweetalert2 = $redux['enable_sweetalert2'];
$enable_sweetalert2_for_AddToAny_activate_social = $redux['enable_sweetalert2_for_AddToAny_activate_social'];
//dd($sds_options_and_settings__enable_sweetalert2_for_AddToAny);


if ($enable_enable_sweetalert2 == 1 && $sds_options_and_settings__enable_sweetalert2_for_AddToAny == 1){

    if (is_admin()){
        return;
    }

    // Подключаем сам скрипт для отображения AddToAny
    wp_enqueue_script('AddToAny_loader', SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL.'AddToAny/AddToAny_loader.js');
//    wp_enqueue_script('AddToAny_loader', SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL.'AddToAny/AddToAny_loader.js',array ( 'jquery' ), 1.1, true);
    // Подключаем кастомный стиль
    wp_register_style('AddToAny_CUSTOM', SDS_OPTIONS_AND_SETTINGS__PLUGIN_URL.'AddToAny/AddToAny_custom.css');
    wp_enqueue_style('AddToAny_CUSTOM');
}
/**
 * И перебираем активированные соц. сети
 */
//if (array_intersect(explode(' ', 'a2a_whatsapp'), $enable_sweetalert2_for_AddToAny_activate_social)){
//    s($enable_sweetalert2_for_AddToAny_activate_social);
//}

//if (!empty(array_intersect(explode(' ', 'hgfjg'), $enable_sweetalert2_for_AddToAny_activate_social))){
//    dd('regfe');
//}


if ($sds_options_and_settings__enable_sweetalert2_for_AddToAny == 1 ) {
    add_action('wp_head', 'cbr_addtoany_and_sweetalert_share_addtoany');
}

function cbr_addtoany_and_sweetalert_share_addtoany(){


    global $sds_options_and_settings__enable_sweetalert2_for_AddToAny_REDUX;
    $redux = $sds_options_and_settings__enable_sweetalert2_for_AddToAny_REDUX;

    global $enable_sweetalert2_for_AddToAny_activate_social;


// Добавляем в тело страницы блок AddToAny

    $enable_sweetalert2_for_AddToAny_title = $redux['enable_sweetalert2_for_AddToAny_title'];

    if (!empty($enable_sweetalert2_for_AddToAny_title)) {
        $SDSTudioSO_AddToAnyTitle = do_shortcode($enable_sweetalert2_for_AddToAny_title);
    } else {
        $SDSTudioSO_AddToAnyTitle = 'Share';
    }


    $FullContent_Share_Popup;
    $FullContent_Share_Popup .= '<div id="SDSTudioSO_AddToAnyBlock" style="display: none" data-title="'.$SDSTudioSO_AddToAnyTitle .'">';
    $FullContent_Share_Popup .= '<div id="SDSTudioSO_AddToAnyBlock_for_SweetAlert2">';
    $FullContent_Share_Popup .= '<div class="a2a_kit a2a_kit_size_32 a2a_default_style">';

    $enable_sweetalert2_for_AddToAny_add_other_social_btn = $redux['enable_sweetalert2_for_AddToAny_add_other_social_btn'];
//        dd($enable_sweetalert2_for_AddToAny_add_other_social_btn );
    if ($enable_sweetalert2_for_AddToAny_add_other_social_btn == 1 ) {
        $FullContent_Share_Popup .= '<a class="a2a_dd" href="https://www.addtoany.com/share"></a>';
    }
    if (array_intersect(explode(' ', 'a2a_button_copy_link'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_copy_link"></a>';
    }

//    if (array_intersect(explode(' ', 'a2a_button_facebook'), $enable_sweetalert2_for_AddToAny_activate_social)){
    if (array_intersect(explode(' ', 'a2a_facebook'),  $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .= '<a class="a2a_button_facebook"></a>';
    }
    if (array_intersect(explode(' ', 'a2a_twitter'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_twitter"></a>';
    }
    if (array_intersect(explode(' ', 'a2a_whatsapp'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_whatsapp"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_email'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_email"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_linkedin'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_linkedin"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_telegram'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_telegram"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_evernote'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_evernote"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_skype'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_skype"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_viber'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_viber"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_trello'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_trello"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_livejournal'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_livejournal"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_facebook_messenger'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_facebook_messenger"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_tumblr'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_tumblr"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_pocket'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_pocket"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_pinterest'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_pinterest"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_printfriendly'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_printfriendly"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_button_pinboard'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_pinboard"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_button_wordpress'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_wordpress"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_button_flipboard'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_flipboard"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_button_mail_ru'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_mail_ru"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_button_livejournal'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_livejournal"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_button_vk'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_vk"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_button_google_classroom'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_google_classroom"></a>';
    }

    if (array_intersect(explode(' ', 'a2a_button_google_bookmarks'), $enable_sweetalert2_for_AddToAny_activate_social)){
        $FullContent_Share_Popup .=  '<a class="a2a_button_google_bookmarks"></a>';
    }



    $FullContent_Share_Popup .= '</div>';
    $FullContent_Share_Popup .= '</div>';
//    dd($FullContent_Share_Popup);
    echo $FullContent_Share_Popup;
    ?>
            <style>
                .a2a_kit.a2a_kit_size_32.a2a_default_style {
                    max-width: 420px;
                    text-align: center;
                    margin-left: auto;
                    margin-right: auto;
                }

                a.a2a_dd {
                    padding-right: 0px;
                    margin-right: -2px;
                }

                .a2a_kit.a2a_kit_size_32.a2a_default_style a {
                    margin: 5px;
                }
            </style>
            <script>
                // Захватываем текущий язык
                var CurrentLang = jQuery('html').attr('lang');

                var a2a_config = a2a_config || {};
                a2a_config.onclick = 1;
                a2a_config.locale = CurrentLang;
            </script>
        </div>
        <?php
//    }
}