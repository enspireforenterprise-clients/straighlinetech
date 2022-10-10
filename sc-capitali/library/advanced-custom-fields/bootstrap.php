<?php if (! defined('ABSPATH')) die('No direct access allowed');

//------------------------------------------------------------------------------

function sc_acf_google_map_api( $api ) {
	
	if( ! function_exists( 'SCMU' ) ) {

		return $api;

	}

	$google_api_key = SCMU()::settings()->get_google_api_key();

	if( ! empty( $google_api_key ) ) {

		$api['key'] = $google_api_key;

	}
	
	return $api;

}

add_filter( 'acf/fields/google_map/api', 'sc_acf_google_map_api' );

//------------------------------------------------------------------------------

function sc_acf_init() {

	if( ! function_exists( 'SCMU' ) ) {

		return;

	}

	$google_api_key = SCMU()::settings()->get_google_api_key();

	if( ! empty( $google_api_key ) ) {

		acf_update_setting( 'google_api_key', $google_api_key );

	}

}

add_action( 'acf/init', 'sc_acf_init' );

//------------------------------------------------------------------------------

add_filter( 'acf/settings/load_json',  function ( $paths ) {

	$load_point = get_stylesheet_directory() . '/library/advanced-custom-fields/json';

	$paths[] = $load_point;

	return $paths;

}, 99);

//------------------------------------------------------------------------------

add_action('acf/save_post', 'sc_modify_opengraph_img');

function sc_modify_opengraph_img( $post_id ) {

	$archive_media = get_field( 'archive_media', $post_id );

	if( $archive_media ) {

		$feat_img = $archive_media['image'];

		if( ! empty( $feat_img ) ) {

		$og_img = $feat_img['url'];

			update_post_meta( $post_id, 'sc_og_image', $og_img );

		}

	} 

}

//------------------------------------------------------------------------------

function sc_form_module_choices_filter($field) {
    
    $field['choices'] = array();

    if( class_exists( 'Ninja_Forms' ) ) {

		$field['choices']['Ninja Forms'] = 'Ninja Forms';

    }

    if( class_exists( 'RGFormsModel' ) ) {

		$field['choices']['Gravity Forms'] = 'Gravity Forms';

	}
	
	$field['choices']['JavaScript Embed'] = 'JavaScript Embed';

    return $field;

}
