<?php 

if (! defined('ABSPATH')) die('No direct access allowed');

if( ! class_exists( 'SC_Customizer_Social_Media' ) ) {
  
  class SC_Customizer_Social_Media {

    public function register( $wp_customize, $priority ) {

      self::register_section( $wp_customize, $priority );

    }

    public function register_section( $wp_customize, $priority ) {

      $section = 'sc_social_media_section';

      $wp_customize->add_section( $section , array(
        'title'    => 'Social Media',
        'priority' => $priority
      ));

      SC_Customizer::register_text( $wp_customize, $section, 'sc_facebook_url',   'Facebook URL'  );
      SC_Customizer::register_text( $wp_customize, $section, 'sc_twitter_url',    'Twitter URL'   );
      SC_Customizer::register_text( $wp_customize, $section, 'sc_youtube_url',    'YouTube URL'   );
      SC_Customizer::register_text( $wp_customize, $section, 'sc_instagram_url',  'Instagram URL' );
      SC_Customizer::register_text( $wp_customize, $section, 'sc_linkedin_url',   'LinkedIn URL'  );
      SC_Customizer::register_text( $wp_customize, $section, 'sc_pinterest_url',  'Pinterest URL' );
      SC_Customizer::register_text( $wp_customize, $section, 'sc_yelp_url',       'Yelp URL'      );

    }

  }

}

