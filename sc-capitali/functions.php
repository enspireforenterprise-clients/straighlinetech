<?php if( ! defined( 'ABSPATH' ) ) die( 'No direct access allowed' );

// Module Margins
//
add_theme_support( 'sc-module-margins' );

// Inlcude Core Theme Libs
//
require_once( 'library/advanced-custom-fields/bootstrap.php' );
require_once( 'library/sc-customizer/bootstrap.php' );
require_once( 'library/sc-widgets/bootstrap.php' );
require_once( 'library/sc-accessible-menu/bootstrap.php' );

// Register Custom Post Types
//
require_once( 'library/sc-team/bootstrap.php' );
require_once( 'library/sc-templates/bootstrap.php' );

//------------------------------------------------------------------------------

function sc_load_scripts() {

	remove_filter( 'style_loader_src',  'sc_remove_querystring_from_assets' );
	remove_filter( 'script_loader_src', 'sc_remove_querystring_from_assets' );

	global $template;

	$child_theme_dir = get_stylesheet_directory_uri();
	$version         = '1.0.10';

	// if( 1 === get_current_blog_id() ) {
		
	// 	wp_enqueue_style( 
	// 		'style', 
	// 		$child_theme_dir . '/dist/css/style.css',
	// 		[],
	// 		$version
	// 	);
		
		
	// } else {//}
		
		wp_enqueue_style( 
			'style', 
			SC_Customizer::stylesheet()->get_generated_file_url( is_customize_preview() ),
			[],
			$version
		);
		
	

	wp_enqueue_script( 
		'scripts', 
		$child_theme_dir . '/dist/js/scripts.js', 
		[ 'jquery', 'underscore' ]
	);

	wp_enqueue_script( 
		'ie11-polyfills', 
		'https://polyfill.io/v3/polyfill.min.js?features=Element.prototype.closest,Element.prototype.append,IntersectionObserver'
	);

}

//------------------------------------------------------------------------------

function sc_init_image_sizes() {

	// Featured Image
	//
	add_image_size( 'featured-image',      300,  300, true );
	add_image_size( 'archive-item-detail', 1027, 550, true );

	// Interior Page Banner
	//
	add_image_size( 'interior-banner-hg-up', 1000, 292, array( 'center', 'top' ) );
	add_image_size( 'interior-banner-xl-up', 900, 292,  array( 'center', 'top' ) );
	add_image_size( 'interior-banner-lg-up', 800, 292,  array( 'center', 'top' ) );
	add_image_size( 'interior-banner-md-up', 700, 292,  array( 'center', 'top' ) );
	add_image_size( 'interior-banner-sm-up', 600,  260, array( 'center', 'top' ) );
	add_image_size( 'interior-banner-xs-up', 576,  130, array( 'center', 'top' ) );

}

//------------------------------------------------------------------------------

function sc_init_menus() {

	// Register nav menus
	//
	register_nav_menus(
		array(
			'header_menu_main'  	=> 'Header Menu - Main',
			'footer_menu_main'  	=> 'Footer Menu - Main'
			
		)
	);

}

//------------------------------------------------------------------------------


//------------------------------------------------------------------------------

