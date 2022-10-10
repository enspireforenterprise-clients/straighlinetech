<?php if ( ! DEFINED('ABSPATH') ) die('No Direct Access Allowed');

function sc_accessible_nav_menu_link_attributes( $atts, $item, $args, $depth ) {

	$item_has_children = in_array( 'menu-item-has-children', $item->classes );

	if ( $item_has_children ) {

		$atts['aria-haspopup'] = 'true';
		$atts['aria-expanded'] = 'false';
		$atts['aria-label']		 = $item->title;

	}

	if ( $depth > 0 ) {

		$atts['tabindex']	=	'-1';

	}

	$atts['role']	=	'menuitem';

	return $atts;

}

add_filter( 'nav_menu_link_attributes', 'sc_accessible_nav_menu_link_attributes', 10, 4 );
