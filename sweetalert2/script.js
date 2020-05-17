// Alert Modal Type
$(document).on("click", "button#my_test1", function (e) {

	let timerInterval
	Swal.fire({
	  title: 'Получаем отзыв Google Reviews',
	  html: 'После получения отзыва, данное окно будет закрыто автоматически, так же Вы увидите всплывающее окно с информацией о успешном (или не совсем успешном) получении отзыва.',
	//  timer: 2000,

	// Отображаем прелоадер
	  onBeforeOpen: () => {
	    Swal.showLoading()
	/*    timerInterval = setInterval(() => {
	      Swal.getContent().querySelector('strong')
	        .textContent = Swal.getTimerLeft()
	    }, 100)*/
	  },
	  
	  onClose: () => {
	    clearInterval(timerInterval)
	  }
	}).then((result) => {
	  if (
	    // Read more about handling dismissals
	    result.dismiss === Swal.DismissReason.timer
	  ) {
	    console.log('I was closed by the timer')
	  }
	})

});	



















// Alert Modal Type
$(document).on("click", "#image-left", function(e) {
  Swal.fire({
    position: "bottom-end",
    imageHeight: 200,
    imageUrl:
      "https://sleeknotestaticcontent.sleeknote.com/sleeknoteimages/636803965838047567.gif",
    html:
      '<span class="text-purple text-center text-pre-title">BOOK A FREE DEMO</span><div class="spacer" style="height:5px;" aria-label="false"></div>' +
      '<span class="text-black text-title text-center">Are you ready for a tailored demo yet?</span><div class="spacer" style="height:15px;" aria-label="false"></div>' +
      '<span class="text-grey text-para text-left">If you book a demo, I’ll show you how to collect subscribers, increase engagement and drive revenue with Xtremepush. ' +
      "</span>",
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    animation: false,
    customClass: {
      popup: "animated bounce flex-row tight-fit",
      image: "flex-align-center flex-position-1 very-tight-fit",
      content: "flex-align-center flex-position-2 tight-fit text-width-snug",
      actions: "flex-position-3 flex-column very-tight-fit",
      confirmButton: "flex-position-1",
      cancelButton: "flex-position-2"
    }
  });
});

// Alert Modal Type
$(document).on("click", "#image-top", function(e) {
  Swal.fire({
    imageHeight: 300,
    background: `#fff url(https://sleeknotestaticcontent.sleeknote.com/sleeknoteimages/636598263224799380.png)
no-repeat
350px 435px / 40%`,
    imageUrl:
      "https://d2duw1tbgzwwah.cloudfront.net/wp-content/uploads/2018/11/Automation-Tool-Email-Edit.gif",
    html:
      '<span class="text-purple text-center text-pre-title">BOOK A FREE DEMO</span><div class="spacer" style="height:5px;" aria-label="false"></div>' +
      '<span class="text-black text-title text-center">Are you ready for a tailored demo yet?</span><div class="spacer" style="height:15px;" aria-label="false"></div>' +
      '<span class="text-grey text-para text-left">If you book a demo, we’ll show you how to collect subscribers, increase engagement and drive revenue with Xtremepush. ' +
      '</span><div class="spacer" style="height:15px;" aria-label="false"></div>',
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    animation: false,
    customClass: {
      popup: "animated bounce flex-column very-tight-fit",
      image: "flex-align-center flex-position-1 very-tight-fit",
      content: "flex-align-center flex-position-2 tight-fit text-width-wide",
      actions: "flex-position-3 flex-row tight-fit",
      confirmButton: "flex-position-1",
      cancelButton: "flex-position-2"
    }
  });
});

