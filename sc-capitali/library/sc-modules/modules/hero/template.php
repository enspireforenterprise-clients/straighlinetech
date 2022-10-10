<?php if( ! defined( 'ABSPATH' ) ) die( 'No direct access allowed' );

SCM_Hero::set_data( $module );

?>
<div class="<?php echo implode( ' ', SCM()->get_module_classes( $module ) ); ?>" id="<?php echo esc_attr( $module['module_id'] ); ?>">
	<div class="scm-hero__slider">
		<?php foreach( SCM_Hero::get_slides() as $slide ): ?>
		<div class="scm-hero__slide" style="background-image:url(<?php echo esc_url( SCM_Hero::get_image( $slide ) ); ?>)" title="<?php echo SCM_Hero::get_slide_label( $slide ) ?>">
			<div class="scm-hero__content">
                <div class="scm-hero__content__inner">
                    <?php echo ( SCM_Hero::get_title( $slide ) ); ?>
				</div>
				<div class="scm-hero__content__cta">
					<?php //echo SCM_Hero::get_button( $slide ); 
					
					if(!empty(SCM_Hero::get_btn_text( $slide ))){
					?>

					<div class="scm-cts-container"><a href="<?php echo SCM_Hero::get_btn_url( $slide ); ?>" class="<?php echo SCM_Hero::get_color( $slide );?> "><?php echo SCM_Hero::get_btn_text( $slide );?></a></div>
				<?php } ?>
				
				</div>

				


			</div>
			<div class="scm-hero__image scm-hero-mobile" style="background-image:url(<?php echo esc_url( SCM_Hero::get_mobile_image( $slide ) ); ?>)"></div>
		</div>
		<?php endforeach; ?>
	</div>
</div> 