function sc_page_banner_attributes_filter( $attributes ) {

	global $template, $post;

	$image_size_prefix  = 'interior-banner-';
	$base_template_name = basename( $template );

	$sizes  = array( 'hg', 'lg', 'xl', 'md', 'sm', 'xs' );
	$images = (object) array();
	$image  = '';
	$valign = '';
	$halign = '';

	// Get default image and alignment values. Each size will be checked and the
	// first one that contains a non-empty value will be used as the default.
	//
	for( $c = 0; $c < count( $sizes ); $c++ ) {

		$size       = $sizes[ $c ];
		$image_val  = get_field( $size . '_image' );
		$valign_val = get_field( $size . '_alignment' )['vertical'];
		$halign_val = get_field( $size . '_alignment' )['horizontal'];

		if( empty( $image ) && ! empty( $image_val ) ) {

			$image = $image_val;

		}

		if( empty( $valign ) && ! empty( $valign_val ) ) {

			$valign = $valign_val;

		}

		if( empty( $halign ) && ! empty( $halign_val ) ) {

			$halign = $halign_val;

		}
	}

	// loop over each size from largest to smallest and set the image and
	// alignment values for each.
	//
	for( $c = 0; $c < count( $sizes ); $c++ ) {

		$size       = $sizes[ $c ];
		$image_val  = get_field( $size . '_image' );
		$valign_val = get_field( $size . '_alignment' )['vertical'];
		$halign_val = get_field( $size . '_alignment' )['horizontal'];

		if( ! empty( $image_val ) ) {

			$image = $image_val;

		}

		if( ! empty( $valign_val ) ) {

			$valign = $valign_val;

		}

		if( ! empty( $halign_val ) ) {

			$halign = $halign_val;

		}

		$attributes[ 'data-image-'  . $size . '-up' ] = $image ? $image['sizes'][ $image_size_prefix . $size . '-up' ] : '';
		$attributes[ 'data-valign-' . $size . '-up' ] = $valign;
		$attributes[ 'data-halign-' . $size . '-up' ] = $halign;

	}

	// get the deault image
	//
	$default_image = get_theme_mod( 'sc_default_interior_banner', '' );

	if( is_int( $default_image ) ) {

		$default_image = wp_get_attachment_image_src(
			$default_image,
			$image_size_prefix . 'hg-up'
		);

		if( isset( $default_image[0] ) ) {

			$default_image = $default_image[0];

		}

	}

	if( empty( $default_image ) ) {

		$default_image = sc_get_image( 'default-interior-banner.jpg', false );

	}

	$attributes['id'] = 'page-banner-image';
	$attributes['class'] = 'page-banner__image-container';

	$attributes['style'] = 'background-image: url(\'' . $default_image . '\')';

	if( ! empty( $attributes[ 'data-image-hg-up' ] ) ) {

		$attributes['style'] = 'background-image: url(\'' . $attributes[ 'data-image-hg-up' ] . '\')';

	}

	return $attributes;

}

add_filter( 'sc_page_banner_attributes', 'sc_page_banner_attributes_filter' );

//------------------------------------------------------------------------------

function sc_page_banner_filter( $markup ) {

	return get_field( 'interior_banner_hidden' ) ? '' : $markup;

}

add_filter( 'sc_page_banner', 'sc_page_banner_filter' );

//------------------------------------------------------------------------------

function sc_page_banner_open_filter() {

	$attributes = apply_filters( 'sc_page_banner_attributes', $attributes );

	$parsed_attributes = [];

	foreach( $attributes as $attribute => $value ) {

		$parsed_attributes[] = $attribute . '="' . esc_attr( $value ) . '"';

	}

	$attributes_string = implode( ' ', $parsed_attributes );

	$markup = '
		<div id="page-banner" class="page-banner">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-lg-6">
						<div ' . $attributes_string . '></div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="page-banner__text">';

	return $markup;

}

add_filter( 'sc_page_banner_open', 'sc_page_banner_open_filter' );

//------------------------------------------------------------------------------

function sc_page_banner_close_filter() {

	$markup = '
						</div>
					</div>
				</div>
			</div>
		</div>';

	return $markup;

}

add_filter( 'sc_page_banner_close', 'sc_page_banner_close_filter' );

//------------------------------------------------------------------------------

function sc_page_banner_title_filter( $title ) {

	if( is_page() ) {

		$interior_banner_title = get_field( 'interior_banner_title' );

	}

	if( is_single() ) {

		$interior_banner_title = 'Blog';

		$post_type = get_post_type();

		$cpt_object = get_post_type_object( $post_type );

		$archive_name = $cpt_object->labels->name;
			
		if( $archive_name == 'Posts') {

			$interior_banner_title = 'Blog';

		}

	}

	if( ! empty( $interior_banner_title ) ) {

		return $interior_banner_title;

	}

	return $title;

}

add_filter( 'sc_page_banner_title', 'sc_page_banner_title_filter' );

//------------------------------------------------------------------------------

function sc_page_banner_sub_title_filter( $sub_title ) {
	
	if( is_page() ) {

		$interior_banner_sub_title = get_field( 'interior_banner_sub_title' );

	}
	
	if( is_single() ) {

		$post_id = get_the_ID();

		$interior_banner_sub_title = get_post_meta( $post_id, 'intertior_banner_sub_title',  true );

	}

	if( ! empty( $interior_banner_sub_title ) ) {
		
		return $interior_banner_sub_title;
		
	}
	
	return $sub_title;
	
}

