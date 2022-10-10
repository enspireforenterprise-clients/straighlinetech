<?php if( ! defined( 'ABSPATH' ) ) die( 'No direct access allowed' );

if( ! class_exists( 'SC_Widget_Sidebar_Nav_Menu_Based' ) ) {

	class SC_Widget_Sidebar_Nav_Menu_Based extends WP_Widget {

		public $flattened_menu;
		public $current_page_id;
		public $current_menu_item;
		public $menu_items_to_expand;

		function __construct() {

			$this->flattened_menu       = $this->get_flattened_menu();
			$this->current_page_id      = get_queried_object_id();
			$this->current_menu_item    = $this->get_current_menu_item();
			$this->menu_items_to_expand = $this->get_menu_items_to_expand();

		}

		public function render() {

			echo $this->get_title_markup();
			echo '<ul class="menu">' . $this->get_nav_markup() . '</ul>';

		}

		public function get_title_markup() {
	
			$menu_item = $this->get_menu_item( $this->menu_items_to_expand[0] );

			return sprintf(
				'<h4 class="sc-widget-title">%s</h4>',
				esc_html( $menu_item->title )
			);
	
		}

		public function get_nav_markup( $depth = 0 ) {

			$menu_item   = $this->get_menu_item( $this->menu_items_to_expand[$depth] );
			$menu_items  = $this->get_child_menu_items( $menu_item->ID );
			$markup = '';
	
			$depth++;
	
			foreach ( $menu_items as $menu_item ) {
	
				$sub_nav_markup = '';
				$classes = array( 'menu-item' );
	
				if ( $menu_item->ID == $this->menu_items_to_expand[$depth] ) {
	
					$sub_nav_markup = $this->get_nav_markup( $depth );
				
				}
	
				if ( count( $this->get_child_menu_items( $menu_item->ID ) ) ) {
	
					$classes[] = 'has-children';
				
				}
	
				if ( $sub_nav_markup != '' ) {
	
					$classes[] = 'expanded-menu-item';
	
				}
	
				if ( $menu_item->ID == $this->current_menu_item->ID ) {
	
					$classes[] = 'current-menu-item';
	
				}
	
				$markup .= sprintf('
					<li class="%s" data-level="%d">
						<a href="%s" target="%s"><span>%s</span></a>
						<ul class="sub-menu">%s</ul>
					</li>',
					esc_attr( implode( ' ', $classes) ),
					esc_attr( $depth + 1 ),
					esc_url( $menu_item->url ),
					esc_html( $menu_item->target ),
					esc_html( $menu_item->title ),
					$sub_nav_markup
				);
	
			}
	
			return $markup;

		}

		public function get_current_menu_item() {

			foreach( $this->flattened_menu as $menu_item ) {

				if( 'page' !== $menu_item->object ) {

					continue;

				}

				if( (int) $menu_item->object_id === (int) $this->current_page_id ) {

					return $menu_item;

				}

			}

			return false;

		}

		public function get_menu_item( $menu_item_id ) {

			foreach( $this->flattened_menu as $menu_item ) {

				if( (int) $menu_item->ID === (int) $menu_item_id ) {

					return $menu_item;

				}

			}

			return false;

		}

		public function get_child_menu_items( $menu_item_id ) {
	
			$menu_items = [];

			foreach( $this->flattened_menu as $menu_item ) {

				if( (int) $menu_item_id === (int) $menu_item->menu_item_parent ) {

					$menu_items[] = $menu_item;

				}

			}

			return $menu_items;
	
		}

		public function get_flattened_menu() {

			// get a flattened array of all menu items
			//
			$json = wp_nav_menu(
				array(
					'theme_location' => 'header_menu_main',
					'container'      => false,
					'depth'          => 3,
					'items_wrap'     => '%3$s',
					'echo'           => false,
					'walker'         => new Walker_Flattened_Mega_Menu_Json
				)
			);

			$this->flattened_menu = json_decode( '[' . trim( $json, ',' ) . ']' );

			return $this->flattened_menu;

		}

		public function get_menu_items_to_expand() {
			
			$menu_item            = $this->current_menu_item;
			$menu_items_to_expand = [$menu_item->ID];

			while( false !== $menu_item ) {

				$menu_item = $this->get_parent_menu_item( $menu_item );

				if( false !== $menu_item ) {

					$menu_items_to_expand[] = $menu_item->ID;
				
				}
				
			}

			return array_reverse( $menu_items_to_expand );
	
		}

		public function get_parent_menu_item( $menu_item ) {

			if( 0 === $menu_item->menu_item_parent ) {
				
				return false;

			}

			foreach( $this->flattened_menu as $maybe_parent_menu_item ) {

				if( (int) $menu_item->menu_item_parent === (int) $maybe_parent_menu_item->ID ) {

					return $maybe_parent_menu_item;

				}

			}

			return false;

		}

	}

}

//------------------------------------------------------------------------------

if ( ! class_exists( 'Walker_Flattened_Mega_Menu_Json' ) ) {

	class Walker_Flattened_Mega_Menu_Json extends Walker {
		
		public $db_fields = array(
			'parent' => 'menu_item_parent',
			'id'     => 'db_id'
		);
	
		function start_lvl( &$output, $depth = 0, $args = array() ) {
	
			//
	
		}
	
		function end_lvl( &$output, $depth = 0, $args = array() ) {
	
			//
	
		}
	
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	
			$item->depth = $depth;
	
			$output .= json_encode( $item ) . ',';
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	
		}
	
		function end_el( &$output, $item, $depth = 0, $args = array() ) {
	
			//
	
		}
	
	}

}
