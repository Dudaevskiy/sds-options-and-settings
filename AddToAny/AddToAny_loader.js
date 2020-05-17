// ----------------------------------------------------------------------
// AddToAny загрузка скрипта сервиса по клику + открытие попап окна START
// ----------------------------------------------------------------------
window.onload = function() {
jQuery(document).ready(function ($) {
    // $(window).on('load', function () {
    // Original Page
    // https://codepen.io/dydaevskiy/pen/zMXowN
    let loadScript = (scriptClass, url) => {
        let isLoaded = document.querySelectorAll('.' + scriptClass);
        if(isLoaded.length > 0) {

           // console.log('🔴 Скрипт page.js УЖЕ подключен')
            return false;

        } else {
            let myScript = document.createElement("script");
            myScript.classList.add(scriptClass,'addedScript');
            myScript.src = url;
            document.body.appendChild(myScript);

           // console.log('Скрипт https://static.addtoany.com/menu/page.js успешно подключен');
        }
    };
    // Функция загрузки скрипта
    $('.AddToAny_View, [href="#AddToAny_View"]').click(function() {
//     {
        loadScript("AddToAny_Script", "https://static.addtoany.com/menu/page.js");

        //---------------------------------------------
        // Показываем попап окно с идентификатором 1064
        // ==========================
        var ShareAddToAnyHTML = $('#SDSTudioSO_AddToAnyBlock>div');
        var SDSTudioSO_AddToAnyTitle =$('#SDSTudioSO_AddToAnyBlock').attr('data-title');

//         console.log(ShareAddToAnyHTML);

        Swal.fire({
            title: SDSTudioSO_AddToAnyTitle,
            html: ShareAddToAnyHTML,
            showCloseButton: true,
            showConfirmButton: false,
            // customClass: {
            //     popup: 'SDStudio_SweetAlert2_SharePopup',
            //     backdrop: 'SDStudio_SweetAlert2_SharePopup-backdrop',
            //     icon: 'SDStudio_SweetAlert2_SharePopup-icon',
            // },

            // 🔴 Функция при закрытии попап окна
            //  Важная заметка, так как при закрытии окна HTML код сгенерированный AddToAny удаляется из DOM.
            // Мы перед тем как окно будет закрыто берем сгенерированный HTML в окне SweeyAlert2 и обновляем им
            // <div id="SDSTudioSO_AddToAnyBlock_for_SweetAlert2"> в теле страницы
            onClose:() => {
                //DeleteUnsavedImages();
                // Получить текущий HTML AddToAny
                var GetSweetAlert2_UPDATE_HTMLAddToAny = $('div#swal2-content div#SDSTudioSO_AddToAnyBlock_for_SweetAlert2').html();
                $('#SDSTudioSO_AddToAnyBlock > #SDSTudioSO_AddToAnyBlock_for_SweetAlert2').html(GetSweetAlert2_UPDATE_HTMLAddToAny);

                $('script.AddToAny_Script.addedScript').remove();
//                 console.log('Вот и закрылись '+GetSweetAlert2_UPDATE_HTMLAddToAny);
            }
        })
        // ==========================
        // Отменяем вставку хеша в поле URL
        return false;
//     }

    });
});
// });
};

// ----------------------------------------------------------------------
// AddToAny загрузка скрипта сервиса по клику + открытие попап окна END
// ----------------------------------------------------------------------

