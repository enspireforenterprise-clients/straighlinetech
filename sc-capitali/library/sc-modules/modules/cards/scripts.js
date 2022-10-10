import MediaQueries from '../../../../source/scripts/sc-media-queries.js';

class Cards {

	constructor( container ) {

		this.container = container;

		window.addEventListener( 'load',   () => { this.update(); });
		window.addEventListener( 'resize', () => { this.update(); });

	}

	update() {

		if( new MediaQueries( 'lg_up' ).match ) {

			this.updateDesktop(); return;

		}

		this.updateMobile();

		jQuery( '.card__text__location' ).matchHeight();

	}
}

(() => {

	document.addEventListener( 'DOMContentLoaded', () => {
	
		[...document.querySelectorAll( '.scm-cards' )].forEach( element => {
	
			new Cards( element );
	
		});

	});

})();
