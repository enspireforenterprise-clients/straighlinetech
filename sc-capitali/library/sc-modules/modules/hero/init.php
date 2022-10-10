<?php

SC_Modules::register_module_type( 'Hero', [

	'fluid' => true,
	'size'  => 12,
	'sizes' => [12]

]);

if( ! class_exists( 'SCM_Hero' ) ) {

	class SCM_Hero {

		private static $_data;

		public static function get_slides() {

			return self::$_data['slides'];
			
		}

		public static function get_title( $_slide ) {

			$title = $_slide['content']['title'];

			return $title;

		}

		public static function get_btn_text( $_slide ) {

			$title = $_slide['content']['button_text'];

			return $title;

		}

		public static function get_btn_url( $_slide ) {

			$title = $_slide['content']['button_url'];

			return $title;

		}

		public static function get_color( $_slide ) {

			$title = $_slide['content']['select_button_color'];

			return $title;

		}




		public static function get_button( $_slide ) {

			$cts_color = $title;

			if( $_slide['content']['learn_more_link'] ) {

				$template = '
				<a class="button--secondary" target=":target" href="#url">@text</a>';

				return sc_format_string( $template, [
					':target'  => $_slide['content']['learn_more_link']['target'],
					'#url'     => $_slide['content']['learn_more_link']['url'],
					'@text'    => $_slide['content']['learn_more_link']['title']
				]);

			}

			return '';

		}

		public static function get_slide_label( $_slide ) {

			return $_slide['content']['slide_label_text'];

		}

		public static function get_image( $_slide ) {

			return $_slide['media']['image']['url'];

		}
		public static function get_mobile_image( $_slide ) {

			return $_slide['media']['mobileimage']['url'];

		}

		public static function set_data( $data ) {

			self::$_data = $data;

		}

	} 

}
