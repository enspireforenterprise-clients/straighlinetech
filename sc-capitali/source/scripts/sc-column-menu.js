'use strict';

export default class ColumnMenu {

	constructor( containerId, toggleId ) {

		this.containerId    = containerId;
		this.container      = document.getElementById( this.containerId );
		this.toggleId       = toggleId;
		this.toggle         = document.getElementById( this.toggleId );
		this.closeButton    = this.container.querySelector( '.sc-column-menu__close' );
		this.navigation     = this.container.querySelector( 'nav.sc-column-menu__navigation' );
		this.backLinks 		= this.container.querySelectorAll( '.sc-column-menu__back-link' );
		this.scrollPosition = 0;

		if( this.navigation === null ) {

			console.error( 'nav.sc-column-menu__navigation missing from ColumnMenu container. A nav.sc-column-menu__navigation is required and should contain a menu of links inside a ul element.' );
			return;

		}

		this.initMarkup();
		this.initToggleButton();
		this.initCloseButton();
		this.initNavigation();
		this.initKeyboard();
		this.initBackLinks();

	}

	initMarkup() {

		this.container.classList.add( 'sc-column-menu' );
		this.container.classList.add( 'sc-column-menu--initialzed' );

		this.insertOverviewLinks();
		this.insertBackLinks();
		this.insertTitles();

		this.navigation.querySelectorAll( 'a' ).forEach( anchor => {

			anchor.setAttribute( 'role', 'menuitem' );
			anchor.removeAttribute( 'tabindex' );
			anchor.removeAttribute( 'aria-haspopup');

		});
		
	}

	insertOverviewLinks() {

		this.navigation.querySelectorAll( 'a' ).forEach( anchor => {

			let href    = anchor.getAttribute( 'href' );
			let subMenu = this.getSubMenu( anchor );

			if( '#' !== href & false !== subMenu ) {

				let subMenuFirstChild = subMenu.children[0];
				let newListItem       = document.createElement( 'li' );
				let newAnchor         = document.createElement( 'a' );

				newListItem.dataset.depth = subMenuFirstChild.dataset.depth;
				newListItem.setAttribute( 'role', 'none' );
				newListItem.appendChild( newAnchor );
				
				newAnchor.dataset.depth = subMenuFirstChild.dataset.depth;
				newAnchor.innerHTML     = 'Overview';
				newAnchor.setAttribute( 'href', href );
				newAnchor.setAttribute( 'role', 'menuitem' );

				subMenu.insertBefore( newListItem, subMenuFirstChild );

			}

		});

	}

	insertBackLinks() {

		this.navigation.querySelectorAll( 'a' ).forEach( anchor => {

			let subMenu = this.getSubMenu( anchor );

			if( false !== subMenu ) {

				let subMenuFirstChild = subMenu.children[0];
				let newListItem       = document.createElement( 'li' );
				let newAnchor         = document.createElement( 'a' );

				newListItem.dataset.depth = subMenuFirstChild.dataset.depth;
				newListItem.setAttribute( 'role', 'none' );
				newListItem.setAttribute('class','menu-item--no-border');
				newListItem.appendChild( newAnchor );
				
				newAnchor.dataset.depth = subMenuFirstChild.dataset.depth;
				newAnchor.innerHTML     = 'Back';
				newAnchor.setAttribute( 'role', 'menuitem' );
				newAnchor.setAttribute( 'class', 'sc-column-menu__back-link' );
				newAnchor.setAttribute( 'href', '#' );

				subMenu.insertBefore( newListItem, subMenuFirstChild );


			}

		});

	}

	insertTitles() {

		this.navigation.querySelectorAll( 'a' ).forEach( anchor => {

			let title   = anchor.innerHTML;
			let subMenu = this.getSubMenu( anchor );

			if( false !== subMenu ) {

				let subMenuFirstChild = subMenu.children[0];
				let newListItem       = document.createElement( 'li' );
				newListItem.setAttribute('class','menu-item--no-border');
				newListItem.innerHTML = `<span class="sc-column-menu__item__title">${title}</span>`;

				newListItem.dataset.depth = subMenuFirstChild.dataset.depth;
				newListItem.setAttribute( 'role', 'none' );
				
				subMenu.insertBefore( newListItem, subMenuFirstChild );

			}

		});

	}
	
	initToggleButton() {
		
		this.toggle.addEventListener( 'click', function( event ) {
	
			event.preventDefault();
	
			this.toggleMenu();
			

	
		}.bind( this ) );

	}

	initBackLinks() {


		this.navigation.querySelectorAll( '.sc-column-menu__back-link' ).forEach( backLink => {

			backLink.addEventListener( 'click', function( event ) {
	
				event.preventDefault();
				
				this.goBack();

			}.bind( this ) );

		});


	}

	initCloseButton() {

		if( this.closeButton === null ) {

			return;

		}

		this.closeButton.addEventListener( 'click', event => {

			event.preventDefault();

			this.closeMenu();

		});

	}

	initNavigation() {

		this.navigation.querySelectorAll( 'a' ).forEach( anchor => {

			anchor.addEventListener( 'click', event => {

				if( false === this.getSubMenu( event.target ) ) {

					return;

				}

				event.preventDefault();

				this.expandAnchor( event.target, false );

			});

		});

	}

