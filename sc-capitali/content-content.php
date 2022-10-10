<?php $post_id = get_the_ID(); ?>
<div class="post-content">
	<header class="post__heading">
		<?php 

			$heading_options = [
				'element' => 'h1',
				'size'    => 'large'
			];

			$title 			    = get_the_title();
			$title_override = get_post_meta( $post_id, 'archive_content_title', true );

			if( ! is_single() ) {

				if( ! empty( $title_override ) ) {
					$title = $title_override;
				}

			}

			echo sc_get_heading(
				$title,
				$heading_options
			);
			
		?>
	</header>
	<div class="post-date">
		<span>Posted on <?php echo get_the_date(); ?></span> 
		<?php 

			$meta 	= get_field( 'archive_content', $post_id );
			$author = empty( $meta['author'] ) ? '' : $meta['author'];
			
			if( ! empty(  $author ) ): ?>
			<span class="post-author">
				by <?php echo esc_html( $author ); ?>
			</span>

		<?php endif; ?>
	</div>
	<?php if( true !== get_field( 'archive_media_suppress_post_page_image', $post_id ) ): ?>
		<div class="post-content_image">
			<?php

				$image_id  = get_post_meta( $post_id, 'archive_media_image', true );
				$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

				if( ! empty( $image_id ) ) {

					$attachment = wp_get_attachment_image_src( $image_id, 'archive-item-detail' );

					sc_image(
						$attachment[0], [
							'class' => 'post-media__image',
							'alt'   => $image_alt
						]
					);

				}

			?>
		</div>


		<div class="single_job_listing">
			<?php if ( get_option( 'job_manager_hide_expired_content', 1 ) && 'expired' === $post->post_status ) : ?>
				<div class="job-manager-info"><?php _e( 'This listing has expired.', 'wp-job-manager' ); ?></div>
			<?php else : ?>
				<?php
					/**
					 * single_job_listing_start hook
					 *
					 * @hooked job_listing_meta_display - 20
					 * @hooked job_listing_company_display - 30
					 */
					do_action( 'single_job_listing_start' );
				?>

				<div class="job_description">
					<?php wpjm_the_job_description(); ?>
				</div>

				<?php if ( candidates_can_apply() ) : ?>
					<?php get_job_manager_template( 'job-application.php' ); ?>
				<?php endif; ?>

				<?php
					/**
					 * single_job_listing_end hook
					 */
					do_action( 'single_job_listing_end' );
				?>
			<?php endif; ?>
		</div>

	<?php endif; ?>
	<?php 
	
	$modules = false;

	if( class_exists('SC_Modules') ) {

		if( is_array( SC_Modules::singleton()->get_modules() ) ) {

			$modules = true;

		}

	}

	if( $modules ) {

		SC_Modules::singleton()->container_open  = '<div class="row">';
		SC_Modules::singleton()->container_close = '</div>';
		
		SC_Modules::singleton()->display_modules();

	} else {

		the_content();
	
	}
	
	?>
</div>