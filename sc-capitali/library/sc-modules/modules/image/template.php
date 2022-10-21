<?php if (! defined('ABSPATH')) die('No direct access allowed'); 

SC_Image_Module::set_data( $module );

?>
<section class="<?php echo implode( ' ', SCM()->get_module_classes( $module ) ); ?>" id="<?php echo esc_attr( $module['module_id'] ); ?>">
	<?php

		if( false !== SC_Image_Module::get_image() ) {

			if( SC_Image_Module::lazy_load_enabled() ) {

				$image = sc_get_image( 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=', array(
					'data-src' => esc_url( SC_Image_Module::get_image() ),
					'width'    => (int) (new SC_Image_Module())->get_width(),
					'height'   => (int) (new SC_Image_Module())->get_height(),
					'class'    => esc_attr( SC_Image_Module::get_classes() ),
					'alt'      => esc_attr( SC_Image_Module::get_alt() )
				));

			} else {

				$image = sc_get_image( esc_url( SC_Image_Module::get_image() ), array(
					'class' => esc_attr( SC_Image_Module::get_classes() ),
					'alt'   => esc_attr( SC_Image_Module::get_alt() )
				));

			}

			if( SC_Image_Module::get_url() ) {

				printf(
					'<div class="scm-image__container" style="padding-bottom:%d%%">
						<a href="%s" target="%s"m class="scm-image__container__link">%s</a>
					</div>',
					(float) (new SC_Image_Module())->get_aspect_ratio(),
					esc_url( SC_Image_Module::get_url() ),
					esc_attr( SC_Image_Module::get_url_target() ),
					$image
				);

			} else {

				printf(
					'<div class="scm-image__container" style="padding-bottom:%d%%">%s</div>',
					(float) (new SC_Image_Module())->get_aspect_ratio(),
					$image
				);

			}


			$caption = SC_Image_Module::get_caption();

			if( false !== $caption ) {

				printf( '<span class="scm-image__caption">%s</span>', esc_html( $caption ) );

			}
			
		} else {

			echo '<p class="scm-image__error">Oops, No image found.</p>';

		}

	?>
</section>