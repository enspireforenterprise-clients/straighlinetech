import {}           from '../vendor/match-height/match-height.min.js';
import MediaQueries from './sc-media-queries.js';
import ColumnMenu   from './sc-column-menu.js';

import '../../library/sc-modules/modules/**/*.js';


/* Match Height
------------------------------------------------------------------------------*/

(() => {

	document.addEventListener( 'DOMContentLoaded', event => {

		jQuery.fn.matchHeight._update();

	});


	window.addEventListener( 'load', event => {

		jQuery.fn.matchHeight._update();

	});

})();


/* Location Finder
------------------------------------------------------------------------------*/
(() => {

	document.addEventListener( 'DOMContentLoaded', event => {

		let locationResultsDiv = document.querySelector('.scmu-sites__results');

		if(locationResultsDiv) {

			locationResultsDiv.addEventListener('efeResultsUpdated', event => {

				jQuery('.scmu-site__address').matchHeight();

				jQuery('.scmu-site__services').matchHeight();

			});


		}

	});

})();


/* Header Search
------------------------------------------------------------------------------*/

(() => {

	let
		searchForm,
		searchField,
		searchInput,
		searchButton,
		searchButtonText;

	window.addEventListener( 'DOMContentLoaded', (event) => {

		searchForm       = document.querySelector('.header .sc-search-form');
		searchField      = document.querySelector('.header .sc-search-form__field');
		searchInput      = document.querySelector('.header .sc-search-form__field__input');
		searchButton     = document.querySelector('.header .sc-search-form__button');
		searchButtonText = document.querySelector('.header .sc-search-form__button__text');

		searchButtonText.innerHTML = 'Open Website Search';

    searchButton.addEventListener( 'click', (event) => {

			if( ! searchIsOpen() ) {

				event.preventDefault();

				openSearch();

				return;

			}

			closeSearch();

		});

		searchButton.addEventListener( 'blur', (event) => {

			closeWhenNotFocused();

		});

		searchInput.addEventListener( 'blur', (event) => {

			closeWhenNotFocused();

		});

		function openSearch() {

			searchForm.classList.add( 'sc-search-form--open' );
			searchField.classList.add( 'sc-search-form__field--open' );
			searchInput.classList.add( 'sc-search-form__field__input--open' );
			searchButton.classList.add( 'sc-search-form__button--open' );

			searchButtonText.innerHTML = 'Submit Website Search';

			searchInput.focus();

		}

		function closeSearch() {

			searchForm.classList.remove( 'sc-search-form--open' );
			searchField.classList.remove( 'sc-search-form__field--open' );
			searchInput.classList.remove( 'sc-search-form__field__input--open' );
			searchButton.classList.remove( 'sc-search-form__button--open' );

			searchButtonText.innerHTML = 'Open Website Search';

		}

		function closeWhenNotFocused() {

			setTimeout(function () {

				if( document.activeElement != searchButton && document.activeElement != searchInput ) {

					closeSearch();

				}

			}, 100);

		}

		function searchIsOpen() {

			if( document.querySelector('.header .sc-search-form--open') ) {

				return true;

			}

			return false;

		}

	});

})();


/* Off Canvas Menus
------------------------------------------------------------------------------*/

(() => {

	document.addEventListener( 'DOMContentLoaded', event => {

		new ColumnMenu( 'mobile-menu',  'mobile-menu-button' );

		if( null !== document.getElementById( 'account-link' ) ) {

			new ColumnMenu( 'account-menu', 'account-link' );

		}

	});

})();


/* Modules
------------------------------------------------------------------------------*/

(function($) {

	$(document).ready(function() {

		if($('.page-template-default, .post-template-default, .sc-news-template-default').length) {

			//sc.explodableModule.init();

		}

	});

})(jQuery);


/* Responsive Videos
------------------------------------------------------------------------------*/

(function($) {

	var videos;

	$(document).ready(function() {

		videos = $('iframe[src*="//player.vimeo.com"], iframe[src*="//www.youtube.com"]');

		generateAspectRatios();
		update();

		$(window).resize(_.throttle(onResize, 250));

	});

	function onResize() {

		update();

	}

	function generateAspectRatios() {

		videos.each(function(i, video) {

			var width  = 16;
			var height = 9;

			if( this.width && this.height ) {

				width  = this.width;
				height = this.height;

			}

			$(this)
				.data('aspect-ratio', height / width)
				.removeAttr('height')
				.removeAttr('width');

		});

	}

	function update() {

		videos.each(function(i, video) {

			var width = $(video).parent().width();

			$(video)
				.width(width)
				.height(width * $(video).data('aspect-ratio'));

		});

	}

})(jQuery);


