<?php if (! defined('ABSPATH')) die('No direct access allowed');

if( ! class_exists( 'SC_Templates_CPT' ) ) {

  class SC_Templates_CPT {

    CONST POST_TYPE = 'sc-template';

    function __construct() {
      
      add_action( 'init', array( $this, 'register_post_type' ) );

    }

    public function register_post_type() {

      $singular = 'Template';
      $plural   = 'Templates';

      $args = array(
        'hierarchical'        => false,
        'description'         => 'Custom post type for templates.',
        'supports'            => array( 'title' ),
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'publicly_queryable'  => false,
        'exclude_from_search' => true,
        'has_archive'         => false,
        'query_var'           => false,
        'can_export'          => true,
        'rewrite' 			      => false,
        'capability_type'     => 'post',
        'menu_position'       => 25,
        'menu_icon'           => 'dashicons-media-code',
        'labels'              => array(
          'name'               => $plural,
          'singular_name'      => $singular,
          'add_new'            => 'Add New',
          'add_new_item'       => 'Add'     . ' ' .  $singular,
          'edit_item'          => 'Edit'    . ' ' .  $singular,
          'new_item'           => 'New'     . ' ' .  $singular,
          'all_items'          => 'All'     . ' ' .  $plural,
          'view_item'          => 'View'    . ' ' .  $singular,
          'search_items'       => 'Search'  . ' ' .  $plural,
          'not_found'          => sprintf('No %s found',          $plural),
          'not_found_in_trash' => sprintf('No %s found in trash', $plural),
          'parent_item_colon'  => '',
          'menu_name'          => $plural
        )
      );

      register_post_type( self::POST_TYPE, $args );
      
    }

  }

}
