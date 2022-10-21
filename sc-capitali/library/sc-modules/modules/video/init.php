<?php

SC_Modules::register_module_type( 'Video', [

	'fluid' => false,
	'size'  => 12,
	'sizes' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]

]);

if( ! class_exists( 'SCM_Video' ) ) {

	class SCM_Video {

		private static $_media;
		private static $_content;

		public static function get_cover_image() {

			if( isset( self::$_media['cover_image']['url'] ) ) {

				return self::$_media['cover_image']['url'];

			}

			$url = SCM_Video::get_video_url();
			
			if( false === $url ) {

				return '';
				
			}

			//$youtube_id = SCM_Video::get_youtube_id( $url );
			$youtube_id = (new SCM_Video())->get_youtube_id( $url );

			if( false !== $youtube_id ) {

				return sprintf( '//img.youtube.com/vi/%s/maxresdefault.jpg', $youtube_id ); 

			}

			return '';

		}

		public function get_youtube_id( $url ) {

			$pattern = "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/";

			preg_match( $pattern, $url, $matches );

			if( is_null( $matches[1] ) ) {

				return false;

			}

			return $matches[1];

		}

		public static function get_video_player() {

			switch( self::$_media['source'] ) {

				case 'oembed':

					$iframe = self::$_media['oembed'];

					preg_match( '/src="(.+?)"/', $iframe, $matches );
		
					$source = $matches[1];
					$params = [
						'autoplay'       => 1,
						'modestbranding' => 1
					];
		
					$new_source = add_query_arg( $params, $source );
					$iframe     = str_replace( $source, $new_source, $iframe );
		
					$attributes = 'frameborder="0"';
					$iframe = str_replace( '></iframe>', ' ' . $attributes . '></iframe>', $iframe );
		
					return $iframe;

				case 'local':
				
					ob_start();

					echo do_shortcode( '[video src="' . self::$_media['upload_video']['url'] . '" autoplay="on"]' );
					
					return ob_get_clean();
				
				case 'external':

					ob_start();

					echo do_shortcode( '[video src="' . trim( self::$_media['ext_video'] ) . '" autoplay="on"]' );
					
					return ob_get_clean();

			}

		}

		public static function get_video_url() {

			$oembed = self::$_media['oembed'];

			preg_match( '/src="(.+?)"/', $oembed, $matches );

			if( is_null( $matches[1] ) ) {

				return false;

			}

			return $matches[1];

		}

		public static function set_data( $data ) {

			//self::$_data     = $data;
			self::$_media   = is_array( $data['media'] )   ? $data['media']   : [];
			self::$_content = is_array( $data['content'] ) ? $data['content'] : [];

		}

	} 

}
