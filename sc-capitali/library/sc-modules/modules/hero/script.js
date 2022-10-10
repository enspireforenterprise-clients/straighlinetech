import {} from '../../../../source/vendor/slick/slick.js';
(() => {

	let 
		hero;

	document.addEventListener( 'DOMContentLoaded', function() {

		init();
		setupListeners();

	});  
	function init() {

		jQuery( '.scm-hero .scm-hero__slider' ).slick({
			arrows:       true, 
			dots:         true,
            customPaging: function(slider, i) { 
				return '<span>' + jQuery(slider.$slides[i]).attr('title') + '</span><button class="tab"></button>';
			},
			fade:		  true,
			speed: 2000,
			cssEase: 'ease-in-out',
			prevArrow:    '<button type="button" class="slick-prev"><span class="sr-only">Previous</span></button>',
			nextAttow: 	  '<button type="button" class="slick-next"><span class="sr-only">Previous</span></button>',
			slidesToShow: 1,
			rows:         0
		});

		

	}




})();