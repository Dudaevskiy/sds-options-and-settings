<?php
/**
 * Вход в админку по горячим клавишам
 */


/**
 * REDUX - Захват опций темы
 */
$redux = get_option('redux_sds_options_and_settings');

// URL - Logo
global $enable_hot_key_login;
$enable_hot_key_login = $redux['enable_hot_key_login-page-posts-sds-options-and-settings'];
global $custom_url_login;
$custom_url_login = $redux['custom_url_login-page-posts-sds-options-and-settings'];
//s($custom_url_login);

if (!empty($enable_hot_key_login) && $enable_hot_key_login == 1) {
//    s($custom_url_login);

    add_action('wp_footer', 'sdstudio_add_scripts_for_hot_key_login', 50);
    function sdstudio_add_scripts_for_hot_key_login()
    {
        global $custom_url_login;
        //Ctrl+Shift+1 переход на страницу входа в админ панель WordPress;
        // 'ajaxurl' не определена во фронте, поэтому мы добавили её аналог с помощью wp_localize_script()
        // var action = 'sdstudio_custom_login_page_enable';
        ?>
        <script>
            <?php
            $redux = get_option('redux_sds_options_and_settings');
            $sds_options_and_settings__enable_sweetalert2 = $redux['enable_sweetalert2'];
            ?>

            jQuery(document).ready(function ($) {

                function RunSDSL() {
                    let timerInterval;
                    Swal.fire({
                        title: '',
                        html: 'Пожалуйста подождите.',
                        imageUrl: '/wp-content/plugins/sds-options-and-settings/images/dscswwefef.svg',
                        imageWidth: 400,
                        imageHeight: 200,
                        imageAlt: 'Custom image',
                        timer: 15000,
                        timerProgressBar: true,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => {
                                const content = Swal.getContent()
                                if (content) {
                                    const b = content.querySelector('b')
                                    if (b) {
                                        b.textContent = Swal.getTimerLeft()
                                    }
                                }
                            }, 100)
                        },
                        onClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log('I was closed by the timer')
                        }
                    });

                    jQuery(document).ready(function ($) {

                        var ajaxurl = '/wp-admin/admin-ajax.php?action=geturlpagelog_ajax_request';
                        // var link = '';
                        var Domain = window.location.origin;
                        // This does the ajax request
                        var link = '';
                        $.ajax({
                            url: ajaxurl, // or example_ajax_obj.ajaxurl if using on frontend
                            data: {
                                'action': 'geturlpagelog_ajax_request',
                                'getsicreturllink': 'getlink',
                                'request': "",
                                'target': 'arrange_url',
                                'method': 'method_target'
                            },
                            success: function (data) {

                                // This outputs the result of the ajax request
                                // console.log(data);
                                link = data;
                                if (link == '') {
                                    window.open('/wp-login.php', '_blank');
                                    <?php
                                    // И закрываем попап окно после перехода на страницу входа
                                    ?>
                                    Swal.close();
                                } else {
                                    window.open(Domain + link, '_blank');
                                    <?php
                                    // И закрываем попап окно после перехода на страницу входа
                                    ?>
                                    Swal.close();
                                }
                            },
                            error: function (errorThrown) {
                                window.open('/wp-login.php', '_blank');
                            }
                        });
                    });

                    return false;
                }
                <?php
                /*START Горячие клавиши для WordPress*/
                ?>
                document.onkeyup = function (e) {
                    if (e.which == 77) {
                        <?php //Ctrl+Shift+1 переход на страницу входа в админ панель WordPress; ?>
                    } else if (e.ctrlKey && e.shiftKey && e.which == 49) {
                        RunSDSL();
                    } else if (e.ctrlKey && e.shiftKey && e.which == 50) {
                        jQuery(document).ready(function ($) {
                            if ($("body").hasClass("admin-bar")) {
                                var URL_EDIT_PAGE = $('li#wp-admin-bar-edit a').attr('href');
                                window.location.href = URL_EDIT_PAGE;
                            }
                        });
                        return false;
                    }

                    // Проверяем текущий линк на индекс в Google
                    else if (e.ctrlKey && e.shiftKey && e.which == 51) {
                        jQuery(document).ready(function ($) {
                            // console.log('Начинаем обработку URL');
                            var CURRENT_URL = window.location.href;
                            var SITE = 'https://www.google.com/search?q=site%3A'
                            var ThisPageInGoogleSearch = SITE + CURRENT_URL;
                            // console.log(ThisPageInGoogleSearch);
                            window.open(ThisPageInGoogleSearch, '_blank');
                        });
                        return false;
                    }
                };
                <?php
                /*END Горячие клавиши для WordPress*/
                ?>

                (function () {
                    var count = 0;
<?php
                    /**
                     *
                     *  И указываем футер после клика по которому будет переход в админку
                     *
                     */
//     $('body.home footer, body.home .footer-sidebar-2-wrapper.footer-black, body.home .footer-sidebar-2-wrapper.footer-black').click(function () {
//footer, [class^="footer"], .footer-sidebar-2-wrapper.footer-black,
//                     $('body').on('click','.home footer,.home [class^="footer"],.home .footer-sidebar-2-wrapper.footer-black,.home ul#footer-sidebar-2',function () {
//                     window.setTimeout(function() {
?>
                    $('body').on('click', ' footer, [class^="footer"], .footer-sidebar-2-wrapper.footer-black, ul#footer-sidebar-2', function () {
                        count += 1;

                        console.log(count);


                        if (count == 18) {
                            count = 0;
                            RunSDSL();
                        }
                    });
                })();
            });
        </script>
        <?php
    }


}


// ========================================


// Получение ссылки на вход

if (!function_exists('geturlpagelog_ajax_request')) {

    function geturlpagelog_ajax_request()
    {
        global $custom_url_login;
        // The $_REQUEST contains all the data sent via ajax
        if (isset($custom_url_login)) {

            global $custom_url_login;

            echo $custom_url_login;

        }

        // Always die in functions echoing ajax content
        die();
    }


    add_action('wp_ajax_geturlpagelog_ajax_request', 'geturlpagelog_ajax_request');

// If you wanted to also use the function for non-logged in users (in a theme for example)
    add_action('wp_ajax_nopriv_geturlpagelog_ajax_request', 'geturlpagelog_ajax_request');
}
?>