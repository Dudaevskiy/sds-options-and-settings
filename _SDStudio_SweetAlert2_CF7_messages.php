<?php
/**
 *
 * @_SweetAlert2_для_Contact_Form_7
 *
 *
 * $sdstudio_cf7_and_sweetalert2 = carbon_get_theme_option( 'sdstudio_cf7_and_sweetalert2' );
 */

/**
 * REDUX - Захват опций темы
 */
$redux = get_option( 'redux_sds_options_and_settings' );

$enable_sweetalert2_for_AddToAny_activate_social = $redux['enable_sweetalert2_for_AddToAny_activate_social'];


global $sds_options_and_settings__enable_sweetalert2;

// Опция темы Redux
$sdstudio_cf7_and_sweetalert2 = $redux['enable_sweetalert2_CF7_allerts' ];

// Если в настройках плагина активированы опции sweetalert2 и CF7
if ($sds_options_and_settings__enable_sweetalert2 == 1 && $sdstudio_cf7_and_sweetalert2 == 1) {

//    if ($sds_options_and_settings__enable_sweetalert2_for_AddToAny == 1 ) {
        add_action('wp_head', 'sweetalert_for_cf7');
//    }

    function sweetalert_for_cf7(){
//    add_action('wp_enqueue_scripts', function(){

    $redux = get_option( 'redux_sds_options_and_settings' );

//        =========================
        /**
         * И выводим скрипт для отображения попап окон при отправке CF7
         * START
         */

        // ERROR TITLE
        $crb_content_error_title_cf7 =  $redux['enable_sweetalert2_CF7_allerts_ERROR_title'] ;
//        $crb_content_error_title_cf7 = str_replace("'","\'",$crb_content_error_title_cf7);
        //$crb_content_error_title_cf7 =  carbon_get_theme_option('crb_content_error_title_cf7') ;
        //// Для обработки шорт кодов
        $crb_content_error_title_cf7 = do_shortcode($crb_content_error_title_cf7);
        //// Удаляем переносы
        $crb_content_error_title_cf7 = str_replace(array("\r\n","\r"),"",$crb_content_error_title_cf7);
        $crb_content_error_title_cf7 = "title: '".$crb_content_error_title_cf7."',";

        //// ERROR TEXT
        $crb_content_error_cf7 =  $redux['enable_sweetalert2_CF7_allerts_ERROR_message'] ;
//        $crb_content_error_cf7 = str_replace("'","\'",$crb_content_error_cf7);
        //// Для обработки шорт кодов
        $crb_content_error_cf7 = do_shortcode($crb_content_error_cf7);
        //// Удаляем все переносы для JS
        $crb_content_error_cf7 = str_replace(array("\r\n","\r"),"",$crb_content_error_cf7);
        $crb_content_error_cf7 = "text: '".$crb_content_error_cf7."',";

        //==============================================================

        //// SEND TITLE
        $crb_content_send_title_cf7 =  $redux['enable_sweetalert2_CF7_allerts_OK_title'] ;
//        $crb_content_send_title_cf7 = str_replace("'","\'",$crb_content_send_title_cf7);
        //// Для обработки шорт кодов
        $crb_content_send_title_cf7 = do_shortcode($crb_content_send_title_cf7);
        //// Удаляем переносы
        $crb_content_send_title_cf7 = str_replace(array("\r\n","\r"),"",$crb_content_send_title_cf7);
        $crb_content_send_title_cf7 = "title: '".$crb_content_send_title_cf7."',";

        //// SEND TEXT
        $crb_content_send_cf7 =  $redux['enable_sweetalert2_CF7_allerts_OK_message'] ;
//        $crb_content_send_cf7 = str_replace("'","\'",$crb_content_send_cf7);
        //// Для обработки шорт кодов
        $crb_content_send_cf7 = do_shortcode($crb_content_send_cf7);
        //// Удаляем все переносы для JS
        $crb_content_send_cf7 = str_replace(array("\r\n","\r"),"",$crb_content_send_cf7);
        $crb_content_send_cf7 = "text: '".$crb_content_send_cf7."',";
        //dd($crb_content_send_cf7);


//        $SweetAlert_CF7_js .= "<script>";
        /*Попап окно если форма не верно заполнена*/
//        $SweetAlert_CF7_js = 'window.onload = function() {';
        $SweetAlert_CF7_js .= 'jQuery(document).ready(function($) {';
        $SweetAlert_CF7_js .= "$(\".wpcf7\").on('wpcf7:invalid', function(event){";
//$SweetAlert_CF7_js.= '//===============';
        $SweetAlert_CF7_js .= 'Swal.fire({';
        $SweetAlert_CF7_js .= "position: 'center',";
        $SweetAlert_CF7_js .= "type: 'error',";
        // Показать кнопку закрытия X
//        $SweetAlert_CF7_js .= "showCloseButton: true,";
//        $SweetAlert_CF7_js .= "title: 'Помилка!',";
        $SweetAlert_CF7_js .= $crb_content_error_title_cf7;
//        $SweetAlert_CF7_js .= "text:'Помилка заповнення форми. Форма була заповнена не вірно, або ж не заповнена зовсім. Будь ласка, зверніть увагу на повідомлення під полями введення.',";
        $SweetAlert_CF7_js .= $crb_content_error_cf7;
        $SweetAlert_CF7_js .= "showConfirmButton: false,";
        $SweetAlert_CF7_js .= "scrollbarPadding: false,";
        // Раском. после DEV
        $SweetAlert_CF7_js.=" timer: 3000";
        $SweetAlert_CF7_js .= "});";
//$SweetAlert_CF7_js.="//===============";
        $SweetAlert_CF7_js .= "});";

// Попап окно если форма заполнена верно и письмо успешно отправлено
        $SweetAlert_CF7_js .= "$('.wpcf7').on('wpcf7:mailsent', function(event){";
//$SweetAlert_CF7_js.="//===============";
        $SweetAlert_CF7_js .= "Swal.fire({";
        $SweetAlert_CF7_js .= "position: 'center',";
        $SweetAlert_CF7_js .= "type: 'success',";
        // Показать кнопку закрытия X
//        $SweetAlert_CF7_js .= "showCloseButton: true,";
//        $SweetAlert_CF7_js .= "title: 'Дякуємо!',";
        $SweetAlert_CF7_js .= $crb_content_send_title_cf7;
//        $SweetAlert_CF7_js .= "text:'Ваше повідомлення було нам надіслано.',";
        $SweetAlert_CF7_js .= $crb_content_send_cf7;
        $SweetAlert_CF7_js .= "showConfirmButton: false,";
        $SweetAlert_CF7_js .= "scrollbarPadding: false,";
        $SweetAlert_CF7_js .= "timer: 2000";
        $SweetAlert_CF7_js .= "});";
        $SweetAlert_CF7_js .= "});";
        $SweetAlert_CF7_js .= "});";
//        $SweetAlert_CF7_js .= "};";
//        $SweetAlert_CF7_js .= "</script>";
?>
<script>
        <?php
            echo $SweetAlert_CF7_js;
        ?>
</script>
<?php
        // Добавляем скрипт в тело страницы для вывода попап окна
//        wp_add_inline_script( 'sweetalert2_cf7_js', $SweetAlert_CF7_js );
        /**
         * END
         * И выводим скрипт для отображения попап окон при отправке CF7
         */
    //        =========================
    };
//    });

};