<?php if (! defined('ABSPATH')) die('No direct access allowed');

if( ! class_exists( 'SC_Customizer_Tracking_Scripts' ) ) {
  
  class SC_Customizer_Tracking_Scripts {

    public function register( $wp_customize, $priority ) {

      self::register_section( $wp_customize, $priority );

    }

    public function register_section( $wp_customize, $priority ) {

      $section = 'sc_tracking_scripts_section';

      $wp_customize->add_section( $section , array(
        'title'    => 'Tracking Scripts',
        'priority' => $priority
			));

			SC_Customizer::register_textarea( 
        $wp_customize,
        $section,
        'sc_header_tracking_scripts',
        'Header Scripts',
				[
          'setting_options' => [
            'sanitize_callback' => null
					]
				]
			);

			SC_Customizer::register_textarea( 
        $wp_customize,
        $section,
        'sc_after_body_open_tracking_scripts',
        'After Body Open Scripts',
				[
          'setting_options' => [
            'sanitize_callback' => null
					]
				]
			);

      SC_Customizer::register_textarea( 
        $wp_customize,
        $section,
        'sc_footer_tracking_scripts',
				'Footer Scripts',
				[
          'setting_options' => [
            'sanitize_callback' => null
					]
				]
			);
			
    }

  }

}

