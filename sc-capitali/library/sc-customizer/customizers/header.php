<?php if (! defined('ABSPATH')) die('No direct access allowed');

if( ! class_exists( 'SC_Customizer_Header' ) ) {
  
  class SC_Customizer_Header {

    public function register( $wp_customize, $priority ) {

      self::register_section( $wp_customize, $priority );

    }

    public function register_section( $wp_customize, $priority ) {

      $section = 'sc_header_section';

      $wp_customize->add_section( $section , array(
        'title'    => 'Header',
        'priority' => $priority
			));
			
			SC_Customizer::register_image( 
        $wp_customize,
        $section,
        'sc_header_logo',
        'Header Logo'
      );

      SC_Customizer::register_text( 
        $wp_customize,
        $section,
        'sc_portal_text',
        'Button Text'
      );

      SC_Customizer::register_text( 
        $wp_customize,
        $section,
        'sc_portal_url',
        'Button URL'
      );

      // SC_Customizer::register_text( 
      //   $wp_customize,
      //   $section,
      //   'sc_cta_1_text',
      //   'CTA 1 Text'
      // );

      // SC_Customizer::register_text( 
      //   $wp_customize,
      //   $section,
      //   'sc_cta_1_url',
      //   'CTA 1 URL'
      // );

      // SC_Customizer::register_text( 
      //   $wp_customize,
      //   $section,
      //   'sc_cta_2_text',
      //   'CTA 2 Text'
      // );

      // SC_Customizer::register_text( 
      //   $wp_customize,
      //   $section,
      //   'sc_cta_2_url',
      //   'CTA 2 URL'
      // );

      // SC_Customizer::register_text( 
      //   $wp_customize,
      //   $section,
      //   'sc_notification_title',
      //   'Notificiation Bar Title'
      // );

      // SC_Customizer::register_text( 
      //   $wp_customize,
      //   $section,
      //   'sc_notification_text',
      //   'Notificiation Bar Text'
      // );

      // SC_Customizer::register_text( 
      //   $wp_customize,
      //   $section,
      //   'sc_notification_url',
      //   'Notification Bar URL'
      // );

    }

  }

}