add_filter( 'sc_page_banner_sub_title', 'sc_page_banner_sub_title_filter' );

//------------------------------------------------------------------------------

function sc_get_social_icons( $options = array() ) {
	
	$settings = [
		'sc_facebook_url'  => [ 'Facebook',  'facebook-f.svg'  ],
		'sc_twitter_url'   => [ 'Twitter',   'twitter.svg'     ],
		'sc_youtube_url'   => [ 'YouTube',   'youtube.svg'     ],
		'sc_instagram_url' => [ 'Instagram', 'instagram.svg'   ],
		'sc_linkedin_url'  => [ 'LinkedIn',  'linkedin-in.svg' ],
		'sc_pinterest_url' => [ 'Pinterest', 'pinterest-p.svg' ],
		'sc_yelp_url'      => [ 'Yelp',      'yelp.svg'        ],
	];
	
	$post_id = isset( $options['meta_post_id'] ) ? $options['meta_post_id'] : false;
	$icons   = [];

	foreach( $settings as $key => $setting ) {
		
		$url = false;

		if( $post_id ) {

			if( ! empty( get_post_meta( $post_id, $key, true ) ) ) {
				
				$url = get_post_meta( $post_id, $key, true );

			}

		} else {

			if( ! empty( get_theme_mod( $key ) ) ) {
				
				$url = get_theme_mod( $key );
				
			}

		}

		if( $url ) {

			$icons[] = sprintf(
				'<a class="sc-social-icon" href="%s" title="%s" target="_blank"><span aria-hidden="true">%s</a></a>',
				esc_url( $url ),
				esc_attr( $setting[0] ),
				file_get_contents( get_stylesheet_directory() . '/assets/images/' . $setting[1] )
			);

		}
		
	}

	if( empty( $icons ) ) {

		return '';

	}
	
	$class = isset( $options['class'] ) ? $options['class'] : '';
	
	return sprintf(
		'<div class="sc-social-icons %s">%s</div>',
		esc_attr( $class ),
		implode( '', $icons )
	);
	
}

//------------------------------------------------------------------------------

function sc_get_logo( $theme_mod = 'sc_header_logo' ) {
	
	$logo      = get_theme_mod( $theme_mod, false );
	$blog_name = get_bloginfo( 'name' );
	
	if( $logo ) {
		
		$attachment_id = attachment_url_to_postid( $logo );

		if( 'image/svg+xml' === get_post_mime_type( $attachment_id ) ) {

			$file = get_attached_file( $attachment_id );
	
			return file_get_contents( $file );

		} else {

			return sc_get_image( $logo, $blog_name );

		}

	} else {
		
		return '<span class="logo__text">' . esc_html( $blog_name ) . '</span>';
		
	}
	
}

//------------------------------------------------------------------------------

function sc_get_inline_svg( $path_or_name ) {

	$path = '';

	if( stripos( $path_or_name, '/' ) === 0 ) {

		// it looks like we have a full file path already so use it
		//
		$path = $path_or_name;

	} else {

		// build out the file path
		//
		$path = get_stylesheet_directory() . '/assets/images/' . $path_or_name;

	}

	if( ! empty( $path ) ) {

		$svg = @file_get_contents( $path );

		if( false !== $svg ) {

			return $svg;

		}

	}

	return '';

}

//------------------------------------------------------------------------------

function sc_get_modules_above_page_break($post_id = null) {

	$modules  = SC_Modules::singleton()->get_modules( $post_id, true );
	$filtered = [];

	foreach( $modules as $module ) {

		if( 'page_break' === $module['acf_fc_layout'] ) {

			return $filtered;

		}

		$filtered[] = $module;

	}

	return $filtered;

}

//------------------------------------------------------------------------------

function sc_get_modules_below_page_break( $post_id = null ) {

	$modules          = SC_Modules::singleton()->get_modules( $post_id, true );
	$below_page_break = false;
	$filtered         = [];

	foreach( $modules as $module ) {

		if( 'page_break' === $module['acf_fc_layout'] ) {

			$below_page_break = true;
			continue;

		}

		if( $below_page_break ) {
			
			$filtered[] = $module;

		}

	}

	return $filtered;

}

