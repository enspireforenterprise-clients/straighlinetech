<?php

SC_Modules::register_module_type( 'Recent Posts', [

	'fluid' => false,
	'size'  => 12,
	'sizes' => [12]

]);

add_action( 'init', function() {

	add_image_size( 'sc-news-4-col', 415, 314, true );

});

if( ! class_exists( 'SCM_Recent_Posts' ) ) {

	class SCM_Recent_Posts {

		private static $_data;

		public static function get_posts() {

			$posts = [];

			if( 'curated' === self::$_data['feed']['feed_type'] ) {

				$posts = self::$_data['feed']['posts'];

			} else {

				$query = new WP_Query([
					'post_type'      => [ 'post' ],
					'posts_per_page' => self::$_data['feed']['number_of_posts'],
				]);

				$posts = $query->posts;

			}

			return apply_filters( 'scm_recent_posts_filter', $posts );

		}

		public static function get_post_title( $post_id ) {

			$interior_banner_title = get_post_meta( $post_id, 'interior_banner_title',  true );

			if( $interior_banner_title ) {
		
				return $interior_banner_title;
		
			}
		
			return get_the_title( $post_id );

		}

		public static function get_post_image( $post_id ) {

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
			
			return sc_get_image(
				$attachment[0], [
					'class' => 'sc-card__media__image',
					'alt'   => $image_alt
				]
			);

		}

		public static function get_post_excerpt( $post_id ) {

			$excerpt = get_the_excerpt( $post_id );

			if( ! empty( trim( $excerpt ) ) ) {

				return trim( $excerpt ) . '&nbsp;...';

			}

			$search  = new SC_Search( $post_id );
			$excerpt = $search->get_plain_text_content();

			if( ! empty( trim( $excerpt ) ) ) {

				return sc_trim_words( $excerpt, 140, '&nbsp;...' );

			}

			return '';

		}

		public static function set_data( $data ) {

			self::$_data = $data;

		}

	} 

}
