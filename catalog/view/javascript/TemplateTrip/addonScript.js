/*! Customized Jquery from Punit Korat.  punit@templatetrip.com  : www.templatetrip.com
Authors & copyright (c) 2016: TemplateTrip - Webzeel Services(addonScript). */
/*! NOTE: This Javascript is licensed under two options: a commercial license, a commercial OEM license and Copyright by Webzeel Services - For use Only with TemplateTrip Themes for our Customers*/
$(document).ready(function() {
						   
	/*$(".ttsearch_button").click(function() {
			$('.ttsearchtoggle').parent().toggleClass('active');
			$('.ttsearchtoggle').toggle('fast', function() {
			});
			$('.ttsearchtoggle .input-lg').attr('autofocus', 'autofocus').focus();
			$(".account-link-toggle").slideUp("slow");
			$(".header-cart-toggle").slideUp("slow");
			$(".currency-toggle").slideUp("slow");
			$(".language-toggle").slideUp("slow");
	 });*/
	
	$("#top-links a.dropdown-toggle").click(function(){
			$( ".account-link-toggle" ).slideToggle( "2000" );
			$(".currency-toggle").slideUp("slow");
			$(".language-toggle").slideUp("slow");

		   	$(".header-cart-toggle").slideUp("slow");
			$('.ttsearchtoggle').parent().removeClass("active");
			$('.ttsearchtoggle').hide('fast');
		
    	});
			
		$("#cart button.dropdown-toggle").click(function(){
			$( ".header-cart-toggle" ).slideToggle( "2000" );														 
		   	$(".account-link-toggle").slideUp("slow");
			$(".language-toggle").slideUp("slow");
			$(".currency-toggle").slideUp("slow");
			$('.ttsearchtoggle').parent().removeClass("active");
			$('.ttsearchtoggle').hide('fast');
   	    });
		
		$("#form-currency button.dropdown-toggle").click(function(){
			$( ".currency-toggle" ).slideToggle( "2000" );	
			$(".language-toggle").slideUp("slow");
			$(".account-link-toggle").slideUp("slow");
			$(".header-cart-toggle").slideUp("slow");
			$('.ttsearchtoggle').parent().removeClass("active");
			$('.ttsearchtoggle').hide('fast');
			
    	});
		
        $("#form-language button.dropdown-toggle").click(function(){
			$( ".language-toggle" ).slideToggle( "2000" );																  
			$(".currency-toggle").slideUp("fast");
			$(".account-link-toggle").slideUp("slow");
			$(".header-cart-toggle").slideUp("slow");
			$('.ttsearchtoggle').parent().removeClass("active");
			$('.ttsearchtoggle').hide('fast');
       	});
		
	$(".option-filter .list-group-items a").click(function() {
		$(this).toggleClass('collapsed').next('.list-group-item').slideToggle();
	});

	$("ul.breadcrumb li:nth-last-child(1) a").addClass('last-breadcrumb').removeAttr('href');

	$("#column-left .products-list .product-thumb, #column-right .products-list .product-thumb").unwrap();

	$("#content > h1, .account-wishlist #content > h2, .account-address #content > h2, .account-download #content > h2").first().addClass("page-title");
	
	$("#content > .page-title").wrap("<div class='page-title-wrapper'></div>");
	$(".page-title-wrapper").append($("ul.breadcrumb"));
	$("body header").after($("#content > .page-title-wrapper"));

	
	$('#column-left .product-thumb .image, #column-right .product-thumb .image').attr('class', 'image col-xs-5 col-sm-5 col-md-4');
	$('#column-left .product-thumb .thumb-description, #column-right .product-thumb .thumb-description').attr('class', 'thumb-description col-xs-7 col-sm-7 col-md-8');

		$('#content .row > .product-list .product-thumb .image').attr('class', 'image col-xs-5 col-sm-5 col-md-3');
		$('#content .row > .product-list .product-thumb .thumb-description').attr('class', 'thumb-description col-xs-7 col-sm-7 col-md-9');
		$('#content .row > .product-grid .product-thumb .image').attr('class', 'image col-xs-12');
		$('#content .row > .product-grid .product-thumb .thumb-description').attr('class', 'thumb-description col-xs-12');
	
		$('select.form-control').wrap("<div class='select-wrapper'></div>");
		$('input[type="checkbox"]').wrap("<span class='checkbox-wrapper'></span>");
		$('input[type="checkbox"]').attr('class','checkboxid');
		// $('input[type="radio"]').wrap("<span class='radio-wrapper'></span>");
		// $('input[type="radio"]').attr('class','radioid');
		
		$('#column-left .products-list .btn-cart').removeAttr('data-original-title');
		
		$('.follow-us').appendTo('.footer-bottom');
	
/*-------start go to top---------*/		
	$( "body" ).append( "<div class='backtotop-img'><div class='goToTop ttbox'></div></div>" );
	$( "body" ).append( "<div id='goToTop' title='Top' class='goToTop ttbox-img'></div>" );
	$("#goToTop").hide();
/*-------end go to top---------*/		
/*---------------------- Inputtype Js Start -----------------------------*/
$('.checkboxid').change(function(){
if($(this).is(":checked")) {
$(this).addClass("chkactive");
$(this).parent().addClass('active');
} else {
$(this).removeClass("chkactive");
$(this).parent().removeClass('active');
}
});

$(function() {
var $radioButtons = $('input[type="radio"]');
$radioButtons.click(function() {
$radioButtons.each(function() {
$(this).parent().toggleClass('active', this.checked);
});
});
});
/*---------------------- Inputtype Js End -----------------------------*/

/*------------- Slider -Loader Js Strat ---------------*/
$(window).load(function() 
{ 
$(".ttloading-bg").fadeOut("slow");
})
/*------------- Slider -Loader Js End ---------------*/
/* Slider Load Spinner */
$(window).load(function() { 
	$(".slideshow-panel .ttloading-bg").removeClass("ttloader");
});
 /* Start Homepage Stickyheader JS */	
	function header() {	
	 if (jQuery(window).width() > 1200){
		 if (jQuery(this).scrollTop() > 300)
			{    
				jQuery('.full-header').addClass("fixed");
	 
			}else{
			 jQuery('.full-header').removeClass("fixed");
			}
		} else {
		  jQuery('.full-header').removeClass("fixed");
		  }
	}
	 
	$(document).ready(function(){header();});
	jQuery(window).resize(function() {header();});
	jQuery(window).scroll(function() {header();});

/* End Homepage Stickyheader JS */

/* ----------- SmartBlog Js Start ----------- */
	 var ttblog = $("#ttsmartblog-carousel");
      ttblog.owlCarousel({
     	 items :3, //10 items above 1000px browser width
     	 itemsDesktop : [1199,3], 
     	 itemsDesktopSmall : [991,2], 
     	 itemsTablet: [767,2], 
     	 itemsMobile : [480,1],
		 navigation: true,
		 pagination: false
      });

      // Custom Navigation Events

      $(".ttblog_next").click(function(){
        ttblog.trigger('owl.next');
      })
      $(".ttblog_prev").click(function(){
        ttblog.trigger('owl.prev');
      })
 /* ----------- SmartBlog Js End ----------- */
/*----------------- Testimonial Js Start ------------------------*/

var tttestimonial = $("#tttestimonial-carousel");
      tttestimonial.owlCarousel({
		autoPlay: true,
     	 items : 1, //10 items above 1000px browser width
     	 itemsDesktop : [1200,1], 
     	 itemsDesktopSmall : [991,1], 
     	 itemsTablet: [767,1], 
     	 itemsMobile : [480,1],
		 navigation: true,
		 pagination: false
      });

/*----------------- Testimonial Js End ------------------------*/

// Carousel Counter
	colsCarousel = $('#column-right, #column-left').length;
	if (colsCarousel == 2) {
		ci=2;
	} else if (colsCarousel == 1) {
		ci=4;
	} else {
		ci=4;
}
// product Carousel
$("#content .products-carousel").owlCarousel({
	items: ci,
	itemsDesktop : [1200,3], 
	itemsDesktopSmall : [991,3], 
	itemsTablet: [767,2], 
	itemsMobile : [480,1],
	navigation: true,
	pagination: false
});

$(".customNavigation .next").click(function(){
	$(this).parent().parent().find(".products-carousel").trigger('owl.next');
})
$(".customNavigation .prev").click(function(){
	$(this).parent().parent().find(".products-carousel").trigger('owl.prev');
})
$(".products-list .customNavigation").addClass('owl-navigation');


/* Go to Top JS START */
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 150) {
				$('.goToTop').fadeIn();
			} else {
				$('.goToTop').fadeOut();
			}
		});
	
		// scroll body to 0px on click
		$('.goToTop').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 1000);
			return false;
		});
	});
	/* Go to Top JS END */

	/* Active class in Product List Grid START */
	$('#list-view').click(function() {
		$('#grid-view').removeClass('active');
		$('#list-view').addClass('active');
		$('#content .row > .product-list .product-thumb .image').attr('class', 'image col-xs-5 col-sm-5 col-md-3');
		$('#content .row > .product-list .product-thumb .thumb-description').attr('class', 'thumb-description col-xs-7 col-sm-7 col-md-9');
		//$(".product-layout.product-list .product-thumb .button-group .btn-cart").removeAttr('data-original-title'); /* for remove tooltrip */
	});
	$('#grid-view').click(function() {
		$('#list-view').removeClass('active');
		$('#grid-view').addClass('active');
		$('#content .row > .product-grid .product-thumb .image').attr('class', 'image col-xs-12');
		$('#content .row > .product-grid .product-thumb .thumb-description').attr('class', 'thumb-description col-xs-12');
		//$(".product-layout.product-grid .product-thumb .button-group .btn-cart").attr('data-original-title','Add to cart');/* for add tooltrip */	
	});
	if (localStorage.getItem('display') == 'list') {
		$('#list-view').addClass('active');
	} else {
		$('#grid-view').addClass('active');
	}
	/* Active class in Product List Grid END */

});// Documnet.ready() over....
/* FilterBox - Responsive Content*/
function optionFilter(){

	if ($(window).width() <= 991) {
		$('#column-left .option-filter-box').appendTo('.row #content .category-list');
		$('#column-right .option-filter-box').appendTo('.row #content .category-list');
	} else {
		$('.row #content .category-list .option-filter-box').appendTo('#column-left .option-filter');
		$('.row #content .category-list .option-filter-box').appendTo('#column-right .option-filter');
	}
}
$(document).ready(function(){ optionFilter(); });
$(window).resize(function(){ optionFilter(); });
/*category filter js*/
function footerToggle() {
	if($( window ).width() < 992) {
		
		$("footer .footer-column h5").addClass( "toggle" );
		$("footer .footer-column ul").css( 'display', 'none' );
		$("footer .footer-column.active ul").css( 'display', 'block' );
		$("footer .footer-column h5.toggle").unbind("click");
		$("footer .footer-column h5.toggle").click(function() {
			$(this).parent().toggleClass('active').find('ul.list-unstyled').slideToggle( "fast" );
		});
		
		$("#column-left .panel-heading,#column-right .panel-heading").addClass( "toggle" );
		$("#column-left .list-group,#column-right .list-group").css( 'display', 'none' );
		$("#column-left .panel-default.active .list-group,#column-right .panel-default.active .list-group").css( 'display', 'block' );
		$("#column-left .panel-heading.toggle,#column-right .panel-heading.toggle").unbind("click");
		$("#column-left .panel-heading.toggle,#column-right .panel-heading.toggle").click(function() {
		$(this).parent().toggleClass('active').find('.list-group').slideToggle( "fast" );
		});
		
		$("#column-left .box-heading,#column-right .box-heading").addClass( "toggle" );
		$("#column-left .products-carousel,#column-right .products-carousel").css( 'display', 'none' );
		$("#column-left .products-list.active .products-carousel,#column-right .products-list.active .products-carousel").css( 'display', 'block' );
		$("#column-left .box-heading.toggle,#column-right .box-heading.toggle").unbind("click");
		$("#column-left .box-heading.toggle,#column-right .box-heading.toggle").click(function() {
		$(this).parent().toggleClass('active').find('.products-carousel').slideToggle( "fast" );
		});
		
		$("#ttcmstestimonial .title_block").addClass( "toggle" );
		$("#ttcmstestimonial #tttestimonial-carousel").css( 'display', 'none' );
		$("#ttcmstestimonial .tttestimonial-inner.active tttestimonial-carousel").css( 'display', 'block' );
		$("#ttcmstestimonial .title_block.toggle").unbind("click");
		$("#ttcmstestimonial .title_block.toggle").click(function() {
		$(this).parent().toggleClass('active').find('#tttestimonial-carousel').slideToggle( "fast" );
		});
		
		$("#ttcmsleftservices .title_block").addClass( "toggle" );
		$("#ttcmsleftservices .block_content").css( 'display', 'none' );
		$("#ttcmsleftservices.active .block_content").css( 'display', 'block' );
		$("#ttcmsleftservices .title_block.toggle").unbind("click");
		$("#ttcmsleftservices .title_block").click(function() {
		$(this).parent().toggleClass('active').find('.block_content').slideToggle( "fast" );
		});
		
		$("#ttcmsfooterservice .title_block").addClass( "toggle" );
		$("#ttcmsfooterservice .ttcmsfooterservice").css( 'display', 'none' );
		$("#ttcmsfooterservice.active .ttcmsfooterservice").css( 'display', 'block' );
		$("#ttcmsfooterservice .title_block.toggle").unbind("click");
		$("#ttcmsfooterservice .title_block").click(function() {
		$(this).parent().toggleClass('active').find('.ttcmsfooterservice').slideToggle( "fast" );
		});
		
		
		$("#ttcmsfooter .ttabout-title").addClass( "toggle" );
		$("#ttcmsfooter .ttabout-desc").css( 'display', 'none' );
		$("#ttcmsfooter.active .ttabout-desc").css( 'display', 'block' );
		$("#ttcmsfooter .ttabout-title.toggle").unbind("click");
		$("#ttcmsfooter .ttabout-title").click(function() {
		$(this).parent().toggleClass('active').find('.ttabout-desc').slideToggle( "fast" );
		});
		
		$(".payment-icon-inner > h4").addClass( "toggle" );
		$(".payment-icon-inner .paymentcms").css( 'display', 'none' );
		$(".payment-icon-inner.active .paymentcms").css( 'display', 'block' );
		$(".payment-icon-inner > h4.toggle").unbind("click");
		$(".payment-icon-inner > h4").click(function() {
		$(this).parent().toggleClass('active').find('.paymentcms').slideToggle( "fast" );
		});
		
	} else {
		
		$("footer .footer-column h5").unbind("click");
		$("footer .footer-column h5").removeClass('toggle');
		$("footer .footer-column ul.list-unstyled").css('display', 'block');
		
		$("#column-left .panel-heading,#column-right .panel-heading").unbind("click");
		$("#column-left .panel-heading,#column-right .panel-heading").removeClass( "toggle" );
		$("#column-left .list-group,#column-right .list-group").css( 'display', 'block' );

		$("#column-left .box-heading,#column-right .box-heading").unbind("click");
		$("#column-left .box-heading,#column-right .box-heading").removeClass( "toggle" );
		$("#column-left .products-carousel,#column-right .products-carousel").css( 'display', 'block' );
		
		$("#ttcmstestimonial .title_block").unbind("click");
		$("#ttcmstestimonial .title_block").removeClass( "toggle" );
		$("#ttcmstestimonial #tttestimonial-carousel").css( 'display', 'block' );
		

		$("#ttcmsleftservices .title_block").unbind("click");
		$("#ttcmsleftservices .title_block").removeClass( "toggle" );
		$("#ttcmsleftservices .block_content").css( 'display', 'block' );
		
		$("#ttcmsfooterservice .title_block").unbind("click");
		$("#ttcmsfooterservice .title_block").removeClass( "toggle" );
		$("#ttcmsfooterservice .ttcmsfooterservice").css( 'display', 'block' );
		
		$("#ttcmsfooter .ttabout-title").unbind("click");
		$("#ttcmsfooter .ttabout-title").removeClass( "toggle" );
		$("#ttcmsfooter .ttabout-desc").css( 'display', 'block' );
		
		$(".payment-icon-inner > h4").unbind("click");
		$(".payment-icon-inner > h4").removeClass( "toggle" );
		$(".payment-icon-inner .paymentcms").css( 'display', 'block' );
	}
}