//------------------------------------------------------------------------------

function sc_get_link_bar( $links = [] ) {

	$formatted_links = [];

	foreach( $links as $link ) {

		$title  = isset( $link['link']['title'] )  ? trim( $link['link']['title'] )  : '';
		$url    = isset( $link['link']['url'] )    ? trim( $link['link']['url'] )    : '';
		$target = isset( $link['link']['target'] ) ? trim( $link['link']['target'] ) : '';

		if( ! empty( $title ) && ! empty( $url ) ) {

			$formatted_links[] = sprintf(
				'<li class="sc-link-bar__item">
					<a class="sc-link-bar__link" href="%s" target="%s">%s</a>
				</li>',
				$url,
				$target,
				$title
			);

		}

	}

	if( empty( $formatted_links ) ) {

		return '';

	}

	return sprintf(
		'<ul class="sc-link-bar">%s</ul>',
		implode( '', $formatted_links )
	);

}

//------------------------------------------------------------------------------

function sc_render_pagination() {

	global $wp_query;

	if( $wp_query->max_num_pages > 1 ) {

		echo '<div class="sc-pagination">';

			echo '	<div class="page-controls">';

				posts_nav_link( ' ', '< Previous', 'Next >' );

			echo '	</div>';

		echo '</div>';

	}
	
}

//------------------------------------------------------------------------------

function sc_enable_cc( $enable, $notification, $form ) {

	return true;

}

add_filter( 'gform_notification_enable_cc', 'sc_enable_cc', 10, 3 );

//------------------------------------------------------------------------------

function sc_render_page_banner( $title = null, $sub_title = null ) {

	ob_start();

	sc_render_page_banner_open();

	if( is_null( $title ) ) {

		$title = get_the_title();

	}

	$title     = apply_filters( 'sc_page_banner_title', $title );
	$sub_title = apply_filters( 'sc_page_banner_sub_title', $sub_title );

	$markup = sprintf('
		<header class="page-banner__header">
			<h1 class="page-banner__title">%s</h1>
		</header>',
		esc_html( $title )
	);

	if( ! empty( $sub_title ) ) {

		$markup = sprintf('
			<header class="page-banner__header">
				<h1 class="page-banner__title">%s</h1>
				<p class="page-banner__sub-title">%s</p>
			</header>',
			esc_html( $title ),
			esc_html( $sub_title )
		);

	}

	if ( is_single() ) {

		$markup = sprintf('
		<header class="page-banner__header">
			<span class="page-banner__title">%s</span>
		</header>',
		esc_html( $title )
		);

		if( ! empty( $sub_title ) ) {

			$markup = sprintf('
				<header class="page-banner__header">
					<span class="page-banner__title">%s</span>
					<p class="page-banner__sub-title">%s</p>
				</header>',
				esc_html( $title ),
				esc_html( $sub_title )
			);
	
		}

	}
 
	echo apply_filters( 'sc_page_banner_header', $markup );

	sc_render_page_banner_close();

	echo apply_filters( 'sc_page_banner', ob_get_clean() );
	
}

//------------------------------------------------------------------------------

add_shortcode( 'available_at', function( $atts, $content ) {
	
	$template = '
		<p class="sc-available-at">
			<svg xmlns="http://www.w3.org/2000/svg" width="14" height="18" viewBox="0 0 14 18">
				<path d="M7,0A6.87,6.87,0,0,0,0,6.75C0,10.48,5.83,18,7,18s7-7.52,7-11.25A6.87,6.87,0,0,0,7,0Z" />
				<ellipse cx="7" cy="6.75" rx="4.64" ry="4.48" style="fill: #fff"/>
			</svg>
			<strong>Available at:</strong> %s
		</p>';
	
	return sprintf( $template, $content );
	
});

//------------------------------------------------------------------------------

add_shortcode( 'breadcrumb', function( $atts, $content ) {

	if( ! function_exists( 'bcn_display' ) ) {

		return '';

	}

	return '<div class="sc-breadcrumb">' . bcn_display( true ) . '</div>';

});
