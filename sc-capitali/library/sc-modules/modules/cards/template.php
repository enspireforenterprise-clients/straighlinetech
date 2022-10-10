<?php if( ! defined( 'ABSPATH' ) ) die( 'No direct access allowed' ); 

SC_Cards_Module::set_data( $module );

?>
<section class="<?php echo implode( ' ', SCM()->get_module_classes( $module ) ); ?>" id="<?php echo esc_attr( $module['module_id'] ); ?>">
	
	<div class="row">
		<div class="col-12">
			<div class="row" id="<?php echo ($module['select_column_size']); ?>">
			
					<?php echo SC_Cards_Module::get_cards_markup(); ?>
				
			</div>
		</div>
	</div>
</section>