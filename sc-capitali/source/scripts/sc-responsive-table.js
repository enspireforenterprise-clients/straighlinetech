'use strict';

export default class ResponsiveTable {

	constructor( selector ) {

		this.selector = selector;
		
		[...document.querySelectorAll( this.selector )].forEach( table => { 

			this.prepareTable( table );

		});

		this.tables = document.querySelectorAll( this.selector );

		this.update();

		window.addEventListener( 'resize', event => { this.update(); } );

	}

	prepareTable( table ) {

		if( 'presentation' === table.getAttribute( 'role' ) ) {

			return;

		}

		let container = document.createElement( 'div' );
		let tempTable = document.createElement( 'table' );

		tempTable.innerHTML = `<thead><tr></tr></thead><tbody></tbody>`;

		[...table.querySelectorAll( 'tr' )].forEach( ( tr, i ) => {

			if( 0 === i ) {

				[...tr.querySelectorAll( 'th, td' )].forEach( cell => {

					tempTable.querySelector( 'thead tr' ).innerHTML += `<th scope="col">${cell.innerText}</th>`;

				});

			} else {

				tempTable.querySelector( 'tbody' ).innerHTML += `<tr>${[...tr.querySelectorAll( 'td' )].map( cell => {

					return `<td>${cell.innerHTML}</td>`;

				}).join( '' )}</tr>`;

			}

		});

		table.classList.add( 'sc-responsive-table' );
		table.innerHTML = tempTable.innerHTML;

		table.parentElement.insertBefore( container, table );
		table.remove();
		
		container.append( table );
		container.classList.add( 'sc-responsive-table-container' );

	}

	update() {

		let overflowDetected = false;

		this.tables.forEach( table => {

			if( this.isOverflowing( table ) ) {

				overflowDetected = true;

			}

		});

		if( overflowDetected ) {

			this.tables.forEach( table => { 
	
				this.updateTable( table );
	
			});

		}

	}

	updateTable( table ) {

		let 
			heights     = [],
			rows        = table.querySelectorAll( 'tr' ),
			totalRows   = rows.length,
			cellsPerRow = 0;

		if( ! totalRows ) {
			
			return;
		
		}

		table.classList.add( 'sc-responsive-table--horizontal' );

		cellsPerRow = rows[0].querySelectorAll( 'th, td' ).length;
		heights     = [];

		for( let i = 0; i < cellsPerRow; i++ ) {

			let height = 0;

			rows.forEach( ( row ) => {

				let cell = row.querySelector( 'th:nth-child(' + (i + 1) + '), td:nth-child(' + (i + 1) + ')' );

				if( cell.clientHeight > height ) {

					height = cell.clientHeight;

				}

			});

			heights.push( height );

			heights.forEach( ( height, ii ) => {

				rows.forEach( row => {

					let cell = row.querySelector( 'th:nth-child(' + (ii + 1) + '), td:nth-child(' + (ii + 1) + ')' );

					cell.setAttribute( 'style', 'height:' + heights[ii] + 'px' );

				});

			});

		}

	}

	resetTable( table ) {

		let cells = table.querySelectorAll( 'th, td' );
		
		table.classList.remove( 'sc-responsive-table--horizontal' );

		cells.forEach( cell => {

			cell.removeAttribute( 'style' );

		});

	}

	isOverflowing( table ) {

		this.resetTable( table );

		let parentWidth = table.parentElement.clientWidth;
		let tableWidth  = table.clientWidth;

		if( tableWidth > parentWidth ) {

			return true;

		}

		return false;

	}

}
