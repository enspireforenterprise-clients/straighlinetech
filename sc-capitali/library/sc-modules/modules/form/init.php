<?php

SC_Modules::register_module_type( 'Form', [

	'fluid' => false,
	'size'  => 12,
	'sizes' => [3, 4, 5, 6, 7, 8, 9, 10, 11, 12]

]);

// -----------------------------------------------------------------------------

function sc_dequeue_gform_stylesheets() {

	wp_dequeue_style( 'gforms_reset_css' );
	wp_dequeue_style( 'gforms_datepicker_css' );
	wp_dequeue_style( 'gforms_formsmain_css' );
	wp_dequeue_style( 'gforms_ready_class_css' );
	wp_dequeue_style( 'gforms_browsers_css' );

}

add_action( 'gform_enqueue_scripts', 'sc_dequeue_gform_stylesheets', 11 );