$(document).ready(function() {footerToggle();});
$(window).resize(function() {footerToggle();});


/* Category List - Tree View */
function categoryListTreeView() {
	$(".category-treeview li.category-li").find("ul").parent().prepend("<div class='list-tree'></div>").find("ul").css('display','none');

	$(".category-treeview li.category-li.category-active").find("ul").css('display','block');
	$(".category-treeview li.category-li.category-active").toggleClass('active');
}
$(document).ready(function() {categoryListTreeView();});


/* Category List - TreeView Toggle */
function categoryListTreeViewToggle() {
	$(".category-treeview li.category-li .list-tree").click(function() {
		$(this).parent().toggleClass('active').find('ul').slideToggle();
	});
}
$(document).ready(function() {categoryListTreeViewToggle();});

$(document).ready(function(){ menuMore(); });
function menuToggle() {
	if($( window ).width() < 992) {
		$('#column-left .main-category-list').insertAfter('.full-header .header-middle');
		$(".main-category-list .menu-category ul.dropmenu").css('display', 'none');
		
		$(".main-category-list ul.dropmenu li.TT-Sub-List > i").remove();
		$(".main-category-list ul.dropmenu .dropdown-menu ul li.dropdown-inner > i").remove();

		$(".main-category-list ul.dropmenu li.TT-Sub-List > a").after("<i class='fa fa-angle-down'></i>");
		$(".menu-category li.TT-Sub-List .dropdown-inner ul li.dropdown a.single-dropdown").after("<i class='fa fa-angle-down'></i>");
			
		$(".main-category-list .TT-panel-heading").unbind("click");
		$('.main-category-list .TT-panel-heading').click(function(){
			$(this).parent().toggleClass('ttactive').find('ul.dropmenu').slideToggle( "fast" );
		});
		$(".main-category-list ul.dropmenu li.TT-Sub-List > i").unbind("click");
		$(".main-category-list ul.dropmenu li.TT-Sub-List > i").click(function() {
			$(this).parent().toggleClass("active").find("ul").first().slideToggle();
		});
		
		$(".menu-category li.TT-Sub-List .dropdown-inner ul li.dropdown > i").unbind("click");
		$(".menu-category li.TT-Sub-List .dropdown-inner ul li.dropdown > i").click(function() {
			$(this).parent().toggleClass("active").find(".dropdown-menu").slideToggle();
		});
	}
	else {
		$(".main-category-list .TT-panel-heading").unbind("click");
		$(".main-category-list ul.dropmenu li.TT-Sub-List > i").unbind("click");
		$(".menu-category li.TT-Sub-List .dropdown-inner ul li.dropdown > i").unbind("click");
		$('.full-header .main-category-list').prependTo('#column-left');
		$(".main-category-list").removeClass('ttactive');
		$(".main-category-list .menu-category ul.dropmenu").css('display', 'block');
		$(".menu-category ul.dropmenu li.TT-Sub-List > i").remove();
		$(".menu-category li.TT-Sub-List .dropdown-inner ul li.dropdown > i").remove();
	}
}
$(document).ready(function() {menuToggle();});
$( window ).resize(function(){menuToggle();});

/* Main Menu - MORE items */
function menuMore(){
	//$(function($){
	var max_items = 4;
	var liItems = $('.navbar-nav > li');
	var remainItems = liItems.slice(max_items, liItems.length);
	remainItems.wrapAll('<li class="dropdown more-menu"><div class="dropdown-menu"><div class="dropdown-inner"><ul class="list-unstyled childs_1">');
	$('.more-menu').prepend('<span>More</span>');
	//});
}
/* Animate effect on Review Links - Product Page */
$(".product-total-review, .product-write-review").click(function() {
    $('html, body').animate({ scrollTop: $(".product-tabs").offset().top }, 1000);
});

function responsivecolumn()
{
	if ($(document).width() <= 991)
	{
		$('#page > .container > .row > #column-left').appendTo('#page > .container > .row');
		$('#page > .container > .row > #column-right').appendTo('#page > .container > .row');
	}
	else if($(document).width() >= 992)
	{
		$('#page > .container > .row > #column-left').prependTo('#page > .container > .row');
		$('#page > .container > .row > #column-right').appendTo('#page > .container > .row');
	}
}
$(document).ready(function(){responsivecolumn();});
$(window).resize(function(){responsivecolumn();});
/*category filter js end*/