// Alert Modal Type
$(document).on("click", "#image-top-footer", function(e) {
  Swal.fire({
    imageHeight: 300,
    background: `#fff url(https://sleeknotestaticcontent.sleeknote.com/sleeknoteimages/636598263224799380.png)
no-repeat
350px 435px / 40%`,
    imageUrl:
      "https://d2duw1tbgzwwah.cloudfront.net/wp-content/uploads/2018/11/Automation-Tool-Email-Edit.gif",
    html:
      '<span class="text-purple text-center text-pre-title">BOOK A FREE DEMO</span><div class="spacer" style="height:5px;" aria-label="false"></div>' +
      '<span class="text-black text-title text-center">Are you ready for a tailored demo yet?</span><div class="spacer" style="height:15px;" aria-label="false"></div>' +
      '<span class="text-grey text-para text-left">If you book a demo, we’ll show you how to collect subscribers, increase engagement and drive revenue with Xtremepush. ' +
      '</span><div class="spacer" style="height:15px;" aria-label="false"></div>',
    footer:
      '<div class="spacer" style="height:5px;" aria-label="false"></div><span class="text-light-grey text-footer text-left">&copy; 2019  &nbsp;&nbsp;</span><img src="https://d2duw1tbgzwwah.cloudfront.net/wp-content/uploads/2018/01/XP-logo-website-color.png" style="height:23%; width:23%;">',
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    animation: false,
    customClass: {
      popup: "animated bounce flex-column very-tight-fit",
      image: "flex-align-center flex-position-1 very-tight-fit",
      content: "flex-align-center flex-position-2 tight-fit text-width-wide",
      actions: "flex-position-3 flex-row tight-fit",
      confirmButton: "flex-position-1",
      cancelButton: "flex-position-2",
      footer: "flex-position-4 tight-fit"
    }
  });
});

// Alert Modal Type
$(document).on("click", "#image-background", function(e) {
  Swal.fire({
    background: `#fff url(https://prods3.imgix.net/images/articles/2017_04/Non-Feature-Underrated-Food-Cities.jpg?auto=format%2Ccompress&ixjsv=2.2.3)
no-repeat
0px 0px / 125%`,
    html:
      '<span class="text-white text-center text-xl-pre-title">BOOK A FREE DEMO</span><div class="spacer" style="height:7.5px;" aria-label="false"></div>' +
      '<span class="text-white text-xl-title text-center">Are you ready for a tailored demo yet?</span><div class="spacer" style="height:20px;" aria-label="false"></div>' +
      '<span class="text-white text-xl-para text-left">If you book a demo, we’ll show you how to collect subscribers, increase engagement and drive revenue with Xtremepush. ' +
      '</span><div class="spacer" style="height:15px;" aria-label="false"></div>',
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    animation: false,
    customClass: {
      popup: "animated bounce flex-row loose-fit",
      content: "flex-position-1 text-width-wide loose-fit silk-screen text-white",
      actions: "flex-position-2 very-tight-fit silk-screen flex-column",
      confirmButton: "flex-position-1 btn-outline-light",
      cancelButton: "flex-position-2 btn-outline-lighter",
    }
  });
});

// Alert Modal Type
$(document).on("click", "#image-background-btns-btm", function(e) {
  Swal.fire({
    background: `#fff url(https://prods3.imgix.net/images/articles/2017_04/Non-Feature-Underrated-Food-Cities.jpg?auto=format%2Ccompress&ixjsv=2.2.3)
no-repeat
0px 0px / 125%`,
    html:
      '<span class="text-white text-center text-xl-pre-title">BOOK A FREE DEMO</span><div class="spacer" style="height:7.5px;" aria-label="false"></div>' +
      '<span class="text-white text-xl-title text-center">Are you ready for a tailored demo yet?</span><div class="spacer" style="height:20px;" aria-label="false"></div>' +
      '<span class="text-white text-xl-para text-left">If you book a demo, we’ll show you how to collect subscribers, increase engagement and drive revenue with Xtremepush. ' +
      '</span><div class="spacer" style="height:15px;" aria-label="false"></div>',
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    animation: false,
    customClass: {
      popup: "animated bounce flex-column loose-fit",
      content: "flex-align-center flex-position-1 text-width-wide loose-fit silk-screen text-white",
      actions: "flex-align-center  flex-position-2 very-tight-fit silk-screen flex-row",
      confirmButton: "flex-position-1 btn-outline-light",
      cancelButton: "flex-position-2 btn-outline-lighter",
    }
  });
});

