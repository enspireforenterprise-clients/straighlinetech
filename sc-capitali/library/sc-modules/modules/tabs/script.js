import ResponsiveTable from '../../../../source/scripts/sc-responsive-table.js';

(() => {

	document.addEventListener( 'DOMContentLoaded', function() {

		if( null == document.querySelector( '.sc-module-tabs' ) ) {

			return;

		}

		new ResponsiveTable( '.sc-module-tabs table:not([role="presentation"])' );

		document.addEventListener( 'click', event => {

			let resizeEvent = window.document.createEvent( 'UIEvents' ); 
			resizeEvent.initUIEvent( 'resize', true, false, window, 0 ); 
			window.dispatchEvent( resizeEvent );

		});

	});

})();
