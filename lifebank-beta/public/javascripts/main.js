// Gumby is ready to go
Gumby.ready(function() {
	console.log('Gumby is ready to go...', Gumby.debug());

	// placeholder polyfil
	if(Gumby.isOldie || Gumby.$dom.find('html').hasClass('ie9')) {
		$('input, textarea').placeholder();
	}
});

// Oldie document loaded
Gumby.oldie(function() {
	console.log("This is an oldie browser...");
});

// Touch devices loaded
Gumby.touch(function() {
	console.log("This is a touch enabled device...");
});

// Document ready
$(function() {

	var windowHeight = $(window).height()
	$(".main-content").find("section").height(windowHeight);

	$(".content-wrapper").each(function() {
		$(this).css({
//			marginTop: (-($(this).height() / 2))
            marginTop: -270
		});
	});


    $('.submit-form').on('click', function() {
        $('.info_msg').hide();
        $.ajax({
            url: '/join-mailing',
            type: 'post',
            data: {
                email: $('#email').val()
            },
            dataType: 'html',
            success: function(data) {
                $('.info_msg').text(data).show();
            },
            error: function(data) {
                $('.info_msg').text(data.responseText).show();
            }
        });
    });
});