// Alert Modal Type
$(document).on("click", "#image-left", function(e) {
  Swal.fire({
    position: "bottom-end",
    imageHeight: 200,
    imageUrl:
      "https://sleeknotestaticcontent.sleeknote.com/sleeknoteimages/636803965838047567.gif",
    html:
      '<span class="text-purple text-center text-pre-title">BOOK A FREE DEMO</span><div class="spacer" style="height:5px;" aria-label="false"></div>' +
      '<span class="text-black text-title text-center">Are you ready for a tailored demo yet?</span><div class="spacer" style="height:15px;" aria-label="false"></div>' +
      '<span class="text-grey text-para text-left">If you book a demo, I’ll show you how to collect subscribers, increase engagement and drive revenue with Xtremepush. ' +
      "</span>",
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    animation: false,
    customClass: {
      popup: "animated bounce flex-row tight-fit",
      image: "flex-align-center flex-position-1 very-tight-fit",
      content: "flex-align-center flex-position-2 tight-fit text-width-snug",
      actions: "flex-position-3 flex-column very-tight-fit",
      confirmButton: "flex-position-1",
      cancelButton: "flex-position-2"
    }
  });
});

// Alert Modal Type
$(document).on("click", "#image-top", function(e) {
  Swal.fire({
    imageHeight: 300,
    background: `#fff url(https://sleeknotestaticcontent.sleeknote.com/sleeknoteimages/636598263224799380.png)
no-repeat
350px 435px / 40%`,
    imageUrl:
      "https://d2duw1tbgzwwah.cloudfront.net/wp-content/uploads/2018/11/Automation-Tool-Email-Edit.gif",
    html:
      '<span class="text-purple text-center text-pre-title">BOOK A FREE DEMO</span><div class="spacer" style="height:5px;" aria-label="false"></div>' +
      '<span class="text-black text-title text-center">Are you ready for a tailored demo yet?</span><div class="spacer" style="height:15px;" aria-label="false"></div>' +
      '<span class="text-grey text-para text-left">If you book a demo, we’ll show you how to collect subscribers, increase engagement and drive revenue with Xtremepush. ' +
      '</span><div class="spacer" style="height:15px;" aria-label="false"></div>',
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    animation: false,
    customClass: {
      popup: "animated bounce flex-column very-tight-fit",
      image: "flex-align-center flex-position-1 very-tight-fit",
      content: "flex-align-center flex-position-2 tight-fit text-width-wide",
      actions: "flex-position-3 flex-row tight-fit",
      confirmButton: "flex-position-1",
      cancelButton: "flex-position-2"
    }
  });
});

// Alert Modal Type
$(document).on("click", "#image-top-footer", function(e) {
  Swal.fire({
    imageHeight: 300,
    background: `#fff url(https://sleeknotestaticcontent.sleeknote.com/sleeknoteimages/636598263224799380.png)
no-repeat
350px 435px / 40%`,
    imageUrl:
      "https://d2duw1tbgzwwah.cloudfront.net/wp-content/uploads/2018/11/Automation-Tool-Email-Edit.gif",
    html:
      '<span class="text-purple text-center text-pre-title">BOOK A FREE DEMO</span><div class="spacer" style="height:5px;" aria-label="false"></div>' +
      '<span class="text-black text-title text-center">Are you ready for a tailored demo yet?</span><div class="spacer" style="height:15px;" aria-label="false"></div>' +
      '<span class="text-grey text-para text-left">If you book a demo, we’ll show you how to collect subscribers, increase engagement and drive revenue with Xtremepush. ' +
      '</span><div class="spacer" style="height:15px;" aria-label="false"></div>',
    footer:
      '<div class="spacer" style="height:5px;" aria-label="false"></div><span class="text-light-grey text-footer text-left">&copy; 2019  &nbsp;&nbsp;</span><img src="https://d2duw1tbgzwwah.cloudfront.net/wp-content/uploads/2018/01/XP-logo-website-color.png" style="height:23%; width:23%;">',
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    animation: false,
    customClass: {
      popup: "animated bounce flex-column very-tight-fit",
      image: "flex-align-center flex-position-1 very-tight-fit",
      content: "flex-align-center flex-position-2 tight-fit text-width-wide",
      actions: "flex-position-3 flex-row tight-fit",
      confirmButton: "flex-position-1",
      cancelButton: "flex-position-2",
      footer: "flex-position-4 tight-fit"
    }
  });
});

