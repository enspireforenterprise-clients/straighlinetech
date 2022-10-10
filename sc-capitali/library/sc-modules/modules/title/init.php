<?php

SC_Modules::register_module_type( 'Title', [

	'fluid' => false,
	'size'  => 12,
	'sizes' => [3, 4, 5, 6, 7, 8, 9, 10, 11, 12]

]);

add_action( 'init', 'sc_heading_init_shortcodes' );

function sc_heading_init_shortcodes() {

	add_shortcode( 'h1', 'sc_heading_shortcode' );
	add_shortcode( 'h2', 'sc_heading_shortcode' );
	add_shortcode( 'h3', 'sc_heading_shortcode' );
	add_shortcode( 'h4', 'sc_heading_shortcode' );
	add_shortcode( 'h5', 'sc_heading_shortcode' );
	add_shortcode( 'h6', 'sc_heading_shortcode' );

}

function sc_heading_shortcode( $atts, $content = null, $shortcode = '' ) {

	$title     = empty( $atts['title'] )     ? '' : $atts['title'];
	$overline  = empty( $atts['overline'] )  ? '' : $atts['overline'];
	$sub_title = empty( $atts['sub_title'] ) ? '' : $atts['sub_title'];
	$size 	   = empty( $atts['size'] )      ? 'medium' : $atts['size'];
	$separator = empty( $atts['separator'] ) ? 'false'  : $atts['separator'];
	$sub_style = empty( $atts['substyle'] )  ? 'italic' : $atts['substyle'];
	$align 	   = empty( $atts['align'] )  ? 'left' : $atts['align'];
	$element   = $shortcode;

	if( empty( $title ) && is_string( $content ) ) {

		$title = $content;

	}

	if( empty( $title ) ) {

		return '';

	}

	return sc_get_heading(
		$title, [
			'overline'  => $overline,
			'sub_title' => $sub_title,
			'element'   => $element,
			'size'      => $size,
			'align'		=> $align,
			'separator' => $separator,
			'sub_style' => $sub_style
		]
	);

}

function sc_get_heading( $title, $options = [] ) {

	if( empty( $title ) ) {
		
		return '';
		
	}

	$segments = [];
	$classes  = [ 'sc-heading' ];
	$options  = array_merge([
		'element'   => 'h2',
		'size'      => '',
		'sub_style' => '',
		'align' => ''
	], $options );

	if( ! empty( $options['size'] ) ) {

		$classes[] = 'sc-heading--size-' . $options['size'];

	}

	if( ! empty( $options['sub_style'] ) ) {

		$classes[] = 'sc-heading--substyle-' . $options['sub_style'];

	}

	if( ! empty( $options['separator'] ) ) {

		$classes[] = 'sc-heading--separator-' . $options['separator'];

	}

	if( ! empty( $options['align'] ) ) {

		$classes[] = 'sc-heading--align-' . $options['align'];

	}

	if( ! empty( $options['overline'] ) ) {
	
		$segments[] = sprintf( 
			'<p class="sc-heading__overline">%s</p>', 
			esc_html( $options['overline'] )
		);
		
	}

	$post_id = get_the_ID();  

	$segments[] = sprintf('<%1$s class="sc-heading__title" id="article-number-%3$u" >%2$s</%1$s>', 
		$options['element'], 
		esc_html( $title ),
		$post_id
	);

	if( ! empty( $options['sub_title'] ) ) {
		
		$segments[] = sprintf( 
			'<p class="sc-heading__sub-title">%s</p>', 
			esc_html( $options['sub_title'] )
		);
		
	}
	
	return sprintf('
		<div class="%2$s">
			%1$s
		</div>', 
		implode( ' ', $segments),
		esc_attr( implode( ' ', $classes ) )
	);
	
}
