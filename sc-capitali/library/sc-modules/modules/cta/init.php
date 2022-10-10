<?php

SC_Modules::register_module_type( 'CTA', [

	'fluid' => true,
	'size'  => 12,
	'sizes' => [12]

]);

add_action( 'init', function() {

	add_image_size( 'scm-testimonial', 520, 545, true );

});