// Alert Modal Type
$(document).on("click", "#image-background", function(e) {
  Swal.fire({
    background: `#fff url(https://prods3.imgix.net/images/articles/2017_04/Non-Feature-Underrated-Food-Cities.jpg?auto=format%2Ccompress&ixjsv=2.2.3)
no-repeat
0px 0px / 125%`,
    html:
      '<span class="text-white text-center text-xl-pre-title">BOOK A FREE DEMO</span><div class="spacer" style="height:7.5px;" aria-label="false"></div>' +
      '<span class="text-white text-xl-title text-center">Are you ready for a tailored demo yet?</span><div class="spacer" style="height:20px;" aria-label="false"></div>' +
      '<span class="text-white text-xl-para text-left">If you book a demo, we’ll show you how to collect subscribers, increase engagement and drive revenue with Xtremepush. ' +
      '</span><div class="spacer" style="height:15px;" aria-label="false"></div>',
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    animation: false,
    customClass: {
      popup: "animated bounce flex-row loose-fit",
      content: "flex-position-1 text-width-wide loose-fit silk-screen text-white",
      actions: "flex-position-2 very-tight-fit silk-screen flex-column",
      confirmButton: "flex-position-1 btn-outline-light",
      cancelButton: "flex-position-2 btn-outline-lighter",
    }
  });
});

// Alert Modal Type
$(document).on("click", "#image-background-btns-btm", function(e) {
  Swal.fire({
    background: `#fff url(https://prods3.imgix.net/images/articles/2017_04/Non-Feature-Underrated-Food-Cities.jpg?auto=format%2Ccompress&ixjsv=2.2.3)
no-repeat
0px 0px / 125%`,
    html:
      '<span class="text-white text-center text-xl-pre-title">BOOK A FREE DEMO</span><div class="spacer" style="height:7.5px;" aria-label="false"></div>' +
      '<span class="text-white text-xl-title text-center">Are you ready for a tailored demo yet?</span><div class="spacer" style="height:20px;" aria-label="false"></div>' +
      '<span class="text-white text-xl-para text-left">If you book a demo, we’ll show you how to collect subscribers, increase engagement and drive revenue with Xtremepush. ' +
      '</span><div class="spacer" style="height:15px;" aria-label="false"></div>',
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    animation: false,
    customClass: {
      popup: "animated bounce flex-column loose-fit",
      content: "flex-align-center flex-position-1 text-width-wide loose-fit silk-screen text-white",
      actions: "flex-align-center  flex-position-2 very-tight-fit silk-screen flex-row",
      confirmButton: "flex-position-1 btn-outline-light",
      cancelButton: "flex-position-2 btn-outline-lighter",
    }
  });
});




$(document).on("click", "#image-left", function (e) {
  Swal.fire({
    position: "bottom-end",
    imageHeight: 200,
    //imageUrl:  "https://sleeknotestaticcontent.sleeknote.com/sleeknoteimages/636803965838047567.gif",
    html:
    '<span class="text-purple text-center text-pre-title">JOIN OUR MAILING LIST</span><div class="spacer" style="height:5px;" aria-label="false"></div>' +
    '<span class="text-black text-title text-center">Do you want to be a multichannel master?</span><div class="spacer" style="height:15px;" aria-label="false"></div>' +
    '<span class="text-grey text-para text-left">Enter your email and hit submit to opt-in for emails from Xtremepush.' +
    '</span><div class="spacer" style="height:15px;" aria-label="false"></div>',
    input: 'email',
    inputPlaceholder: 'Enter your email address',
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: "Submit",
    cancelButtonText: "Not now",
    animation: false,
    customClass: {
      popup: "animated bounce flex-row tight-fit",
      image: "flex-align-center flex-position-1 very-tight-fit",
      content: "flex-column flex-align-center flex-position-2 tight-fit text-width-wide",
      input: 'flex-position-3 very-tight-fit',
      actions: "flex-position-4 flex-column flex-align-end very-tight-fit",
      confirmButton: "flex-position-2",
      cancelButton: "flex-position-1"    }
  });
});

