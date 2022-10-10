(() => {

	let 
		images,
		imageObserver;

	document.addEventListener( 'DOMContentLoaded', () => {

		images        = document.querySelectorAll( '.scm-image__container__image--lazy-load' );
		imageObserver = new IntersectionObserver( ( entries, observer ) => {
	
			entries.forEach( entry => {
	
				if( entry.isIntersecting ) {
	
					let image = entry.target;

					image.src = image.dataset.src;
					image.classList.remove( 'scm-image__container__image--lazy-load' );
					imageObserver.unobserve( image );
	
				}
	
			});
			
		});
	
		images.forEach( image => {
	
			imageObserver.observe( image );
	
		});
	
	});

})();