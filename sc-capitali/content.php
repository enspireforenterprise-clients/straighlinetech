<?php if (! defined('ABSPATH')) die('No direct access allowed');
/* DO NOT MODIFY THIS FILE
 * -----------------------
 * If you need to make changes to this file create a copy of it in
 * your child theme and perform any updates there.
 */
?>

	<?php if( is_single() ): ?>
		<div class="post clearfix">
			<?php get_template_part( 'content', 'content' ); ?>
		</div>
	<?php else: ?>
		<div class="row post">
			<div class="col-12 col-md-5 col-lg-4">		
				<div class="post-featured-image">
				<?php

					$post_id = get_the_ID();

					$image_id = get_post_thumbnail_id( $post_id );
						
					if( ! empty( $image_id ) ) {

						$attachment = wp_get_attachment_image_src( $image_id, 'sc-news-4-col' );

					}

					if( empty( $image_id ) ) {

						$thumbnail = get_theme_mod( 'sc_default_post_img' ); 

						

						if( is_int( $thumbnail ) ) {

							$attachment = wp_get_attachment_image_src( $thumbnail, 'sc-news-4-col' );

						}

						$image_alt = '';

					}

					sc_image(
						$attachment[0], [
							'class' => 'sc-card__media__image',
							'alt'   => $image_alt
						]
					);

				?>
				</div>
			</div>
			<div class="col-12 col-md-7 col-lg-8">
				<div class="post-content">
					<div class="post-content__header">
						<?php

						$title 			= get_the_title();
						$title_override = get_post_meta($post_id, 'archive_content_title', true );
						$sub_title      = get_post_meta($post_id, 'archive_content_sub_title', true );

						if( ! empty( $title_override ) ) {
							$title = $title_override;
						}

						$options = [
							'element' => 'h2',
							'size'	  => 'large'
						];

						echo sc_get_heading(
							$title, 
							$options
						);

						?>
					</div>
					<div class="sc-card__body">
						<div class="sc-card__post-info">
							<p>Posted on <?php echo get_the_date(); ?></p>
						</div>
						<div class="sc-card__description">
							<?php get_template_part( 'content', 'excerpt' ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>