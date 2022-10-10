<?php

SC_Modules::register_module_type( 'Image', [

	'fluid' => false,
	'size'  => 12,
	'sizes' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]

]);

if( ! class_exists( 'SC_Image_Module' ) ) {

	class SC_Image_Module {

		private static $_data;
		private static $_image;
		private static $_settings;

		public static function get_image() {

			if( ! isset( self::$_image['url'] ) ) {

				return false;

			}

			return self::$_image['url'];

		}
		
		public function get_width() {

			if( ! isset( self::$_image['width'] ) ) {

				return false;

			}

			return self::$_image['width'];

		}

		public function get_height() {

			if( ! isset( self::$_image['height'] ) ) {

				return false;

			}

			return self::$_image['height'];

		}

		public function get_aspect_ratio() {

			$width	= (int) SC_Image_Module::get_width();
			$height = (int) SC_Image_Module::get_height();

			return $height / $width * 100;

		}

		public static function get_alt() {

			if( ! isset( self::$_image['alt'] ) ) {

				return '';

			}

			return trim( self::$_image['alt'] );

		}

		public static function get_caption() {

			if( ! self::show_caption() ) {

				return false;

			}

			if( ! isset( self::$_image['caption'] ) ) {

				return false;

			}

			$caption = trim( self::$_image['caption'] );

			if( empty( $caption ) ) {

				return false;

			}

			return $caption;

		}
		
		public static function get_url() {

			if( ! isset( self::$_data['options']['url'] ) ) {

				return false;

			}

			return trim( self::$_data['options']['url'] );
			
		}

		public static function get_url_target() {

			if( array_key_exists( 'open_url_new_window', self::$_settings ) ) {

				return '_blank';

			}

			return '_self';

		}

		public static function get_classes() {

			$classes = array( 'scm-image__container__image' );

			if( self::show_border() ) {

				$classes[] = 'scm-image__container__image--bordered';

			}
			
			if( self::lazy_load_enabled() ) {

				$classes[] = 'scm-image__container__image--lazy-load';

			}

			return implode( ' ', $classes );

		}

		public static function show_caption() {

			return ! array_key_exists( 'hide_image_caption', self::$_settings );

		}

		public static function show_border() {

			return array_key_exists( 'show_image_border', self::$_settings );

		}

		public static function lazy_load_enabled() {

			return ! array_key_exists( 'disable_lazy_loading', self::$_settings );

		}

		public static function set_data( $data ) {

			self::$_data     = $data;
			self::$_image    = isset( $data['content']['image'] ) ? $data['content']['image'] : false;
			self::$_settings = is_array( $data['options']['settings'] ) ? array_count_values( $data['options']['settings'] ) : [];

		}

	} 

}
