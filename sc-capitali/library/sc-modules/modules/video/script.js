(() => {

	let 
		videos,
		videoObserver;

	document.addEventListener( 'DOMContentLoaded', () => {

		initPlayButton();
		initLazyLoad();
	
	});

	function initPlayButton() {

		document.querySelectorAll( '.scm-video__button' ).forEach( button => {

			button.addEventListener( 'click', event => {

				let container = event.target.closest( '.scm-video' );
				let cover     = container.querySelector( '.scm-video__cover' );
				let player    = container.querySelector( '.scm-video__player' );
				let template  = container.querySelector( '.scm-video__player__template' );
				let media     = container.querySelector( '.sc-card__media' );

				player.innerHTML = template.innerHTML;

				media.classList.add( 'sc-card__media--front' );
				
				cover.remove();
				button.remove();

			});

		});

	}

	function initLazyLoad() {

		videos = document.querySelectorAll( '.scm-video' );

		videoObserver = new IntersectionObserver( ( entries, observer ) => {
	
			entries.forEach( entry => {
	
				if( entry.isIntersecting ) {
	
					let video = entry.target;
					let lazy  = video.querySelector( '.scm-video__cover--lazy-load' );

					if( lazy ) {

						let cover = video.querySelector( '.scm-video__cover' );
						let image = cover.dataset.image;

						if( image.length ) {

							cover.setAttribute( 'style', "background-image:url('" + image + "');" );

						}

						lazy.classList.remove( 'scm-video__cover--lazy-load' );

					}

					videoObserver.unobserve( video );
	
				}
	
			});
			
		});
	
		videos.forEach( video => {
	
			videoObserver.observe( video );
	
		});
			
	}

})();