	initKeyboard() {

		document.addEventListener( 'keydown', event => {

			if( ! this.dialogIsOpen() ) {

				return;

			}

			if( event.key === 'Enter' ) {

				this.navigation.querySelectorAll( 'a' ).forEach( anchor => {

					if( event.target === anchor) {

						if( false !== this.getSubMenu( anchor ) ) {

							event.preventDefault(); // stop click event from firing
			
							this.expandAnchor( event.target, true );
			
						} 

						return;

					}

				});

			}

			if( event.key === 'Tab' ) {

				this.tabTrap( event );

				return;

			}

			if( ['Escape', 'ArrowLeft', 'Backspace', 'Delete'].indexOf( event.key ) !== -1 ) {

				this.goBack();

			}

		});

		document.addEventListener( 'keyup', event => {

			if( ! this.dialogIsOpen() ) {

				return;

			}

		});

	}

	tabTrap( event ) {

		let deepestExpandedMenu = this.getDeepestExpandedMenu();
		let direction           = event.shiftKey ? 'backward' : 'forward';

		event.preventDefault();

		if( false === deepestExpandedMenu ) {
			
			let anchors = [...this.container.querySelectorAll( 'header a, header button, nav > ul > li > a, footer a' )];

			this.trapAnchors( anchors, direction );

			return;
			
		}

		let children = [...deepestExpandedMenu.children];
		let anchors  = children.map( child => child.querySelector( 'a' ) ).filter( value => value !== null );

		this.trapAnchors( anchors, direction );
		
	}

	trapAnchors( anchors, direction ) {

		console.log( 'anchors', anchors );

		let active = 0;

		anchors.forEach( ( anchor, i ) => {

			if( document.activeElement === anchor ) {

				active = i;

			}

		});

		if( 'forward' === direction ) {
			
			active++;

			if( active > anchors.length - 1 ) {

				active = 0;

			}

		} else {
			
			active--;

			if( active === -1 ) {

				active = anchors.length - 1;

			}

		}

		anchors[active].focus();

	}

	openMenu() {

		this.container.classList.add( 'sc-column-menu--open' );

		this.container.querySelectorAll( '[aria-expanded="true"]' ).forEach( expanded => {

			expanded.setAttribute( 'aria-expanded', 'false' );

		});

		if( this.closeButton !== null ) {

			this.closeButton.focus();

		}
		
		this.scrollPosition = window.scrollY;
		document.body.style.overflow = 'hidden';
		document.body.classList.add('mobile-navigation-is-open');

		this.updateCurrentDepth();

	}
	
	closeMenu() {

		this.container.classList.remove( 'sc-column-menu--open' );

		this.toggle.focus();

		document.body.style.overflow = 'visible';
		document.body.classList.remove('mobile-navigation-is-open');
		window.scroll( 0, this.scrollPosition );

	}

	toggleMenu() {

		if( this.dialogIsOpen() ) {
	
			this.closeMenu();
	
		} else {
	
			this.openMenu();
	
		}

	}

	expandAnchor( anchor, focusFirstMenuItem ) {

		let anchorsToClose = anchor.closest( 'ul' ).querySelectorAll( 'li.menu-item-has-children a' );
		
		anchorsToClose.forEach( anchor => {
			
			anchor.setAttribute( 'aria-expanded', 'false' );
			
		});
		
		anchor.setAttribute( 'aria-expanded', 'true' );
		
		if( focusFirstMenuItem ) {
			
			let subMenu = anchor.closest( 'li' ).querySelector( 'ul' );

			subMenu.querySelector( 'a' ).focus();

		}

		this.updateCurrentDepth();

	}

	goBack() {

		if( ! this.dialogIsOpen() ) {

			return;

		}

		let deepestExpandedMenu = this.getDeepestExpandedMenu();

		if( false === deepestExpandedMenu ) {

			this.closeMenu();

			return;

		}

		// Collapse current menu
		deepestExpandedMenu.closest( 'li' ).querySelector( 'a' ).setAttribute( 'aria-expanded', 'false' );
		
		// Focus parent menu item
		deepestExpandedMenu.closest( 'ul' ).closest( 'li' ).querySelector( 'a' ).focus();

		this.updateCurrentDepth();

	}

	updateCurrentDepth() {

		let deepestExpandedMenu = this.getDeepestExpandedMenu();
		let currentDepth        = 0;

		if( false !== deepestExpandedMenu ) {

			currentDepth = deepestExpandedMenu.querySelector( 'li' ).dataset.depth;

		}

		this.navigation.dataset.currentDepth = currentDepth;

	}

	dialogIsOpen() {

		return this.container.classList.contains( 'sc-column-menu--open' );

	}

	getSubMenu( anchor ) {

		let parentListItem = anchor.closest( 'li' );

		if( parentListItem === null ) {

			return false;

		}

		let subMenu = parentListItem.querySelector( 'ul' );

		if( subMenu !== null ) {

			return subMenu;

		}

		return false;

	}

	getDeepestExpandedMenu() {

		let expandedMenus = [...this.container.querySelectorAll( '[aria-expanded="true"] + ul' )];

		if( ! expandedMenus.length ) {

			return false;

		}

		return expandedMenus[ expandedMenus.length - 1];

	}

}
