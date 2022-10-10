<?php if (! defined('ABSPATH')) die('No direct access allowed'); ?>
<section class="<?php echo implode( ' ', SCM()->get_module_classes( $module ) ); ?>" id="<?php echo esc_attr( $module['module_id'] ); ?>">
	<?php
		
		SC_Modules::view()->display_modules([
			'modules'         => $module['submodules'],
			'container_open'  => '',
			'container_close' => ''
		]);

	?>
</section>
