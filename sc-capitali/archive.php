<?php if (! defined('ABSPATH')) die('No direct access allowed');

get_header();

if( have_posts() ) {

	function sc_archive_posts() {

		$query = new WP_Query([
			'post_type'      => get_post_type(),
			'posts_per_page' => 5
		]);
	
		$posts = $query->posts;

		return $posts;

	}

	function sc_get_template_post_id() {

		$post_type  = get_post_type();
		$cpt_object = get_post_type_object( $post_type );

		if( isset( $cpt_object->labels->name ) ) {
			
			if( is_tax() || is_category() ) {
	
				$term_title = single_term_title( '', false );
	
				$template_query = new WP_Query([
					'post_type' => SC_Templates_CPT::POST_TYPE,
					'title'     => 'Archive - ' . $cpt_object->labels->name . ' - ' . $term_title
				]);

				if( isset( $template_query->posts[0] ) ) {

					return $template_query->posts[0]->ID;

				}
	
			}

			$template_query = new WP_Query([
				'post_type' => SC_Templates_CPT::POST_TYPE,
				'title'     => 'Archive - ' . $cpt_object->labels->name
			]);

			if( isset( $template_query->posts[0] ) ) {

				return $template_query->posts[0]->ID;
				
			}
	
		}

		return false;

	}

	add_filter( 'scm_articles_posts_filter', 'sc_archive_posts' );

	if( is_home() ) {

		$title = single_post_title( '', false );

	} else {

		$title = get_the_archive_title();
		$title = str_replace( [ 'Category: ', 'Archives: ', 'Month: ', '<span>', '</span>' ], '', $title );
		
	}

	$template_post_id = sc_get_template_post_id();

	if( false !== $template_post_id ) {

		if( ! empty( $title_override = get_field( 'interior_banner_title', $template_post_id ) ) ) {

			$title = $title_override;

		}

		if( ! empty( $sub_title_override = get_field( 'interior_banner_sub_title', $template_post_id ) ) ) {

			$sub_title = $sub_title_override;

		}

	}

	sc_render_page_banner( $title, $sub_title );

	?>
	<div id="page-content">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<?php

						if( false !== $template_post_id ) {

							SC_Modules::singleton()->container_open  = '<div class="row">';
							SC_Modules::singleton()->container_close = '</div>';
							SC_Modules::singleton()->get_modules( $template_post_id, true );
							SC_Modules::singleton()->display_modules();

						}
						
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-lg-8 ">
					<?php

						while ( have_posts() ) {

							the_post();

							get_template_part( 'content', get_post_type() );

						}

					?>
				<?php sc_render_pagination(); ?>
				</div>
				<div class="col-12 col-lg-3 offset-lg-1">
					<div id="default-sidebar" class="sc-sidebar">
						<?php

							$default_sidebar = apply_filters( 'sc_default_sidebar', 'blog-sidebar' );

							if( is_active_sidebar( $default_sidebar ) ) {

								dynamic_sidebar( $default_sidebar );

							}

						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php

} else {

	$title   = 'No Posts Found';
	$content = '<p>Sorry, no posts were found. Thank You.</p>';

	sc_render_page( $title, $content );

}

get_footer();