/* Notices
------------------------------------------------------------------------------*/

(() => {

	let container;

	document.addEventListener( 'DOMContentLoaded', event => {

		init();

		document.addEventListener( 'resize', event => {

			update();

		});

		update();

	});

	window.addEventListener( 'load', event => {

		update();

	});

	function init() {

		container = document.getElementById( 'site-notices' );

		if( null === container ) {

			return;

		}

		container.innerHTML = container.querySelector( 'script' ).innerHTML;

		[...container.querySelectorAll( '.site-notice' )].forEach( noticeElement => {

			if( typeof noticeElement.dataset.noticeId !== 'undefined' ) {

				let cookieName = 'sc-notice-' + noticeElement.dataset.noticeId;

				if( null !== getCookie( cookieName ) ) {

					noticeElement.remove();

				}

			}

		});

		[...container.querySelectorAll( '[data-notice-action="dismiss"]' )].forEach( dismissActionElement => {

			dismissActionElement.addEventListener( 'click', event => {

				event.preventDefault();

				let noticeElement = event.target.closest( '.site-notice' );

				if( typeof noticeElement.dataset.noticeId !== 'undefined' ) {

					let cookieName = 'sc-notice-' + noticeElement.dataset.noticeId;

					setCookie( cookieName, 'dismissed' );

				}

				noticeElement.remove();

				update();

			});

		});

	}

	function update() {

		if( null === container ) {

			return;

		}

		let height = container.clientHeight;

		document.querySelector( 'body' ).style.marginTop = height + 'px';
		document.getElementById( 'header' ).style.marginBottom = height + 'px';

	}

	function getCookie( name ) {

		var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');

		return v ? v[2] : null;

	}

	function setCookie( name, value, days ) {

		var d = new Date;

		d.setTime( d.getTime() + 24 * 60 * 60 * 1000 * days );

		document.cookie = name + "=" + value + ";path=/;expires=" + d.toGMTString();

	}

	function deleteCookie( name ) {

		setCookie( name, '', -1 );

	}

})();


/* Interior Banner
------------------------------------------------------------------------------*/

(() => {

	document.addEventListener( 'DOMContentLoaded', event => {

		update();

	});


	window.addEventListener( 'load', event => {

		update();

	});

	window.addEventListener( 'resize', event => {

		update();

	});

	function update() {

		let pageBanner = document.querySelector( '#page-banner-image' );

		if( typeof( pageBanner ) != 'undefined' && pageBanner != null ) {

			let image  = getMobileFirstProperty( pageBanner, 'image' );
			let valign = getMobileFirstProperty( pageBanner, 'valign' );
			let halign = getMobileFirstProperty( pageBanner, 'halign' );

			if( image != '' ) {

				pageBanner.style.backgroundImage    = `url(${image})`;
				pageBanner.style.backgroundPosition = valign  + " " + halign;

			}

		}

	}

	function getMobileFirstProperty( background, property ) {

		let sizes = ['Xs', 'Sm', 'Md', 'Lg', 'Xl', 'Hg'];
		let value = background.dataset[`${property}XsUp`];

		sizes.forEach( size => {

			if( new MediaQueries( size.toLowerCase() + '_up').match ) {

				value = background.dataset[`${property}${size}Up`];

			}

		});

		return value;

	}

})();


/* Woocommerce
------------------------------------------------------------------------------*/

(() => {

	document.addEventListener( 'DOMContentLoaded', ( event ) => {

		jQuery('.woocommerce-loop-product__title').matchHeight();

	});

})();


/* Offset # Links fo Fixed Header
------------------------------------------------------------------------------*/

(() => {

	window.addEventListener( 'load',       updateScrollPosition );
	window.addEventListener( 'hashchange', updateScrollPosition );
	window.addEventListener( 'scroll',     onScroll );

	function onScroll() {

		window.removeEventListener( 'scroll', onScroll );
		updateScrollPosition();

	}

	function getHeaderOffset() {

		return 65;

	}

	function updateScrollPosition() {

		let
			hash,
			target;

		// Get hash, e.g. #mathematics
		hash = window.location.hash;

		if( hash.length < 2 ) {
			return;
		}

		// Get :target, e.g. <h2 id="mathematics">...</h2>
		target = document.getElementById( hash.slice(1) );

		if( target === null ) {
			return;
		}

		// Get distance of :target from top of viewport. If it's near zero, we assume
		// that the user was just scrolled to the :target.
		if( target.getBoundingClientRect().top < 2 ) {

			window.scrollBy( 0, -getHeaderOffset() );

		}

	}

})();

/* Landing Page
------------------------------------------------------------------------------*/

