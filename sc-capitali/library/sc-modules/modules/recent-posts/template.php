<?php if (! defined('ABSPATH')) die('No direct access allowed'); 

SCM_Recent_Posts::set_data( $module );

?>
<section class="<?php echo implode( ' ', SCM()->get_module_classes( $module ) ); ?>" id="<?php echo esc_attr( $module['module_id'] ); ?>">
  <div class="row">
    <div class="col-12">
		<div class="scm-recent-posts__module-title">

			<h2><?php echo esc_html( $module['main_overline'] ); ?></h2>
			<p><?php echo esc_html( $module['main_title'] ); ?></p> 
			
		</div>
		<?php
		
			echo '<div class="row">';
			
			$posts = SCM_Recent_Posts::get_posts();

			foreach( $posts as $post ) {

				$template = '
					<div class="col-md-4 col-sm-12">
						<div class="sc-recent-post">
							<div class="sc-recent-post__media">!image</div>
							<h3 class="sc-recent-post__title" data-mh="sc-recent-post__title">
								<a href="#permalink">@title</a>
							</h3>
							<p class="sc-recent-post__excerpt" data-mh="sc-recent-post__excerpt">@excerpt</p>
							<a class="button" href="#permalink">Read More</a>
						</div>
					</div>
				';

				echo sc_format_string( $template, [
					'@title'          => SCM_Recent_Posts::get_post_title( $post->ID ),
					'@excerpt'        => SCM_Recent_Posts::get_post_excerpt( $post->ID ),
					'!image'          => SCM_Recent_Posts::get_post_image( $post->ID ),
					'#permalink'      => get_permalink( $post->ID ),
					//':column_classes' => [ 'col-12 col-lg-4' ]
				]);
				 
			}

			echo '</div>';

		?>
    </div>
  </div>
</section>