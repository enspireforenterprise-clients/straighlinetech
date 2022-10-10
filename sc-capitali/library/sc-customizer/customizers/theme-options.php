<?php if (! defined('ABSPATH')) die('No direct access allowed');
/* DO NOT MODIFY THIS FILE OR THEME
 * --------------------------------------------------
 * If you need to make direct changes to this file or any file in this theme
 * you should make a full copy the entire theme, re-name it, activate it, and 
 * make your changes there. Failure to do this will result in changes being 
 * overwritten by an automatic update in the future.
 */
if( ! class_exists( 'SC_Customizer_Theme_Options' ) ) {
	
	class SC_Customizer_Theme_Options {

		public function register( $wp_customize, $priority ) {

			self::register_section( $wp_customize, $priority );

		}

		public function register_section( $wp_customize, $priority ) {

			$section = 'sc_theme_options';

			$wp_customize->add_section($section , array(
				'title'    => 'Theme Options',
				'priority' => $priority
			));

			SC_Customizer::register_cropped_image(
				$wp_customize,
				$section,
				'sc_default_interior_banner',
				'Default Interior Banner',
				array (
					'width'       => 1000,
					'height'      => 292,
					'flex_width'  => false,
					'flex_height' => false
				)
			);

			SC_Customizer::register_cropped_image(
				$wp_customize,
				$section,
				'sc_default_post_img',
				'Default Post Thumbnail',
				array (
					'width'       => 415,
					'height'      => 314,
					'flex_width'  => false,
					'flex_height' => false
				)
			);

		}

	}

}

