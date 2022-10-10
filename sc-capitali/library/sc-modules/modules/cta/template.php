<?php if (! defined('ABSPATH')) die('No direct access allowed');

$ctsblocks = [];

if( is_array( $module['ctas'] ) ) {

	foreach($module['ctas'] as $cta) {

		$original_image = isset( $cta['image']['url'] ) ? $cta['image']['url'] : false;
		$desktop_image  = false;

		if( isset( $cta['image']['sizes']['scm-testimonial'] ) ) {

			$desktop_image = $cta['image']['sizes']['scm-testimonial'];

		}

		$cts_markup = '';

		if( ! empty($desktop_image) ) {

			$cts_markup = sprintf('
				<div class="cta-block-image">
                    <img src="%s" alt="" />
				</div>',
				$desktop_image
			);

		} 

		if($cts_markup == '')
		{
			$cts_markup = '<div class="cta-block-image"> <img src="/wp-content/themes/sc-capitali/library/sc-modules/modules/cta/cat-default-image.jpg" alt="Default Image"></div>';
		}

		$ctsblocks[] = sprintf(
			'<div class="cts-content-block %s">
				%s
                <div class="scm-cta-content ">
				<div class="scm-inner-wraper-content">
                	%s
				</div>
                </div>
			</div>',
			$cta['select_background_color'],
			$cts_markup,
			$cta['content'],
			$rating_markup
		);
		
	}

}

?>
<section class="<?php echo implode( ' ', SCM()->get_module_classes( $module ) ); ?>" id="<?php echo esc_attr( $module['module_id'] ); ?>" data-align="<?php echo $module['image_alignment']; ?>">
	<div class="container-fluid scm-pad-md-zero">
		<div class="row">
			<div class="col-12">
				<div class="sc-ctas-rows">
				<?php echo implode( '', $ctsblocks ); ?>
				</div>
			</div>
		</div>
	</div>
</section>