(function ($) {
 "use strict";
	
	/*----------------------------
	wow js active
	------------------------------ */
	new WOW().init();
 
	// slicknav
	$('ul#navigation').slicknav({
		prependTo:".responsive-menu-wrap"
	});
	
	// // stickey menu
	$(window).on('scroll',function() {    
		var scroll = $(window).scrollTop();
		if (scroll < 265) {
			$("#sticky-header").removeClass("sticky");
		}else{
			$("#sticky-header").addClass("sticky");
		}
	});
 
	// slider-active
	 $('.slider-active').owlCarousel({
        margin:0,
		loop:true,
        nav:true,
		autoplay:true,
		autoplayTimeout:5000,
		smartSpeed:1500,
        navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
        URLhashListener:true,
        startPosition: 'URLHash',
        responsive:{
            0:{
                items:1
            },
            450:{
                items:1
            },
            768:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });
	
	// slider-active
	$(".slider-active").on('translate.owl.carousel', function(){
		$('.slider-single img')
			.removeClass('fitZoom')
			.addClass('fitZoomOut')
			.fadeOut();
			
		$('.slider-content h2').removeClass('fadeInDown animated').hide();
		$('.slider-content p').removeClass('fadeInUp animated').hide();
		$('.slider-content .slide-left').removeClass('fadeInLeft animated').hide();
		$('.slider-content .slide-right').removeClass('fadeInRight animated').hide();
		$('.slider-content a').removeClass('fadeInUp animated').hide();
	});	
		
	$(".slider-active").on('translated.owl.carousel', function(){
		$('.owl-item.active .slider-content h2').addClass('fadeInDown animated').show();
		$('.owl-item.active .slider-content p').addClass('fadeInUp animated').show();
		$('.owl-item.active .slider-content .slide-left').addClass('fadeInLeft animated').show();
		$('.owl-item.active .slider-content .slide-right').addClass('fadeInRight animated').show();
		$('.owl-item.active .slider-content a').addClass('fadeInUp animated').show();
	});
	
	// course-active
	 $('.course-active').owlCarousel({
        margin:0,
		loop:true,
        nav:true,
		autoplay:true,
		autoplayTimeout:4000,
		smartSpeed:1500,
        navText:['<i class="fa fa-angle-right"></i>','<i class="fa fa-angle-left"></i>'],
        responsive:{
            0:{
                items:1
            },
            450:{
                items:1
            },
            768:{
                items:2
            },
            1000:{
                items:2
            }
        }
    });
	// course-active2
	 $('.course-active2').owlCarousel({
        margin:0,
		loop:true,
        nav:true,
		autoplay:true,
		autoplayTimeout:4000,
		smartSpeed:1500,
        navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
        responsive:{
            0:{
                items:1
            },
            450:{
                items:1
            },
            768:{
                items:2
            },
            1000:{
                items:3
            }
        }
    });
	
	// test-active
	 $('.test-active').owlCarousel({
        margin:0,
		loop:true,
        nav:false,
		smartSpeed:1500,
        navText:['<i class="fa fa-angle-right"></i>','<i class="fa fa-angle-left"></i>'],
        responsive:{
            0:{
                items:1
            },
            450:{
                items:1
            },
            768:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });
	
	// brand-active
	 $('.brand-active').owlCarousel({
        margin:0,
		loop:true,
        nav:false,
		center: true,
		autoplay:true,
		autoplayTimeout:4000,
		smartSpeed:1500,
        navText:['<i class="fa fa-angle-right"></i>','<i class="fa fa-angle-left"></i>'],
        responsive:{
            0:{
                items:2
            },
            450:{
                items:3
            },
            768:{
                items:5
            },
            1000:{
                items:5
            }
        }
    });
	
	// counter up
	$('.counter').counterUp({
		delay: 10,
		time: 1000
	});
	
	/*--------------------------
	 scrollUp
	---------------------------- */	
	$.scrollUp({
		scrollText: '<i class="fa fa-angle-up"></i>',
		easingType: 'linear',
		scrollSpeed: 900,
		animation: 'fade'
	});
	
 
	/*---------------------
	// Ajax Contact Form
	--------------------- */

	$('.cf-msg').hide();
		$('form#cf button#submit').on('click', function() {
			var fname = $('#fname').val();
			var subject = $('#subject').val();
			var email = $('#email').val();
			var msg = $('#msg').val();
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

			if (!regex.test(email)) {
				alert('Please enter valid email');
				return false;
			}

			fname = $.trim(fname);
			subject = $.trim(subject);
			email = $.trim(email);
			msg = $.trim(msg);

			if (fname != '' && email != '' && msg != '') {
				var values = "fname=" + fname + "&subject=" + subject + "&email=" + email + " &msg=" + msg;
				$.ajax({
					type: "POST",
					url: "mail.php",
					data: values,
					success: function() {
						$('#fname').val('');
						$('#subject').val('');
						$('#email').val('');
						$('#msg').val('');

						$('.cf-msg').fadeIn().html('<div class="alert alert-success"><strong>Success!</strong> Email has been sent successfully.</div>');
						setTimeout(function() {
							$('.cf-msg').fadeOut('slow');
						}, 4000);
					}
				});
			} else {
				$('.cf-msg').fadeIn().html('<div class="alert alert-danger"><strong>Warning!</strong> Please fillup the informations correctly.</div>')
			}
			return false;
	});
 
})(jQuery); 