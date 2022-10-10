<?php if( ! defined( 'ABSPATH' ) ) die( 'No direct access allowed' );

if( ! class_exists( 'SC_Team_Member_CPT' ) ) {

  class SC_Team_Member_CPT {

    // CONST POST_TYPE      = 'sc-team-member';
    // CONST GROUP_TAXONOMY = 'sc-team-member-group';

    // function __construct() {
      
    //   add_action( 'init', array( $this, 'register_post_type' ) );
    //   add_action( 'init', array( $this, 'register_group_taxonomy' ) );

    // }

    // public function register_post_type() {

    //   $singular = 'Team Member';
    //   $plural   = 'Team Members';

    //   $args = array(
    //     'hierarchical'        => false,
    //     'description'         => 'Custom post type for team members.',
    //     'supports'            => [],
    //     'public'              => false,
    //     'show_ui'             => true,
    //     'show_in_menu'        => true,
    //     'show_in_nav_menus'   => true,
    //     'publicly_queryable'  => false,
    //     'exclude_from_search' => true,
    //     'has_archive'         => false,
    //     'query_var'           => false,
    //     'can_export'          => true,
    //     'rewrite' 			      => false,
    //     'menu_position'       => 21,
    //     'menu_icon'           => 'dashicons-groups',
    //     'labels'              => array(
    //       'name'               => $plural,
    //       'singular_name'      => $singular,
    //       'add_new'            => 'Add New',
    //       'add_new_item'       => 'Add'     . ' ' .  $singular,
    //       'edit_item'          => 'Edit'    . ' ' .  $singular,
    //       'new_item'           => 'New'     . ' ' .  $singular,
    //       'all_items'          => 'All'     . ' ' .  $plural,
    //       'view_item'          => 'View'    . ' ' .  $singular,
    //       'search_items'       => 'Search'  . ' ' .  $plural,
    //       'not_found'          => sprintf('No %s found',          $plural),
    //       'not_found_in_trash' => sprintf('No %s found in trash', $plural),
    //       'parent_item_colon'  => '',
    //       'menu_name'          => $plural
    //     )
    //   );

    //   register_post_type( self::POST_TYPE, $args );
      
    // }

    // public function register_group_taxonomy() {

		// 	$singular = 'Group';
		// 	$plural   = 'Groups';
			
    //   $labels = array(
    //     'name'              => $plural,
    //     'singular_name'     => $singular,
    //     'search_items'      => 'Search '  . $plural,
    //     'all_items'         => 'All '     . $plural,
    //     'parent_item'       => 'Parent '  . $singular,
    //     'parent_item_colon' => 'Parent '  . $singular . ':',
    //     'edit_item'         => 'Edit '    . $singular,
    //     'update_item'       => 'Update '  . $singular,
    //     'add_new_item'      => 'Add New ' . $singular,
    //     'new_item_name'     => 'New '     . $singular . ' Name',
    //     'menu_name'         => $plural
    //   );

    //   register_taxonomy(
    //     self::GROUP_TAXONOMY,
    //     self::POST_TYPE,
    //     array(
    //       'labels'        => $labels,
    //       'rewrite'       => array('slug' => 'team-group'),
    //       'show_tagcloud' => false,
    //       'hierarchical'  => false,
    //     )
    //   );

    // }

  }

}
