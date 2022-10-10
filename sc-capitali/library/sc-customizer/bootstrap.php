<?php if (! defined('ABSPATH')) die('No direct access allowed');

require_once( 'customizers/header.php' );
require_once( 'customizers/footer.php' );
require_once( 'customizers/social-media.php' );
require_once( 'customizers/theme-options.php' );
require_once( 'customizers/tracking-scripts.php' );

function sc_init_customizer( $wp_customize ) {

  SC_Customizer::enqueue_customizer( 'header' );
  SC_Customizer::enqueue_customizer( 'footer' );
  SC_Customizer::enqueue_customizer( 'theme-colors' );
  SC_Customizer::enqueue_customizer( 'theme-options' );
  SC_Customizer::enqueue_customizer( 'tracking-scripts' );
  SC_Customizer::enqueue_customizer( 'social-media' );
  SC_Customizer::enqueue_customizer( 'settings' );

  SC_Customizer::process_queue( $wp_customize );

  SC_Customizer::remove_defaults( 
    $wp_customize, 
    array(
      'themes',
      'colors',
      'header_image',
      'background_image',
      'static_front_page',
    )
  );

}

//------------------------------------------------------------------------------ 

function sc_init_customizer_replacements() {

	$theme_colors = [
		[ 'value' => '#011327', 'option' => 'sc_primary_color',       'name' => 'Primary Color'       ],
    [ 'value' => '#c6ddff', 'option' => 'sc_primary_color_light',     'name' => 'Primary Color Light'     ],
		[ 'value' => '#98c800', 'option' => 'sc_secondary_color',     'name' => 'Secondary Color'     ],
    [ 'value' => '#717276', 'option' => 'sc_secondary_color_light',     'name' => 'Secondary Color Light'     ],
    
	];

	SC_Customizer::stylesheet()->register_stylesheet( 'dist/css/style.css' );

	foreach( $theme_colors as $theme_color ) {

		SC_Customizer::stylesheet()->register_replacement(
			$theme_color['value'],
			null,
			$theme_color['option'],
			$theme_color['name']
		);

	}

}

add_action( 'sc_customizer_loaded', 'sc_init_customizer_replacements' );
