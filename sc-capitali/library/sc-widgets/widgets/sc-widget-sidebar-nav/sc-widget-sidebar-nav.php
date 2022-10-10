<?php if( ! defined( 'ABSPATH' ) ) die( 'No direct access allowed' );

require_once( 'sc-widget-sidebar-nav-menu-based.php' );

if ( ! class_exists( 'SC_Widget_Sidebar_Nav' ) ) {

	class SC_Widget_Sidebar_Nav extends WP_Widget {
	
		/**
		 * Sets up the widgets name etc
		 */
		function __construct() {

			parent::__construct(
				'sc-widget-sidebar-nav',
				'Sidebar Nav',
				array('description' => 'Context sensitive sidebar navigation.')
			);

		}
	
		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
	
			if( ! is_page() ) {
	
				return false;
	
			}
	
			echo str_replace( '_', '-', $args['before_widget'] );

			$builder = new SC_Widget_Sidebar_Nav_Menu_Based;

			$builder->render();
	
			echo $args['after_widget'];
	
		}
	
		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {
	
			echo '<br /><br />';
	
		}
	
		/**
		 * Processing widget options on save
		 *
		 * @param array $new_instance The new options
		 * @param array $old_instance The previous options
		 */
		public function update( $new_instance, $old_instance ) {
	
			return $new_instance;
			
		}
	
	}

}
