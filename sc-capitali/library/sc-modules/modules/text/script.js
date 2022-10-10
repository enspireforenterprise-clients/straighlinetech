import ResponsiveTable from '../../../../source/scripts/sc-responsive-table.js';

(() => {

	document.addEventListener( 'DOMContentLoaded', function() {
	
		new ResponsiveTable( '.scm-text table:not([role="presentation"])' );

	});

})();
