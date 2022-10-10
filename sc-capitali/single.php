<?php if (! defined('ABSPATH')) die('No direct access allowed');

get_header();

if ( have_posts() ) {

	while ( have_posts() ) {

		the_post();
		
		sc_render_page_banner();

		//

		ob_start();
		
		get_template_part( 'content', get_post_type() );

		$content = ob_get_clean();
		
		//

		ob_start();

		$default_sidebar = apply_filters( 'sc_default_sidebar', 'blog-sidebar' );

		if( is_active_sidebar( $default_sidebar ) ) {
	
			dynamic_sidebar( $default_sidebar );
	
		}

		$sidebar = ob_get_clean();
	
		//

		echo '
			<div id="page-content">
				<div class="container">
					<div class="row">
						<div class="col-12 col-md-9">' . $content . '</div>
						<div class="col-12 col-md-3">
							<div id="default-sidebar" class="sc-sidebar">' . $sidebar . '</div>
						</div>
					</div>
				</div>
			</div>
		';
		
	}

} else {

	$title   = 'No Post Found';
	$content = '<p>Sorry, no post was found. Thank You.</p>';

	sc_render_page( $title, $content );

}

get_footer();