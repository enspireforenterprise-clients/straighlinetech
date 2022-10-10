<?php if (! defined('ABSPATH')) die('No direct access allowed');
/* DO NOT MODIFY THIS FILE OR THEME
 * --------------------------------------------------
 * If you need to make direct changes to this file or any file in this theme
 * you should make a full copy the entire theme, re-name it, activate it, and 
 * make your changes there. Failure to do this will result in changes being 
 * overwritten by an automatic update in the future.
 */

require_once( 'widgets/sc-widget-sidebar-nav/sc-widget-sidebar-nav.php' );

add_action( 'widgets_init', 'sc_widget_init' );

function sc_widget_init() {

	register_widget('SC_Widget_Sidebar_Nav');

}

//------------------------------------------------------------------------------

add_filter( 'sc_sidebar_id', 'sc_sidebar_id' );

function sc_sidebar_id( $sidebar ) {

	global $post;

	if( get_field( 'custom_sidebar', $post->ID ) ) {

		return sanitize_title( get_field( 'custom_sidebar' ) ); 

	}

	return $sidebar;

}

//------------------------------------------------------------------------------

add_action( 'init', 'sc_init_widget_areas' );

function sc_init_widget_areas() {

	register_sidebar(
		array(
			'name'          => 'Default Sidebar',
			'id'            => 'default-sidebar',
			'description'   => '',
			'class'         => 'sc-sidebar sc-sidebar-default',
			'before_widget' => '<div id="%1$s" class="sc-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="sc-widget-title">',
			'after_title'   => '</h4>'
		)
	);

	register_sidebar(
		array(
			'name'          => 'Blog Sidebar',
			'id'            => 'blog-sidebar',
			'description'   => '',
			'class'         => 'sc-sidebar sc-sidebar-blog',
			'before_widget' => '<div id="%1$s" class="sc-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="sc-widget-title">',
			'after_title'   => '</h4>'
		)
	);

}