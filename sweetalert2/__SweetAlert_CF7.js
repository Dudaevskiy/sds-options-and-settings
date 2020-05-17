/*Попап окно если форма не верно заполнена*/
    jQuery(document).ready(function($) {
    	$(".wpcf7").on('wpcf7:invalid', function(event){
//===============
          Swal.fire({
			  position: 'center',
			  type: 'error',
			  title: 'Помилка!',
			  text:'Помилка заповнення форми. Форма була заповнена не вірно, або ж не заповнена зовсім. Будь ласка, зверніть увагу на повідомлення під полями введення.',
			  showConfirmButton: false,
			  scrollbarPadding: false,
			  // timer: 3000
			});
//===============
    	});

/*Попап окно если форма заполнена верно и письмо успешно отправлено*/
    	$(".wpcf7").on('wpcf7:mailsent', function(event){
//===============
            Swal.fire({
			  position: 'center',
			  type: 'success',
			  title: 'Дякуємо!',
			  text:'Ваше повідомлення було нам надіслано.',
			  showConfirmButton: false,
			  scrollbarPadding: false,
			  timer: 2000
			});
//===============
    	});
    });