(function($) {

	$(document).ready(function(){

		if( ! $('#gravity-form-html').length ) {
			return;
		}

		$('.sticky-landing-page-button').live( 'click', function() {
			if ( $(document).width() < 992 ) {
				$('body').prepend($('#gravity-form-html'));
				$('#gravity-form-html').addClass('open');
				$('body').addClass('modal-open');
			} else {
				$("html, body").animate({ scrollTop: 0 }, "slow");
			}
		});

		$('#gravity-form-html .sc-column-menu__close').click(function(){
			$('#gravity-form-html').removeClass('open');
			$('body').removeClass('modal-open');
		});

		var startY = $('#page-banner').position().top + $('#page-banner').outerHeight();

		$(window).scroll(function(){
			checkY();
		});

		function checkY() {
			if( $(window).scrollTop() > startY ){
				$('.sticky-landing-page-button').addClass('open')
			} else {
				$('.sticky-landing-page-button').removeClass('open');
			}
		}

		checkY();

	});

	///////////
	///////////

	let banner, form;

	document.addEventListener( 'DOMContentLoaded', event => {


		if(  ! document.querySelector( 'body' ).classList.contains( 'page-template-landing-page' )
			&& ! document.querySelector( 'body' ).classList.contains( 'page-template-landing-page-sidebar' ) ) {

			return;

		}

		banner = document.getElementById( 'page-banner' );
		form   = document.getElementById( 'gravity-form-html' );

		update();

		window.addEventListener( 'load', event => {

			update();

		});

		window.addEventListener( 'resize', event => {

			update();

		});

	});

	function update() {

		banner.style.marginBottom = '0';

		if( form.clientHeight > banner.clientHeight ) {

			banner.style.marginBottom = ( form.clientHeight - banner.clientHeight ) + 'px';

		}

	}

})(jQuery);


/* Percent Dials (Used on my account page)
------------------------------------------------------------------------------*/

(() => {

	let dials;

	document.addEventListener( 'DOMContentLoaded', event => {

		dials = [...document.querySelectorAll( '.sc-percent-dial' )];

		dials.forEach( dial => {

			let currentValue = parseFloat( dial.dataset.scPercentDialValue );
			let maxValue     = parseFloat( dial.dataset.scPercentDialMax );
			let percent      = currentValue > maxValue ? 100 : currentValue / maxValue * 100;
			let path         = dial.querySelector( '.sc-percent-dial__meter__fill' );

			if( null === path ) {
				return;
			}

			let pathLength   = path.getTotalLength();

			path.style.strokeDasharray  = pathLength;
			path.style.strokeDashoffset = (percent / 100 * pathLength) - pathLength;
			path.style.opacity          = 1;

		});

	});

})();


/* Update spacing under page banner when rewards header is shown
------------------------------------------------------------------------------*/

(() => {

	let rewardsHeader;
	let pageBanner;

	document.addEventListener( 'DOMContentLoaded', event => {

		rewardsHeader = document.querySelector( '.sc-rewards-header' );
		pageBanner    = document.querySelector( '.page-banner' );

		if( null === rewardsHeader ) return;

		window.addEventListener( 'resize', event => {

			update();

		});

		update();

	});

	function update() {

		let rewardsHeaderBounds = rewardsHeader.getBoundingClientRect();
		let pageBannerBounds    = pageBanner.getBoundingClientRect();

		if( ( rewardsHeaderBounds.top + rewardsHeaderBounds.height ) > ( pageBannerBounds.top + pageBannerBounds.height ) ) {

			pageBanner.style.marginBottom = ( ( rewardsHeaderBounds.top + rewardsHeaderBounds.height ) - ( pageBannerBounds.top + pageBannerBounds.height ) ) + 'px';

		} else {

			pageBanner.style.marginBottom = '0';

		}

	}

})();


/* 3rd tier main navigation
------------------------------------------------------------------------------*/

(function($) {

  $(document).ready(function() {
    let menuColumnWidth;
    $('.header__navigation .menu-item').mouseover(function() {
      // Toggle 3t menus
      if ( $(this).attr('data-depth') == '1' && $(this).find('.sub-menu').length !== 0) {
        menuColumnWidth = $(this).children('.sub-menu').width();
        $(this).parent('.sub-menu').css({'padding-right':menuColumnWidth + 50})
        $(".header__navigation .menu-item[data-depth='1'] .sub-menu").hide();
        $(this).children().show();
      } else if ($(this).attr('data-depth') == '1' && $(this).find('.sub-menu').length == 0) {
        $(this).parent('.sub-menu').css({'padding-right':'0px'})
        $(".header__navigation .menu-item[data-depth='1'] .sub-menu").hide();
      }
    });
  });

})(jQuery);
