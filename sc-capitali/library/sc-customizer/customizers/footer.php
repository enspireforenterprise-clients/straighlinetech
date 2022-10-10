<?php if (! defined('ABSPATH')) die('No direct access allowed');

if( ! class_exists( 'SC_Customizer_Footer' ) ) {
  
  class SC_Customizer_Footer {

    public function register( $wp_customize, $priority ) {

      self::register_section( $wp_customize, $priority );

    }

    public function register_section( $wp_customize, $priority ) {

      $section = 'sc_footer_section';

      $wp_customize->add_section( $section , array(
        'title'    => 'Footer',
        'priority' => $priority
      ));

      SC_Customizer::register_image(
				$wp_customize,
				$section,
				'sc_footer_logo',
				'Footer Logo'
			);

      SC_Customizer::register_text( 
        $wp_customize,
        $section,
        'sc_copyright',
        'Copyright'
      );

      SC_Customizer::register_textarea( 
        $wp_customize,
        $section,
        'sc_disclaimer',
        'Disclaimer'
      );



    }

  }

}
